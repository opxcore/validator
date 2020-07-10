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

use OpxCore\Validator\Rules\IpRule;
use PHPUnit\Framework\TestCase;

class IpRuleTest extends TestCase
{

    public function testCheck(): void
    {
        $rule = new IpRule;

        $this->assertTrue($rule->check('ip', [], []));
        $this->assertFalse($rule->check('ip', ['ip' => null], []));
        $this->assertFalse($rule->check('ip', ['ip' => 42], []));

        $this->assertTrue($rule->check('ip', ['ip' => '127.0.0.1'], []));
        $this->assertTrue($rule->check('ip', ['ip' => '127.0.0.1'], ['v4']));
        $this->assertFalse($rule->check('ip', ['ip' => '127.0.0.1'], ['v6']));
        $this->assertTrue($rule->check('ip', ['ip' => '127.0.0.1'], ['v4', 'v6']));

        $this->assertTrue($rule->check('ip', ['ip' => '::1'], []));
        $this->assertFalse($rule->check('ip', ['ip' => '::1'], ['v4']));
        $this->assertTrue($rule->check('ip', ['ip' => '::1'], ['v6']));
        $this->assertTrue($rule->check('ip', ['ip' => '::1'], ['v4', 'v6']));
    }
}
