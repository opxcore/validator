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
use DateTimeInterface;

class DateRule implements Rule
{
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
        if (!array_key_exists($key, $data) || $data[$key] instanceof DateTimeInterface) {
            return true;
        }

        if ((!is_string($data[$key]) && !is_numeric($data[$key])) || strtotime($data[$key]) === false) {
            return false;
        }

        $date = date_parse($data[$key]);

        return checkdate($date['month'], $date['day'], $date['year']);
    }
}