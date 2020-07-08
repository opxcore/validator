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

trait ChecksInRange
{
    /**
     * Check value in range.
     *
     * @param float $value
     * @param string $first
     * @param string|null $second
     *
     * @return  bool
     */
    protected function checkRange(float $value, string $first, ?string $second = null): bool
    {
        if ($second === null) {
            return $this->checkValueAgainstSingle($value, $first);
        }

        return $this->checkValueAgainstSingle($value, $first, '>=') && $this->checkValueAgainstSingle($value, $second, '<=');
    }

    /**
     * Check value against single parameter.
     *
     * @param float $value
     * @param string $comparision
     * @param string $operatorOverride
     *
     * @return  bool
     */
    private function checkValueAgainstSingle(float $value, string $comparision, string $operatorOverride = '='): bool
    {
        if (empty($comparision)) {
            return true;
        }

        [$operator, $compareTo] = $this->explodeComparision($comparision);

        $operator ??= $operatorOverride;
        $compareTo = (float)$compareTo;

        if ($operator === '>') {
            return $value > $compareTo;
        }

        if ($operator === '>=') {
            return $value >= $compareTo;
        }
        if ($operator === '<') {
            return $value < $compareTo;
        }
        if ($operator === '<=') {
            return $value <= $compareTo;
        }

        return $value === $compareTo;
    }

    /**
     * Explode comparision to operator and value.
     *
     * @param $comparision
     *
     * @return  array
     */
    private function explodeComparision($comparision): array
    {
        $operator = null;

        if (strpos($comparision, '<=') === 0) {
            $operator = '<=';
        } else if (strpos($comparision, '>=') === 0) {
            $operator = '>=';
        } else if (strpos($comparision, '<') === 0) {
            $operator = '<';
        } else if (strpos($comparision, '>') === 0) {
            $operator = '>';
        }

        return [$operator, str_replace(['<', '>', '='], '', $comparision)];
    }
}