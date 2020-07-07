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

trait HasBoolCondition
{
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
     * Get condition value.
     *
     * @return  bool
     *
     * @throws  InvalidParameterException
     */
    protected function evoluteCondition(): bool
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
}