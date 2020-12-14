<?php

/**
 * This file is part of Vivarium
 * SPDX-License-Identifier: MIT
 * Copyright (c) 2020 Luca Cantoreggi
 */

declare(strict_types=1);

namespace Vivarium\Assertion\Type;

use InvalidArgumentException;
use Vivarium\Assertion\Assertion;
use Vivarium\Assertion\Conditional\Either;
use Vivarium\Assertion\String\IsEmpty;

final class IsNumeric implements Assertion
{
    private Assertion $isNumeric;

    public function __construct()
    {
        $this->isNumeric = new Either(
            new IsInteger(),
            new IsFloat()
        );
    }

    /**
     * @param mixed $value
     *
     * @throws InvalidArgumentException
     */
    public function assert($value, string $message = '') : void
    {
        $this->isNumeric->assert(
            $value,
            ! (new IsEmpty())($message) ?
                $message : 'Expected value to be either integer or float. Got %s.'
        );
    }

    /**
     * @param mixed $value
     */
    public function __invoke($value) : bool
    {
        return ($this->isNumeric)($value);
    }
}
