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

use SplFileInfo;

trait ChecksNotEmpty
{
    /**
     * Checks the value is not empty.
     *
     * @param $value
     *
     * @return  bool
     */
    protected function notEmpty($value): bool
    {
        if ($value === null) {
            return false;
        }

        if (is_string($value)) {
            return trim($value) !== '';
        }

        if (is_countable($value)) {
            return count($value) > 0;
        }

        if ($value instanceof SplFileInfo) {
            return $value->getFilename() !== '';
        }

        return true;
    }
}