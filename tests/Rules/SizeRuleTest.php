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

use OpxCore\Validator\Rules\SizeRule;
use PHPUnit\Framework\TestCase;
use SplFileInfo;

class SizeRuleTest extends TestCase
{
    protected string $fixPath = __DIR__ . '/Fixtures';

    public function testCheck(): void
    {
        $rule = new SizeRule;
        $data['file'] = new SplFileInfo($this->fixPath . '/image.jpeg');

        $this->assertTrue($rule->check('file', $data, ['>1']));
        $this->assertTrue($rule->check('file', $data, ['<15']));
        $this->assertTrue($rule->check('file', $data, ['>1', '<15']));

        $this->assertFalse($rule->check('file', $data, ['<3']));
        $this->assertFalse($rule->check('file', $data, ['>15']));
        $this->assertFalse($rule->check('file', $data, ['>10', '<15']));
    }
}
