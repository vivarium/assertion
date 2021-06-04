<?php

/*
 * This file is part of Vivarium
 * SPDX-License-Identifier: MIT
 * Copyright (c) 2021 Luca Cantoreggi
 */

declare(strict_types=1);

namespace Vivarium\Assertion\String;

use Vivarium\Assertion\Assertion;
use Vivarium\Assertion\Exception\AssertionFailed;
use Vivarium\Assertion\Helpers\TypeToString;
use Vivarium\Assertion\Type\IsString;

use function class_exists;
use function sprintf;

/**
 * @template-implements Assertion<string>
 */
final class IsClass implements Assertion
{
    /**
     * @param string $value
     *
     * @psalm-assert class-string $value
     */
    public function assert($value, string $message = ''): void
    {
        if (! $this($value)) {
            $message = sprintf(
                ! (new IsEmpty())($message) ?
                     $message : 'Expected string to be a class name. Got %s.',
                (new TypeToString())($value)
            );

            throw new AssertionFailed($message);
        }
    }

    /**
     * @param string $value
     *
     * @psalm-assert-if-true class-string $value
     */
    public function __invoke($value): bool
    {
        (new IsString())->assert($value);

        return class_exists($value);
    }
}
