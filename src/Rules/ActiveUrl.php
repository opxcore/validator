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

class ActiveUrl implements Rule
{
    /**
     * Check if value is an active URL by retrieving given url headers (with redirects flow) for 200 status code.
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

        if (!is_string($value = $data[$key])) {
            return false;
        }

        $headers = @get_headers($value);

        if ($headers === false) {
            return false;
        }

        foreach ($headers as $header) {
            // find 200 response in case of redirects
            if (preg_match("/^HTTP.+\s(\d\d\d)\s/", $header, $m) && ($m[1] === '200')) {
                return true;
            }
        }

        return false;
    }
}