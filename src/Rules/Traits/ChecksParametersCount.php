<?php

/**
 * This file is part of the OpxCore.
 *
 * Copyright (c) Lozovoy Vyacheslav <opxcore@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace OpxCore\Validator\Rules\Traits;

use OpxCore\Validator\Exceptions\InvalidParametersCountException;

trait ChecksParametersCount
{
    /**
     * Require a certain number of parameters to be present.
     *
     * @param string $rule
     * @param string $key
     * @param int $count
     * @param array $parameters
     *
     * @return void
     *
     * @throws InvalidParametersCountException
     */
    protected function checkParametersCount(string $rule, string $key, int $count, array $parameters): void
    {
        if (count($parameters) < $count) {
            throw new InvalidParametersCountException("Validation rule [$rule] for [$key] requires at least $count parameters.");
        }
    }
}