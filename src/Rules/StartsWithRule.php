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

use OpxCore\Validator\Exceptions\InvalidParameterException;
use OpxCore\Validator\Exceptions\InvalidParametersCountException;
use OpxCore\Validator\Interfaces\Rule;
use OpxCore\Validator\Rules\Traits\ChecksParametersCount;
use OpxCore\Validator\Rules\Traits\HasIterableCondition;

class StartsWithRule implements Rule
{
    use ChecksParametersCount,
        HasIterableCondition;

    /**
     * The field under validation must be string and start with one of the given values.
     *
     * @param string $key
     * @param array $data
     * @param array $parameters
     *
     * @return  bool
     *
     * @throws  InvalidParametersCountException
     * @throws  InvalidParameterException
     */
    public function check(string $key, array $data = [], array $parameters = []): bool
    {
        if (!array_key_exists($key, $data)) {
            return true;
        }

        if (!is_string($data[$key])) {
            return false;
        }

        $tokens = $this->getTokens('starts_with', $key, 1, $parameters);

        foreach ($tokens as $token) {
            if (is_string($token) && mb_strpos($data[$key], $token) === 0) {
                return true;
            }
        }

        return false;
    }
}