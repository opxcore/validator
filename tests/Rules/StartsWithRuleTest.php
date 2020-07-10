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
use OpxCore\Validator\Rules\StartsWithRule;
use PHPUnit\Framework\TestCase;
use ArrayIterator;

class StartsWithRuleTest extends TestCase
{

    public function testCheck(): void
    {
        $rule = new StartsWithRule;

        $this->assertTrue($rule->check('text', [], ['som']));
        $this->assertTrue($rule->check('text', ['text' => 'some awesome text'], ['som']));
        $this->assertTrue($rule->check('text', ['text' => 'some awesome text'], ['awe', 'som']));

        $this->assertFalse($rule->check('text', ['text' => null], []));
        $this->assertFalse($rule->check('text', ['text' => null], ['som']));
        $this->assertFalse($rule->check('text', ['text' => 'some awesome text'], ['sam']));
        $this->assertFalse($rule->check('text', ['text' => []], ['sam']));

        $this->expectException(InvalidParametersCountException::class);
        $this->assertTrue($rule->check('text', ['text' => 'some awesome text']));
    }

    public function testCheckConditionArray(): void
    {
        $rule = new StartsWithRule(['awe', 'som']);

        $this->assertTrue($rule->check('text', ['text' => 'some awesome text']));
        $this->assertFalse($rule->check('text', ['text' => 'same awesome text']));
    }

    public function testCheckConditionCallback(): void
    {
        $rule = new StartsWithRule(fn() => ['awe', 'som']);

        $this->assertTrue($rule->check('text', ['text' => 'some awesome text']));
        $this->assertFalse($rule->check('text', ['text' => 'same awesome text']));
    }

    public function testCheckConditionIterable(): void
    {
        $rule = new StartsWithRule(new ArrayIterator(['awe', 'som']));

        $this->assertTrue($rule->check('text', ['text' => 'some awesome text']));
        $this->assertFalse($rule->check('text', ['text' => 'same awesome text']));
    }

    public function testCheckConditionWrong(): void
    {
        $this->expectException(InvalidParameterException::class);
        new StartsWithRule('som');
    }

    public function testCheckConditionCallbackWrong(): void
    {
        $rule = new StartsWithRule(fn() => 'som');

        $this->expectException(InvalidParameterException::class);
        $this->assertTrue($rule->check('text', ['text' => 'some awesome text']));
    }
}
