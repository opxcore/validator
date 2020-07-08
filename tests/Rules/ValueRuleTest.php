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

use OpxCore\Validator\Rules\ValueRule;
use PHPUnit\Framework\TestCase;

class ValueRuleTest extends TestCase
{

    public function testCheck(): void
    {
        $rule = new ValueRule;

        $this->assertTrue($rule->check('num', ['num' => '10'], ['10']));
        $this->assertTrue($rule->check('num', ['num' => 10], ['10']));
        $this->assertTrue($rule->check('num', ['num' => 10], ['>=10']));
        $this->assertTrue($rule->check('num', ['num' => 10], ['<=10']));
        $this->assertFalse($rule->check('num', ['num' => 8], ['10']));
        $this->assertFalse($rule->check('num', ['num' => 8], ['>=10']));
        $this->assertFalse($rule->check('num', ['num' => 12], ['<=10']));

        $this->assertTrue($rule->check('num', ['num' => 10], ['>=10', '<20']));
        $this->assertTrue($rule->check('num', ['num' => '10.0000001'], ['>10', '<10.1']));
        $this->assertTrue($rule->check('num', ['num' => 10], ['10', '20']));
        $this->assertTrue($rule->check('num', ['num' => 10], ['8', '11']));
        $this->assertFalse($rule->check('num', ['num' => 8], ['10', '<20']));
        $this->assertFalse($rule->check('num', ['num' => 8], ['>8', '10']));
        $this->assertFalse($rule->check('num', ['num' => 12], ['10', '<12']));
    }
}
