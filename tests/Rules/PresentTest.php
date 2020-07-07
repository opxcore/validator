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

use OpxCore\Validator\Rules\PresentRule;
use PHPUnit\Framework\TestCase;

class PresentTest extends TestCase
{

    public function testCheck():void
    {
        $rule = new PresentRule;

        $this->assertTrue($rule->check('name', ['name' => 'yes']));
        $this->assertTrue($rule->check('name', ['name' => 0]));
        $this->assertTrue($rule->check('name', ['name' => true]));
        $this->assertTrue($rule->check('name', ['name' => null]));

        $this->assertFalse($rule->check('name', []));
        $this->assertFalse($rule->check('name', ['not_name' => false]));
    }
}
