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

use OpxCore\Validator\Rules\RequiredWithAll;
use PHPUnit\Framework\TestCase;

class RequiredWithAllTest extends TestCase
{
    public function testCheck(): void
    {
        $rule = new RequiredWithAll();

        $data = [
            'foo' => 'yes',
            'bar' => true,
            'baz' => null,
        ];

        // present and no empty
        $this->assertTrue($rule->check('foo', $data, ['bar', 'baz']));
        $this->assertTrue($rule->check('foo', $data, ['bar', 'che']));
        $this->assertTrue($rule->check('foo', $data, ['bum', 'che']));

        // present and empty
        $this->assertFalse($rule->check('baz', $data, ['foo', 'bar']));
        $this->assertTrue($rule->check('baz', $data, ['foo', 'che']));
        $this->assertTrue($rule->check('baz', $data, ['bum', 'che']));

        // not present
        $this->assertFalse($rule->check('bum', $data, ['foo', 'bar']));
        $this->assertTrue($rule->check('bum', $data, ['foo', 'che']));
        $this->assertTrue($rule->check('bum', $data, ['bum', 'che']));
    }
}
