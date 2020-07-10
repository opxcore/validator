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

class BooleanRule implements Rule
{
    /**
     * The field under validation must be able to be cast as boolean. Accepted are true, false, 1, 0, "1", and "0".
     *
     * @param string $key
     * @param array $data
     * @param array $parameters
     *
     * @return  bool
     */
    public function check(string $key, array $data = [], array $parameters = []): bool
    {
        return !array_key_exists($key, $data) || in_array($data[$key], [true, false, 0, 1, '0', '1'], true);
    }
}