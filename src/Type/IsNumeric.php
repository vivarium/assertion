<?php

/*
 * This file is part of Vivarium
 * SPDX-License-Identifier: MIT
 * Copyright (c) 2021 Luca Cantoreggi
 */

declare(strict_types=1);

namespace Vivarium\Assertion\Type;

use Vivarium\Assertion\Assertion;
use Vivarium\Assertion\Conditional\Either;
use Vivarium\Assertion\Exception\AssertionFailed;
use Vivarium\Assertion\String\IsEmpty;

/**
 * @template-implements Assertion<mixed>
 * @psalm-immutable
 */
final class IsNumeric implements Assertion
{
    /** @var Assertion<mixed> */
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
     * @throws AssertionFailed
     *
     * @psalm-assert int|float $value
     */
    public function assert($value, string $message = ''): void
    {
        $this->isNumeric->assert(
            $value,
            ! (new IsEmpty())($message) ?
                $message : 'Expected value to be either integer or float. Got %s.'
        );
    }

    /**
     * @param mixed $value
     *
     * @psalm-assert-if-true int|float $value
     */
    public function __invoke($value): bool
    {
        return ($this->isNumeric)($value);
    }
}
