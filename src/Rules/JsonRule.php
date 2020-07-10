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

class JsonRule implements Rule
{
    /**
     * The field under validation must be a valid JSON string.
     *
     * @param string $key
     * @param array $data
     * @param array $parameters
     *
     * @return  bool
     */
    public function check(string $key, array $data = [], array $parameters = []): bool
    {
        if (!array_key_exists($key, $data)) {
            return true;
        }

        if (!is_scalar($data[$key]) && !method_exists($data[$key], '__toString')) {
            return false;
        }

        json_decode($data[$key]);

        return json_last_error() === JSON_ERROR_NONE;
    }
}