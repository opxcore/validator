<?php
/**
 * This file is part of the OpxCore.
 *
 * Copyright (c) Lozovoy Vyacheslav <opxcore@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace OpxCore\Tests\Validator\Rules\Traits;

use OpxCore\Validator\Rules\Traits\ChecksInRange;
use PHPUnit\Framework\TestCase;

class ChecksInRangeTest extends TestCase
{
    use ChecksInRange;

    public function testSingleParameter(): void
    {
        $this->assertTrue($this->checkRange(10, ''));

        $this->assertTrue($this->checkRange(10, '10'));
        $this->assertTrue($this->checkRange(10, '>=10'));
        $this->assertTrue($this->checkRange(10, '<=10'));
        $this->assertTrue($this->checkRange(9.99, '9.99'));
        $this->assertTrue($this->checkRange(-9.99, '-9.99'));
        $this->assertFalse($this->checkRange(9.99, '10'));
        $this->assertFalse($this->checkRange(-9.99, '-10'));
        $this->assertFalse($this->checkRange(10, '>10'));
        $this->assertFalse($this->checkRange(10, '<10'));
        $this->assertFalse($this->checkRange(-9.99, '>-9.99'));
        $this->assertFalse($this->checkRange(-9.99, '<-9.99'));
    }

    public function testTwoParameters(): void
    {
        $this->assertFalse($this->checkRange(-5, '10', '20'));
        $this->assertTrue($this->checkRange(10, '10', '20'));
        $this->assertTrue($this->checkRange(12.99, '10', '20'));
        $this->assertTrue($this->checkRange(20, '10', '20'));
        $this->assertFalse($this->checkRange(20.00001, '10', '20'));

        $this->assertFalse($this->checkRange(-9.991, '>-9.99', '9.99'));
        $this->assertFalse($this->checkRange(-9.99, '>-9.99', '9.99'));
        $this->assertTrue($this->checkRange(-9.989, '>-9.99', '9.99'));

        $this->assertFalse($this->checkRange(-9.991, '>=-9.99', '9.99'));
        $this->assertTrue($this->checkRange(-9.99, '>=-9.99', '9.99'));
        $this->assertTrue($this->checkRange(-9.989, '>=-9.99', '9.99'));

        $this->assertTrue($this->checkRange(9.989, '-9.99', '<9.99'));
        $this->assertFalse($this->checkRange(9.99, '-9.99', '<9.99'));
        $this->assertFalse($this->checkRange(9.991, '-9.99', '<9.99'));

        $this->assertTrue($this->checkRange(9.989, '-9.99', '<=9.99'));
        $this->assertTrue($this->checkRange(9.990, '-9.99', '<=9.99'));
        $this->assertFalse($this->checkRange(9.99001, '-9.99', '<=9.99'));
    }
}
