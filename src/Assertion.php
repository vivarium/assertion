<?php

/**
 * This file is part of Vivarium
 * SPDX-License-Identifier: MIT
 * Copyright (c) 2020 Luca Cantoreggi
 */

declare(strict_types=1);

namespace Vivarium\Assertion;

interface Assertion
{
    /**
     * @param mixed $value*
     */
    public function assert($value, string $message = '') : void;

    /**
     * @param mixed $value
     */
    public function __invoke($value) : bool;
}
