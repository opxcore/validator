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

use OpxCore\Validator\Rules\IntegerRule;
use PHPUnit\Framework\TestCase;

class IntegerRuleTest extends TestCase
{

    public function testCheck(): void
    {
        $rule = new IntegerRule;

        $this->assertTrue($rule->check('test', ['test' => 0]));
        $this->assertTrue($rule->check('test', ['test' => '0']));
        $this->assertTrue($rule->check('test', ['test' => 100]));
        $this->assertTrue($rule->check('test', ['test' => '100']));
        $this->assertTrue($rule->check('test', ['test' => -100]));
        $this->assertTrue($rule->check('test', ['test' => '-100']));
        $this->assertTrue($rule->check('test', ['wrong' => 3]));

        $this->assertFalse($rule->check('test', ['test' => null]));
        $this->assertFalse($rule->check('test', ['test' => []]));
        $this->assertFalse($rule->check('test', ['test' => 12.3]));
        $this->assertFalse($rule->check('test', ['test' => -12.3]));
        $this->assertFalse($rule->check('test', ['test' => 'string']));
    }
}
