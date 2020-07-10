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

use OpxCore\Validator\Exceptions\InvalidParameterException;
use OpxCore\Validator\Exceptions\InvalidParametersCountException;

trait HasBoolCondition
{
    /** @var bool|callable|null Condition to check alternately to parameters. */
    protected $condition;

    /**
     * Constructor.
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
     * Get condition value.
     *
     * @return  bool
     *
     * @throws  InvalidParameterException
     */
    protected function formCondition(): bool
    {
        if (is_callable($this->condition)) {
            $condition = call_user_func($this->condition);
        } else {
            $condition = $this->condition;
        }

        if (!is_bool($condition)) {
            throw new InvalidParameterException('Condition must be type of bool or callable returning true or false.');
        }

        return $condition;
    }

    /**
     * Whether condition is set.
     *
     * @return  bool
     */
    protected function hasCondition(): bool
    {
        return $this->condition !== null;
    }

    /**
     * Get formed condition.
     *
     * @param string $ruleName
     * @param string $key
     * @param int $count
     * @param array $parameters
     * @param array $data
     *
     * @return  bool
     *
     * @throws  InvalidParameterException
     * @throws  InvalidParametersCountException
     */
    protected function getCondition(string $ruleName, string $key, int $count, array $parameters, array $data): bool
    {
        if ($this->hasCondition()) {

            return $this->formCondition();
        }

        // If condition not set use parameters
        $this->checkParametersCount($ruleName, $key, $count, $parameters);

        return array_key_exists($parameters[0], $data) && ($data[$parameters[0]] === $parameters[1]);
    }
}