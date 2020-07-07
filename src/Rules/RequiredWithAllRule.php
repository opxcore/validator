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
use OpxCore\Validator\Rules\Traits\ChecksNotEmpty;
use OpxCore\Validator\Rules\Traits\ChecksParametersCount;

class RequiredWithAllRule implements Rule
{
    use ChecksNotEmpty,
        ChecksParametersCount;

    /**
     * The field under validation must be present and not empty only if all of the other specified fields are present.
     *
     * @param string $key
     * @param array $data
     * @param array $parameters
     *
     * @return  bool
     */
    public function check(string $key, array $data = [], array $parameters = []): bool
    {
        $this->checkParametersCount('required_with_all', $key, 1, $parameters);

        $hasAll = true;

        foreach ($parameters as $parameter) {
            if (!array_key_exists($parameter, $data)) {
                $hasAll = false;
                continue;
            }
        }

        return !$hasAll || (array_key_exists($key, $data) && $this->notEmpty($data[$key]));
    }
}