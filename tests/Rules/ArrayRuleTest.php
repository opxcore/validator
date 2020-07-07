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

use OpxCore\Validator\Rules\ArrayRule;
use PHPUnit\Framework\TestCase;

class ArrayRuleTest extends TestCase
{

    public function testCheck(): void
    {
        $rule = new ArrayRule;

        $this->assertTrue($rule->check('test', ['test' => ['array' => 'test']]));
        $this->assertTrue($rule->check('test', ['test' => []]));
        $this->assertTrue($rule->check('test', ['wrong' => []]));

        $this->assertFalse($rule->check('test', ['test' => null]));
        $this->assertFalse($rule->check('test', ['test' => 12]));
        $this->assertFalse($rule->check('test', ['test' => 'string']));
    }
}
