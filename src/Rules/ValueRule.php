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
use OpxCore\Validator\Rules\Traits\ChecksInRange;

class ValueRule implements Rule
{
    use ChecksParametersCount,
        ChecksInRange;

    /**
     * The field under validation must must be numeric and have value passing comparision rules.
     *
     * @param string $key
     * @param array $data
     * @param array $parameters
     *
     * @return  bool
     */
    public function check(string $key, array $data = [], array $parameters = []): bool
    {
        $this->checkParametersCount('value', $key, 1, $parameters);

        return !array_key_exists($key, $data) ||
            (is_numeric($data[$key]) &&
                $this->checkRange((float)$data[$key], $parameters[0], $parameters[1] ?? null));
    }
}