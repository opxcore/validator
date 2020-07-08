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

use OpxCore\Validator\Rules\LengthRule;
use PHPUnit\Framework\TestCase;

class LengthRuleTest extends TestCase
{

    public function testCheck(): void
    {
        $rule = new LengthRule;

        $this->assertTrue($rule->check('num', ['num' => '0123456789'], ['10']));
        $this->assertTrue($rule->check('num', ['num' => '0123456789'], ['>=10']));
        $this->assertTrue($rule->check('num', ['num' => '0123456789'], ['<=10']));
        $this->assertFalse($rule->check('num', ['num' => '012345678'], ['10']));
        $this->assertFalse($rule->check('num', ['num' => '012345678'], ['>=10']));
        $this->assertFalse($rule->check('num', ['num' => '012345678910'], ['<=10']));

        $this->assertTrue($rule->check('num', ['num' => '0123456789'], ['>=10', '<20']));
        $this->assertTrue($rule->check('num', ['num' => '0123456789'], ['>9', '<11']));
        $this->assertTrue($rule->check('num', ['num' => '0123456789'], ['10', '20']));
        $this->assertTrue($rule->check('num', ['num' => '0123456789'], ['8', '11']));
        $this->assertFalse($rule->check('num', ['num' => '0123456789'], ['11', '<20']));
        $this->assertFalse($rule->check('num', ['num' => '0123456789'], ['>10', '11']));
        $this->assertFalse($rule->check('num', ['num' => '012345678'], ['10', '<12']));

        $this->assertFalse($rule->check('num', ['num' => 10], ['>0', '<12']));

        $this->assertTrue($rule->check('num', ['num' => mb_convert_encoding('тест', 'Windows-1251')], ['4', '4', 'Windows-1251']));
        $this->assertFalse($rule->check('num', ['num' => mb_convert_encoding('тест', 'Windows-1251')], ['4', '4']));
        $this->assertFalse($rule->check('num', ['num' => 'тест'], ['4', '4', 'Windows-1251']));
    }
}
