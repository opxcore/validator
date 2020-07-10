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

use OpxCore\Validator\Exceptions\InvalidParametersCountException;
use OpxCore\Validator\Interfaces\Rule;
use OpxCore\Validator\Rules\Traits\ChecksNotEmpty;
use OpxCore\Validator\Rules\Traits\ChecksParametersCount;

class RequiredWithRule implements Rule
{
    use ChecksNotEmpty,
        ChecksParametersCount;

    /**
     * The field under validation must be present and not empty only if any of the other specified fields are present.
     *
     * @param string $key
     * @param array $data
     * @param array $parameters
     *
     * @return  bool
     *
     * @throws  InvalidParametersCountException
     */
    public function check(string $key, array $data = [], array $parameters = []): bool
    {
        $this->checkParametersCount('required_with', $key, 1, $parameters);

        $hasOne = false;

        foreach ($parameters as $parameter) {
            if (array_key_exists($parameter, $data)) {
                $hasOne = true;
                continue;
            }
        }

        return !$hasOne || (array_key_exists($key, $data) && $this->notEmpty($data[$key]));
    }
}