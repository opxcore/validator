<?php

/**
 * This file is part of the OpxCore.
 *
 * Copyright (c) Lozovoy Vyacheslav <opxcore@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace OpxCore\Validator\Rules;

use OpxCore\Validator\Interfaces\Rule;

class Confirmed implements Rule
{
    /**
     * The field under validation must have a matching {field}_confirmation field when it is present.
     *
     * @param string $key
     * @param array $data
     * @param array $parameters
     *
     * @return  bool
     */
    public function check(string $key, array $data = [], array $parameters = []): bool
    {
        return !array_key_exists($key, $data) ||
            (array_key_exists("{$key}_confirmation", $data) && ($data[$key] === $data["{$key}_confirmation"]));
    }
}