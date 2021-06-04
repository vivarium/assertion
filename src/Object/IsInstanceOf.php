<?php

/*
 * This file is part of Vivarium
 * SPDX-License-Identifier: MIT
 * Copyright (c) 2021 Luca Cantoreggi
 */

declare(strict_types=1);

namespace Vivarium\Assertion\Object;

use InvalidArgumentException;
use Vivarium\Assertion\Assertion;
use Vivarium\Assertion\Conditional\Either;
use Vivarium\Assertion\Helpers\TypeToString;
use Vivarium\Assertion\String\IsClass;
use Vivarium\Assertion\String\IsEmpty;
use Vivarium\Assertion\String\IsInterface;
use Vivarium\Assertion\Type\IsObject;

use function sprintf;

/**
 * @template T as object
 * @template-implements Assertion<object>
 */
final class IsInstanceOf implements Assertion
{
    /** @var class-string<T> */
    private string $class;

    /**
     * @param class-string<T> $class
     */
    public function __construct(string $class)
    {
        (new Either(
            new IsClass(),
            new IsInterface()
        ))->assert($class, 'Argument must be a class or interface name. Got %s');

        $this->class = $class;
    }

    /**
     * @param object $value
     *
     * @psalm-assert T $value
     */
    public function assert($value, string $message = ''): void
    {
        if (! $this($value)) {
            $message = sprintf(
                ! (new IsEmpty())($message) ?
                     $message : 'Expected object to be instance of %2$s. Got %s.',
                (new TypeToString())($value),
                (new TypeToString())($this->class)
            );

            throw new InvalidArgumentException($message);
        }
    }

    /**
     * @param object $value
     *
     * @psalm-assert-if-true T $value
     */
    public function __invoke($value): bool
    {
        (new IsObject())->assert($value);

        return $value instanceof $this->class;
    }
}
