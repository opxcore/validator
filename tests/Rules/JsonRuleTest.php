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

use OpxCore\Validator\Rules\JsonRule;
use PHPUnit\Framework\TestCase;

class JsonRuleTest extends TestCase
{

    public function testCheck(): void
    {
        $rule = new JsonRule;

        $this->assertTrue($rule->check('json', []));
        $this->assertTrue($rule->check('json', ['json' => '[]']));
        $this->assertTrue($rule->check('json', ['json' => '{"name":"Jane","age":42}']));

        $this->assertFalse($rule->check('json', ['json' => null]));
        $this->assertFalse($rule->check('json', ['json' => 'Jane']));
        $this->assertFalse($rule->check('json', ['json' => "{'name':'Jane','age':42}"]));
    }
}
