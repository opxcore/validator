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

use OpxCore\Validator\Rules\FormatRule;
use PHPUnit\Framework\TestCase;

class FormatRuleTest extends TestCase
{

    public function testCheck(): void
    {
        $rule = new FormatRule;

        $this->assertTrue($rule->check('text', [], ['alpha']));

        $this->assertFalse($rule->check('text', ['text' => null], ['alpha']));
        $this->assertFalse($rule->check('text', ['text' => []], ['alpha']));
        $this->assertFalse($rule->check('text', ['text' => 42], ['alpha']));

        $this->assertTrue($rule->check('text', ['text' => 'ёпрст'], ['alpha']));
        $this->assertTrue($rule->check('text', ['text' => 'flower'], ['alpha']));

        $this->assertFalse($rule->check('text', ['text' => 'some mistake'], ['alpha']));
        $this->assertTrue($rule->check('text', ['text' => 'some mistake'], ['alpha', 'space']));

        $this->assertFalse($rule->check('text', ['text' => 'some 42 mistake'], ['alpha', 'space']));
        $this->assertTrue($rule->check('text', ['text' => 'some 42 mistake'], ['alpha', 'space', 'num']));

        $this->assertFalse($rule->check('text', ['text' => 'some 42 big-mistake'], ['alpha', 'space', 'num']));
        $this->assertTrue($rule->check('text', ['text' => 'some 42 big-mistake'], ['alpha', 'space', 'num', 'dash']));

        $this->assertFalse($rule->check('text', ['text' => 'some 4/2 big-mistake'], ['alpha', 'space', 'num', 'dash']));
        $this->assertTrue($rule->check('text', ['text' => 'some 4/2 big-mistake'], ['alpha', 'space', 'num', 'dash', 'slash']));

        $this->assertFalse($rule->check('text', ['text' => 'some 4/2 big-mis_take'], ['alpha', 'space', 'num', 'dash']));
        $this->assertTrue($rule->check('text', ['text' => 'some 4/2 big-mis_take'], ['alpha', 'space', 'num', 'dash', 'slash', 'underscore']));
    }
}
