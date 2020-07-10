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

trait HasIterableCondition
{
    /** @var array|callable|null Condition to check alternately to parameters. */
    protected $condition;

    /**
     * Constructor.
     *
     * @param array|callable|null $condition
     *
     * @return  void
     *
     * @throws  InvalidParameterException
     */
    public function __construct($condition = null)
    {
        if (!is_iterable($condition) && !is_callable($condition) && !is_null($condition)) {
            throw new InvalidParameterException('Type mismatch. Condition must be type of iterable, callable or null.');
        }

        $this->condition = $condition;
    }

    /**
     * Get condition value.
     *
     * @return  iterable
     *
     * @throws  InvalidParameterException
     */
    protected function evoluteCondition(): iterable
    {
        if (is_callable($this->condition)) {
            $condition = call_user_func($this->condition);
        } else {
            $condition = $this->condition;
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
    protected function hasCondition(): bool
    {
        return $this->condition !== null;
    }
}