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

use OpxCore\Validator\Rules\FileRule;
use PHPUnit\Framework\TestCase;
use SplFileInfo;

class FileRuleTest extends TestCase
{
    protected string $fixPath = __DIR__ . '/Fixtures';

    public function testCheck(): void
    {
        $rule = new FileRule;
        $file = new SplFileInfo($this->fixPath . '/image.jpeg');

        $this->assertTrue($rule->check('file', ['file' => $file]));
        $this->assertTrue($rule->check('file', []));

        $this->assertFalse($rule->check('file', ['file' => null]));
        $this->assertFalse($rule->check('file', ['file' => []]));
        $this->assertFalse($rule->check('file', ['file' => 'file']));
    }
}
