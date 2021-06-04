<?php

/*
 * This file is part of Vivarium
 * SPDX-License-Identifier: MIT
 * Copyright (c) 2021 Luca Cantoreggi
 */

declare(strict_types=1);

namespace Vivarium\Assertion\Type;

use InvalidArgumentException;
use Vivarium\Assertion\Assertion;
use Vivarium\Assertion\Helpers\TypeToString;
use Vivarium\Assertion\String\IsEmpty;

use function gettype;
use function is_string;
use function sprintf;

/**
 * @template-implements Assertion<mixed>
 */
final class IsString implements Assertion
{
    /**
     * @param mixed $value
     *
     * @psalm-assert string $value
     */
    public function assert($value, string $message = ''): void
    {
        if (! $this($value)) {
            $message = sprintf(
                ! (new IsEmpty())($message) ?
                     $message : 'Expected value to be string. Got %2$s.',
                (new TypeToString())($value),
                gettype($value)
            );

            throw new InvalidArgumentException($message);
        }
    }

    /**
     * @param mixed $value
     *
     * @psalm-assert-if-true string $value
     */
    public function __invoke($value): bool
    {
        return is_string($value);
    }
}
