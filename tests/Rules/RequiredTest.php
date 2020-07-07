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

use OpxCore\Validator\Rules\RequiredRule;
use PHPUnit\Framework\TestCase;
use SplFileInfo;

class RequiredTest extends TestCase
{

    public function testCheck(): void
    {
        $rule = new RequiredRule;

        $this->assertTrue($rule->check('name', ['name' => 'yes']));
        $this->assertTrue($rule->check('name', ['name' => 1]));
        $this->assertTrue($rule->check('name', ['name' => true]));
        $this->assertTrue($rule->check('name', ['name' => ['true']]));
        $this->assertTrue($rule->check('name', ['name' => false]));
        $this->assertTrue($rule->check('name', ['name' => new SplFileInfo('path')]));

        $this->assertFalse($rule->check('name', []));
        $this->assertFalse($rule->check('name', ['name' => null]));
        $this->assertFalse($rule->check('name', ['name' => '']));
        $this->assertFalse($rule->check('name', ['name' => '  ']));
        $this->assertFalse($rule->check('name', ['name' => []]));
        $this->assertFalse($rule->check('name', ['name' => new SplFileInfo('')]));
    }
}
