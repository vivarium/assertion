<?php

/**
 * This file is part of Vivarium
 * SPDX-License-Identifier: MIT
 * Copyright (c) 2020 Luca Cantoreggi
 */

declare(strict_types=1);

namespace Vivarium\Assertion\Conditional;

use InvalidArgumentException;
use Vivarium\Assertion\Assertion;

final class NullOr implements Assertion
{
    private Assertion $assertion;

    public function __construct(Assertion $assertion)
    {
        $this->assertion = $assertion;
    }

    /**
     * @param mixed $value
     *
     * @throws InvalidArgumentException
     */
    public function assert($value, string $message = '') : void
    {
        if ($value === null) {
            return;
        }

        $this->assertion->assert($value, $message);
    }

    /**
     * @param mixed $value
     */
    public function __invoke($value) : bool
    {
        return $value === null || ($this->assertion)($value);
    }
}
