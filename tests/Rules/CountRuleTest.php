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

use OpxCore\Validator\Rules\CountRule;
use PHPUnit\Framework\TestCase;

class CountRuleTest extends TestCase
{

    public function testCheck(): void
    {
        $rule = new CountRule;

        $this->assertTrue($rule->check('num', ['num' => [1, 2, 3]], ['3']));
        $this->assertTrue($rule->check('num', ['num' => [1, 2, 3]], ['>=3']));
        $this->assertTrue($rule->check('num', ['num' => [1, 2, 3]], ['<=3']));
        $this->assertTrue($rule->check('num', ['num' => []], ['>=0']));

        $this->assertFalse($rule->check('num', ['num' => []], ['>0']));
        $this->assertFalse($rule->check('num', ['num' => [1, 2, 3]], ['4']));
        $this->assertFalse($rule->check('num', ['num' => [1, 2, 3]], ['>3']));
        $this->assertFalse($rule->check('num', ['num' => [1, 2, 3]], ['<3']));

        $this->assertTrue($rule->check('num', ['num' => [1, 2, 3]], ['>2', '3']));
        $this->assertTrue($rule->check('num', ['num' => [1, 2, 3]], ['>=3', '6']));
        $this->assertTrue($rule->check('num', ['num' => [1, 2, 3]], ['0', '<=3']));
        $this->assertTrue($rule->check('num', ['num' => []], ['>=0', '4']));

        $this->assertFalse($rule->check('num', ['num' => []], ['1', '6']));
        $this->assertFalse($rule->check('num', ['num' => [1, 2, 3]], ['>3','<6']));
        $this->assertFalse($rule->check('num', ['num' => [1, 2, 3]], ['0','<3']));
    }
}
