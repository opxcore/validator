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

class Accepted implements Rule
{
    /**
     * The field under validation must be equal to 'yes', 'on', '1', 1, true, 'true' when it is present.
     *
     * @param string $key
     * @param array $data
     * @param array $parameters
     *
     * @return  bool
     */
    public function check(string $key, array $data = [], array $parameters = []): bool
    {
        return !array_key_exists($key, $data) || in_array($data[$key], ['yes', 'on', '1', 1, true, 'true'], true);
    }
}