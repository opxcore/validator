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
use OpxCore\Validator\Rules\EndsWithRule;
use PHPUnit\Framework\TestCase;
use ArrayIterator;

class EndsWithRuleTest extends TestCase
{

    public function testCheck(): void
    {
        $rule = new EndsWithRule;

        $this->assertTrue($rule->check('text', [], ['ext']));
        $this->assertTrue($rule->check('text', ['text' => 'some awesome text'], ['ext']));
        $this->assertTrue($rule->check('text', ['text' => 'some awesome text'], ['awe', 'ext']));

        $this->assertFalse($rule->check('text', ['text' => null], []));
        $this->assertFalse($rule->check('text', ['text' => null], ['ext']));
        $this->assertFalse($rule->check('text', ['text' => 'some awesome text'], ['sam']));
        $this->assertFalse($rule->check('text', ['text' => []], ['sam']));

        $this->expectException(InvalidParametersCountException::class);
        $this->assertTrue($rule->check('text', ['text' => 'some awesome text']));
    }

    public function testCheckConditionArray(): void
    {
        $rule = new EndsWithRule(['awe', 'ext']);

        $this->assertTrue($rule->check('text', ['text' => 'some awesome text']));
        $this->assertFalse($rule->check('text', ['text' => 'same awesome txt']));
    }

    public function testCheckConditionCallback(): void
    {
        $rule = new EndsWithRule(fn() => ['awe', 'ext']);

        $this->assertTrue($rule->check('text', ['text' => 'some awesome text']));
        $this->assertFalse($rule->check('text', ['text' => 'same awesome txt']));
    }

    public function testCheckConditionIterable(): void
    {
        $rule = new EndsWithRule(new ArrayIterator(['awe', 'ext']));

        $this->assertTrue($rule->check('text', ['text' => 'some awesome text']));
        $this->assertFalse($rule->check('text', ['text' => 'same awesome txt']));
    }

    public function testCheckConditionWrong(): void
    {
        $this->expectException(InvalidParameterException::class);
        new EndsWithRule('ext');
    }

    public function testCheckConditionCallbackWrong(): void
    {
        $rule = new EndsWithRule(fn() => 'ext');

        $this->expectException(InvalidParameterException::class);
        $this->assertTrue($rule->check('text', ['text' => 'some awesome text']));
    }
}
