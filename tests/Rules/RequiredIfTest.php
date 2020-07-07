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
use OpxCore\Validator\Rules\RequiredIfRule;
use PHPUnit\Framework\TestCase;

class RequiredIfTest extends TestCase
{
    public function testRegularCheck(): void
    {
        $rule = new RequiredIfRule;

        $this->assertTrue($rule->check('name', ['name' => 'yes', 'another' => 'test'], ['another', 'test']));

        $this->assertFalse($rule->check('name', ['name' => 'yes', 'another' => 'test'], ['another', 'wrong']));
        $this->assertFalse($rule->check('name', ['name' => 'yes'], ['another', 'wrong']));
        $this->assertFalse($rule->check('name', ['name' => null, 'another' => 'test'], ['another', 'test']));
        $this->assertFalse($rule->check('name', ['another' => 'test'], ['another', 'test']));
    }

    public function testInvalidParameters(): void
    {
        $rule = new RequiredIfRule;
        $this->expectException(InvalidParametersCountException::class);
        $rule->check('name', ['name' => 'yes', 'another' => 'test']);
    }

    public function testInvalidCondition(): void
    {
        $this->expectException(InvalidParameterException::class);
        new RequiredIfRule('invalid_type');
    }

    public function testBooleanCheck(): void
    {
        $rule = new RequiredIfRule(true);
        $this->assertTrue($rule->check('name', ['name' => 'yes']));
        $this->assertFalse($rule->check('name', ['name' => null]));
        $this->assertFalse($rule->check('name', ['wrong_name' => 'yes']));

        $rule = new RequiredIfRule(false);
        $this->assertFalse($rule->check('name', ['name' => 'yes']));
        $this->assertFalse($rule->check('name', ['name' => null]));
    }

    public function testCallableCheck(): void
    {
        $rule = new RequiredIfRule(fn() => true);
        $this->assertTrue($rule->check('name', ['name' => 'yes']));

        $rule = new RequiredIfRule(fn() => false);
        $this->assertFalse($rule->check('name', ['name' => 'yes']));

        $rule = new RequiredIfRule(fn() => 'test');
        $this->expectException(InvalidParameterException::class);
        $rule->check('name', ['name' => 'yes']);
    }
}
