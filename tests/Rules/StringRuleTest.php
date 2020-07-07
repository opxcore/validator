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

use OpxCore\Validator\Rules\StringRule;
use PHPUnit\Framework\TestCase;

class StringRuleTest extends TestCase
{

    public function testCheck(): void
    {
        $rule = new StringRule;

        $this->assertTrue($rule->check('test', ['test' => 'string']));
        $this->assertTrue($rule->check('test', ['wrong' => 'string']));

        $this->assertFalse($rule->check('test', ['test' => null]));
        $this->assertFalse($rule->check('test', ['test' => []]));
        $this->assertFalse($rule->check('test', ['test' => 12]));
    }
}
