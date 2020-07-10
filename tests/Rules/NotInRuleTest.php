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
use OpxCore\Validator\Rules\NotInRule;
use PHPUnit\Framework\TestCase;
use ArrayIterator;

class NotInRuleTest extends TestCase
{

    public function testCheck(): void
    {
        $rule = new NotInRule;

        $this->assertTrue($rule->check('in', ['in' => 'some'], ['red', 'same', 'one']));
        $this->assertTrue($rule->check('in', [], ['red', 'same', 'one']));

        $this->assertFalse($rule->check('in', ['in' => null], []));
        $this->assertFalse($rule->check('in', ['in' => null], ['some']));
        $this->assertFalse($rule->check('in', ['in' => 'some'], ['red', 'some', 'one']));
        $this->assertFalse($rule->check('in', ['in' => []], ['some']));

        $this->expectException(InvalidParametersCountException::class);
        $this->assertTrue($rule->check('in', ['in' => 'some']));
    }

    public function testCheckConditionArray(): void
    {
        $rule = new NotInRule(['awe', 'some']);

        $this->assertTrue($rule->check('in', ['in' => 'same']));
        $this->assertFalse($rule->check('in', ['in' => 'some']));
    }

    public function testCheckConditionCallback(): void
    {
        $rule = new NotInRule(fn() => ['awe', 'some']);

        $this->assertFalse($rule->check('in', ['in' => 'some']));
        $this->assertTrue($rule->check('in', ['in' => 'same']));
    }

    public function testCheckConditionIterable(): void
    {
        $rule = new NotInRule(new ArrayIterator(['awe', 'some']));

        $this->assertFalse($rule->check('in', ['in' => 'some']));
        $this->assertTrue($rule->check('in', ['in' => 'same']));
    }

    public function testCheckConditionWrong(): void
    {
        $this->expectException(InvalidParameterException::class);
        new NotInRule('some');
    }

    public function testCheckConditionCallbackWrong(): void
    {
        $rule = new NotInRule(fn() => 'some');

        $this->expectException(InvalidParameterException::class);
        $this->assertTrue($rule->check('in', ['in' => 'some']));
    }
}
