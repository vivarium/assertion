<?php

/*
 * This file is part of Vivarium
 * SPDX-License-Identifier: MIT
 * Copyright (c) 2021 Luca Cantoreggi
 */

declare(strict_types=1);

namespace Vivarium\Assertion\Hierarchy;

use InvalidArgumentException;
use Vivarium\Assertion\Assertion;
use Vivarium\Assertion\Helpers\TypeToString;
use Vivarium\Assertion\String\IsClassOrInterface;
use Vivarium\Assertion\String\IsEmpty;

use function is_a;
use function sprintf;

/**
 * @template T
 * @template-implements Assertion<class-string>
 */
final class IsAssignableTo implements Assertion
{
    /** @var class-string<T> */
    private string $class;

    /**
     * @param class-string<T> $class
     */
    public function __construct(string $class)
    {
        (new IsClassOrInterface())->assert($class);

        $this->class = $class;
    }

    /**
     * @param class-string $value
     *
     * @psalm-assert class-string<T> $value
     */
    public function assert($value, string $message = ''): void
    {
        if (! $this($value)) {
            $message = sprintf(
                ! (new IsEmpty())($message) ?
                     $message : 'Expected class %s to be assignable to %2$s.',
                (new TypeToString())($value),
                (new TypeToString())($this->class)
            );

            throw new InvalidArgumentException($message);
        }
    }

    /**
     * @param class-string $value
     *
     * @psalm-assert-if-true class-string<T> $value
     */
    public function __invoke($value): bool
    {
        (new IsClassOrInterface())->assert($value);

        return is_a($value, $this->class, true);
    }
}
