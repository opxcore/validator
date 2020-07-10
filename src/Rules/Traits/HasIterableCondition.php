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

trait HasIterableCondition
{
    /** @var array|callable|null Tokens to use alternately to parameters. */
    protected $tokens;

    /**
     * Constructor.
     *
     * @param array|callable|null $tokens
     *
     * @return  void
     *
     * @throws  InvalidParameterException
     */
    public function __construct($tokens = null)
    {
        if (!is_iterable($tokens) && !is_callable($tokens) && !is_null($tokens)) {
            throw new InvalidParameterException('Type mismatch. Condition must be type of iterable, callable or null.');
        }

        $this->tokens = $tokens;
    }

    /**
     * Get condition value.
     *
     * @return  iterable
     *
     * @throws  InvalidParameterException
     */
    protected function formTokens(): iterable
    {
        if (is_callable($this->tokens)) {
            $condition = call_user_func($this->tokens);
        } else {
            $condition = $this->tokens;
        }

        if (!is_iterable($condition)) {
            throw new InvalidParameterException('Condition must be type of array, iterable or callable returning true or false.');
        }

        return $condition;
    }

    /**
     * Whether condition is set.
     *
     * @return  bool
     */
    protected function hasTokens(): bool
    {
        return $this->tokens !== null;
    }

    /**
     * Get formed conditions.
     *
     * @param string $ruleName
     * @param string $key
     * @param int $count
     * @param array $parameters
     *
     * @return  iterable
     *
     * @throws  InvalidParameterException
     * @throws  InvalidParametersCountException
     */
    protected function getTokens(string $ruleName, string $key, int $count, array $parameters): iterable
    {
        if ($this->hasTokens()) {

            return $this->formTokens();
        }

        // If condition not set use parameters
        $this->checkParametersCount($ruleName, $key, $count, $parameters);

        return $parameters;
    }
}