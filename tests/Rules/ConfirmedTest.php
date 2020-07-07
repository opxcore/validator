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

use OpxCore\Validator\Rules\ConfirmedRule;
use PHPUnit\Framework\TestCase;

class ConfirmedTest extends TestCase
{

    public function testCheck(): void
    {
        $rule = new ConfirmedRule;

        $this->assertTrue($rule->check('test', [
            'test' => 'pass',
            'test_confirmation' => 'pass'
        ]));

        $this->assertTrue($rule->check('test', [
            'test_not' => 'pass',
            'test_not_confirmation' => 'pass'
        ]));

        $this->assertTrue($rule->check('test', [
            'test' => '',
            'test_confirmation' => ''
        ]));

        $this->assertTrue($rule->check('test', [
            'test' => 345,
            'test_confirmation' => 345
        ]));

        $this->assertTrue($rule->check('test', [
            'test' => null,
            'test_confirmation' => null
        ]));

        $this->assertFalse($rule->check('test', [
            'test' => 'pass',
            'test_confirmation' => 'not_pass'
        ]));

        $this->assertFalse($rule->check('test', [
            'test' => 'pass',
            'not_test_confirmation' => 'pass'
        ]));

        $this->assertFalse($rule->check('test', [
            'test' => 'pass',
        ]));

        $this->assertFalse($rule->check('test', [
            'test' => '123',
            'test_confirmation' => 123
        ]));
    }
}
