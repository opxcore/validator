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

class IpRule implements Rule
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
        if (!array_key_exists($key, $data)) {
            return true;
        }

        if (!is_string($data[$key])) {
            return false;
        }

        $v4 = in_array('v4', $parameters, true);
        $v6 = in_array('v6', $parameters, true);

        if ($v4 && !$v6) {
            return filter_var($data[$key], FILTER_VALIDATE_IP, FILTER_FLAG_IPV4) !== false;
        }

        if ($v6 && !$v4) {
            return filter_var($data[$key], FILTER_VALIDATE_IP, FILTER_FLAG_IPV6) !== false;
        }

        return filter_var($data[$key], FILTER_VALIDATE_IP) !== false;
    }
}