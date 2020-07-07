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
use OpxCore\Validator\Rules\RequiredUnless;
use PHPUnit\Framework\TestCase;

class RequiredUnlessTest extends TestCase
{
    public function testRegularCheck(): void
    {
        $rule = new RequiredUnless;

        $this->assertTrue($rule->check('name', ['name' => 'yes', 'another' => 'test'], ['another', 'test']));
        $this->assertTrue($rule->check('name', ['name' => null, 'another' => 'test'], ['another', 'test']));
        $this->assertTrue($rule->check('name', ['another' => 'test'], ['another', 'test']));

        $this->assertTrue($rule->check('name', ['name' => 'yes', 'another' => 'test'], ['another', 'wrong']));
        $this->assertTrue($rule->check('name', ['name' => 'yes'], ['another', 'wrong']));

        $this->assertFalse($rule->check('name', ['name' => null, 'another' => 'test'], ['another', 'wrong']));
        $this->assertFalse($rule->check('name', ['another' => 'test'], ['another', 'wrong']));
    }

    public function testInvalidParameters(): void
    {
        $rule = new RequiredUnless;
        $this->expectException(InvalidParametersCountException::class);
        $rule->check('name', ['name' => 'yes', 'another' => 'test']);
    }

    public function testInvalidCondition(): void
    {
        $this->expectException(InvalidParameterException::class);
        new RequiredUnless('invalid_type');
    }

    public function testBooleanCheck(): void
    {
        $rule = new RequiredUnless(true);
        $this->assertTrue($rule->check('name', ['name' => 'yes']));
        $this->assertTrue($rule->check('name', ['name' => null]));

        $rule = new RequiredUnless(false);
        $this->assertTrue($rule->check('name', ['name' => 'yes']));
        $this->assertFalse($rule->check('name', ['name' => null]));
    }

    public function testCallableCheck(): void
    {
        $rule = new RequiredUnless(fn() => true);
        $this->assertTrue($rule->check('name', ['name' => 'yes']));
        $this->assertTrue($rule->check('name', ['name' => null]));

        $rule = new RequiredUnless(fn() => false);
        $this->assertTrue($rule->check('name', ['name' => 'yes']));
        $this->assertFalse($rule->check('name', ['name' => null]));

        $rule = new RequiredUnless(fn() => 'test');
        $this->expectException(InvalidParameterException::class);
        $rule->check('name', ['name' => 'yes']);
    }
}
