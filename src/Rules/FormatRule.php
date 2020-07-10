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
use OpxCore\Validator\Rules\Traits\ChecksParametersCount;

class FormatRule implements Rule
{
    use ChecksParametersCount;

    /**
     * The field under validation must be string and have count of characters passing comparision rules.
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
        $this->checkParametersCount('format', $key, 1, $parameters);

        if (!array_key_exists($key, $data)) {
            return true;
        }

        if (!is_string($data[$key])) {
            return false;
        }

        $value = $data[$key];


        // Replace symbols value may contain.
        if (in_array('alpha', $parameters, true)) {
            $value = preg_replace('/\pL/u', '', $value);
        }
        if (in_array('num', $parameters, true)) {
            $value = str_replace(['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'], '', $value);
        }
        if (in_array('dash', $parameters, true)) {
            $value = str_replace('-', '', $value);
        }
        if (in_array('underscore', $parameters, true)) {
            $value = str_replace('_', '', $value);
        }
        if (in_array('slash', $parameters, true)) {
            $value = str_replace('/', '', $value);
        }
        if (in_array('space', $parameters, true)) {
            $value = str_replace(' ', '', $value);
        }
        if (in_array('dot', $parameters, true)) {
            $value = str_replace('.', '', $value);
        }
        if (in_array('comma', $parameters, true)) {
            $value = str_replace(',', '', $value);
        }

        // If filtered value is not empty there ard disallowed symbols.
        return $value === '';
    }
}