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

class RequiredIf implements Rule
{
    use ChecksNotEmpty,
        ChecksParametersCount;

    /** @var bool|callable|null Condition to check alternately to parameters. */
    protected $condition;

    /**
     * RequiredIf constructor.
     *
     * @param bool|callable|null $condition
     *
     * @return  void
     *
     * @throws  InvalidParameterException
     */
    public function __construct($condition = null)
    {
        if (!is_bool($condition) && !is_callable($condition) && !is_null($condition)) {
            throw new InvalidParameterException('Type mismatch. Condition must be type of boolean, callable or null.');
        }

        $this->condition = $condition;
    }

    /**
     * The field under validation must not be empty when it is present.
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
        $condition = false;

        if ($this->condition === null) {
            // If condition not set use parameters
            $this->checkParametersCount('required_if', $key, 2, $parameters);
            $condition = array_key_exists($parameters[0], $data) && ($data[$parameters[0]] === $parameters[1]);

        } else if (is_bool($this->condition)) {
            // If condition is boolean just use it
            $condition = $this->condition;

        } else if (is_callable($this->condition)) {
            // And if condition is callable evolute its value.
            $condition = call_user_func($this->condition);

            if (!is_bool($condition)) {
                throw new InvalidParameterException('Callable must return true or false.');
            }
        }

        return array_key_exists($key, $data) && $this->notEmpty($data[$key]) && $condition;
    }
}