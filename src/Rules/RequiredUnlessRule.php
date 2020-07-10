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
use OpxCore\Validator\Rules\Traits\ChecksNotEmpty;
use OpxCore\Validator\Rules\Traits\ChecksParametersCount;
use OpxCore\Validator\Rules\Traits\HasBoolCondition;

class RequiredUnlessRule implements Rule
{
    use ChecksNotEmpty,
        ChecksParametersCount,
        HasBoolCondition;

    /**
     * The field under validation inverse of `required_if`, must be present and
     * not empty if the {another_field} is not equal to the value.
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
        $condition = $this->getCondition('required_unless', $key, 2, $parameters, $data);

        return $condition || (array_key_exists($key, $data) && $this->notEmpty($data[$key]));
    }
}