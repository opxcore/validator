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

use OpxCore\Validator\Rules\DiffRule;
use PHPUnit\Framework\TestCase;

class DiffRuleTest extends TestCase
{

    public function testCheck(): void
    {
        $rule = new DiffRule;

        $this->assertFalse($rule->check('field', ['field' => 42], ['another']));
        $this->assertFalse($rule->check('field', ['field' => null, 'another' => null], ['another']));
        $this->assertFalse($rule->check('field', ['field' => 123, 'another' => 123], ['another']));
        $this->assertFalse($rule->check('field', ['field' => 2e+10, 'another' => 2e+10], ['another']));
        $this->assertFalse($rule->check('field', ['field' => 'string', 'another' => 'string'], ['another']));
        $this->assertFalse($rule->check('field', ['field' => ['test' => 'array'], 'another' => ['test' => 'array']], ['another']));

        $this->assertTrue($rule->check('field', ['another' => 42], ['another']));
        $this->assertTrue($rule->check('field', ['field' => null, 'another' => 123], ['another']));
        $this->assertTrue($rule->check('field', ['field' => 123, 'another' => null], ['another']));
        $this->assertTrue($rule->check('field', ['field' => 2e+10, 'another' => 2.1e+10], ['another']));
        $this->assertTrue($rule->check('field', ['field' => 'string', 'another' => 'text'], ['another']));
        $this->assertTrue($rule->check('field', ['field' => ['test' => 'array'], 'another' => ['array' => 'test']], ['another']));
    }
}
