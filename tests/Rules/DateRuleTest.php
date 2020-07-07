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

use OpxCore\Validator\Rules\DateRule;
use PHPUnit\Framework\TestCase;
use DateTime;
use DateTimeImmutable;

class DateRuleTest extends TestCase
{

    public function testCheck(): void
    {
        $rule = new DateRule;

        $this->assertTrue($rule->check('date', ['date' => '12.11.1999']));
        $this->assertTrue($rule->check('date', ['date' => '2000-01-01']));
        $this->assertTrue($rule->check('date', ['date' => '01/01/2000']));
        $this->assertTrue($rule->check('date', ['date' => new DateTime]));
        $this->assertTrue($rule->check('date', ['date' => new DateTimeImmutable]));

        $this->assertFalse($rule->check('date', ['date' => '1325376000']));
        $this->assertFalse($rule->check('date', ['date' => 'Not a date']));
        $this->assertFalse($rule->check('date', ['date' => ['Not', 'a', 'date']]));
    }
}
