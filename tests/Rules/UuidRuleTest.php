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

use OpxCore\Validator\Rules\UuidRule;
use PHPUnit\Framework\TestCase;

class UuidRuleTest extends TestCase
{

    public function testCheck(): void
    {
        $rule = new UuidRule;

        $this->assertTrue($rule->check('uuid', []));
        $this->assertTrue($rule->check('uuid', ['uuid' => '6ba7b812-9dad-11d1-80b4-00c04fd430c8']));
        $this->assertTrue($rule->check('uuid', ['uuid' => '6ba7b814-9dad-11d1-80b4-00c04fd430c8']));
        $this->assertTrue($rule->check('uuid', ['uuid' => '00000000-0000-0000-0000-000000000000']));

        $this->assertFalse($rule->check('uuid', ['uuid' => null]));
        $this->assertFalse($rule->check('uuid', ['uuid' => 42]));
        $this->assertFalse($rule->check('uuid', ['uuid' => 'NOT00000-0000-0000-0000-000000000000']));
    }
}
