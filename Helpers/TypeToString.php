<?php

/**
 * This file is part of Vivarium
 * SPDX-License-Identifier: MIT
 * Copyright (c) 2020 Luca Cantoreggi
 */

declare(strict_types=1);

namespace Vivarium\Assertion\Helpers;

use function get_class;
use function is_array;
use function is_object;
use function is_string;

final class TypeToString
{
    /**
     * @param mixed $value
     */
    public function __invoke($value) : string
    {
        if ($value === true) {
            return 'true';
        }

        if ($value === false) {
            return 'false';
        }

        if ($value === null) {
            return 'null';
        }

        if (is_array($value)) {
            return 'array';
        }

        if (is_object($value)) {
            $value = get_class($value);
        }

        if (is_string($value)) {
            return '"' . $value . '"';
        }

        return (string) $value;
    }
}
