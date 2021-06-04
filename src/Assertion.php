<?php

/*
 * This file is part of Vivarium
 * SPDX-License-Identifier: MIT
 * Copyright (c) 2021 Luca Cantoreggi
 */

declare(strict_types=1);

namespace Vivarium\Assertion;

/**
 * @template  T
 */
interface Assertion
{
    /**
     * @param T $value
     */
    public function assert($value, string $message = ''): void;

    /**
     * @param T $value
     */
    public function __invoke($value): bool;
}
