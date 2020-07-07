<?php
/**
 * This file is part of the OpxCore.
 *
 * Copyright (c) Lozovoy Vyacheslav <opxcore@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace OpxCore\Tests\Validator\Rules;

use OpxCore\Validator\Exceptions\InvalidParameterException;
use OpxCore\Validator\Exceptions\InvalidParametersCountException;
use OpxCore\Validator\Rules\RequiredIf;
use PHPUnit\Framework\TestCase;

class RequiredIfTest extends TestCase
{
    public function testRegularCheck(): void
    {
        $rule = new RequiredIf;

        $this->assertTrue($rule->check('name', ['name' => 'yes', 'another' => 'test'], ['another', 'test']));

        $this->assertFalse($rule->check('name', ['name' => 'yes', 'another' => 'test'], ['another', 'wrong']));
        $this->assertFalse($rule->check('name', ['name' => 'yes'], ['another', 'wrong']));
        $this->assertFalse($rule->check('name', ['name' => null, 'another' => 'test'], ['another', 'test']));
        $this->assertFalse($rule->check('name', ['another' => 'test'], ['another', 'test']));
    }

    public function testInvalidParameters(): void
    {
        $rule = new RequiredIf;
        $this->expectException(InvalidParametersCountException::class);
        $rule->check('name', ['name' => 'yes', 'another' => 'test']);
    }

    public function testInvalidCondition(): void
    {
        $this->expectException(InvalidParameterException::class);
        new RequiredIf('invalid_type');
    }

    public function testBooleanCheck(): void
    {
        $rule = new RequiredIf(true);
        $this->assertTrue($rule->check('name', ['name' => 'yes']));
        $this->assertFalse($rule->check('name', ['name' => null]));
        $this->assertFalse($rule->check('name', ['wrong_name' => 'yes']));

        $rule = new RequiredIf(false);
        $this->assertFalse($rule->check('name', ['name' => 'yes']));
        $this->assertFalse($rule->check('name', ['name' => null]));
    }

    public function testCallableCheck(): void
    {
        $rule = new RequiredIf(fn() => true);
        $this->assertTrue($rule->check('name', ['name' => 'yes']));

        $rule = new RequiredIf(fn() => false);
        $this->assertFalse($rule->check('name', ['name' => 'yes']));

        $rule = new RequiredIf(fn() => 'test');
        $this->expectException(InvalidParameterException::class);
        $rule->check('name', ['name' => 'yes']);
    }
}
