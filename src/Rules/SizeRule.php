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
use OpxCore\Validator\Rules\Traits\ChecksParametersCount;
use OpxCore\Validator\Rules\Traits\ChecksInRange;
use SplFileInfo;

class SizeRule implements Rule
{
    use ChecksParametersCount,
        ChecksInRange;

    /**
     * The field under validation must be file and have size in KiB (1024 byte) passing comparision rules.
     *
     * @param string $key
     * @param array $data
     * @param array $parameters
     *
     * @return  bool
     */
    public function check(string $key, array $data = [], array $parameters = []): bool
    {
        $this->checkParametersCount('count', $key, 1, $parameters);

        return !array_key_exists($key, $data) ||
            ($data[$key] instanceof SplFileInfo &&
                $this->checkRange($data[$key]->getSize() / 1024, $parameters[0], $parameters[1] ?? null));
    }
}