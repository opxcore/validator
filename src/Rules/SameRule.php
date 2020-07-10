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
use OpxCore\Validator\Rules\Traits\ChecksParametersCount;

class SameRule implements Rule
{
    use ChecksParametersCount;

    /**
     * The field under validation must be a PHP array.
     *
     * @param string $key
     * @param array $data
     * @param array $parameters
     *
     * @return  bool
     */
    public function check(string $key, array $data = [], array $parameters = []): bool
    {
        $this->checkParametersCount('same', $key, 1, $parameters);

        return !array_key_exists($key, $data) || (array_key_exists($parameters[0], $data) && $data[$key] === $data[$parameters[0]]);
    }
}