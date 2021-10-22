<?php

/*
 * This file is part of Vivarium
 * SPDX-License-Identifier: MIT
 * Copyright (c) 2021 Luca Cantoreggi
 */

declare(strict_types=1);

namespace Vivarium\Assertion\Type;

use Vivarium\Assertion\Assertion;
use Vivarium\Assertion\Exception\AssertionFailed;
use Vivarium\Assertion\Helpers\TypeToString;
use Vivarium\Assertion\String\IsEmpty;

use function gettype;
use function is_callable;
use function sprintf;

/**
 * @template-implements Assertion<mixed>
 * @psalm-immutable
 */
final class IsCallable implements Assertion
{
    /**
     * @param mixed $value
     *
     * @throws AssertionFailed
     *
     * @psalm-assert callable $value
     */
    public function assert($value, string $message = ''): void
    {
        if (! $this($value)) {
            $message = sprintf(
                ! (new IsEmpty())($message) ?
                     $message : 'Expected value to be callable. Got %2$s.',
                (new TypeToString())($value),
                gettype($value)
            );

            throw new AssertionFailed($message);
        }
    }

    /**
     * @param mixed $value
     *
     * @psalm-assert-if-true callable $value
     */
    public function __invoke($value): bool
    {
        return is_callable($value);
    }
}
