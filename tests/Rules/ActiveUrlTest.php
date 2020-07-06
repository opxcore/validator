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

use OpxCore\Validator\Rules\ActiveUrl;
use PHPUnit\Framework\TestCase;

class ActiveUrlTest extends TestCase
{

    public function testCheck(): void
    {
        $rule = new ActiveUrl;

        $this->assertTrue($rule->check('url', ['url' => 'https://yandex.ru/']));
        $this->assertTrue($rule->check('url', ['url' => 'https://yandex.ru/search']));
        $this->assertTrue($rule->check('url', []));

        $this->assertFalse($rule->check('url', ['url' => 'https://yandex.ruuuuu/']));
        $this->assertFalse($rule->check('url', ['url' => 'https://yandex.ru/searchffffff']));
        $this->assertFalse($rule->check('url', ['url' => ['https://yandex.ru']]));
    }
}
