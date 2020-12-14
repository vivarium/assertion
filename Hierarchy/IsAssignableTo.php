<?php

/**
 * This file is part of Vivarium
 * SPDX-License-Identifier: MIT
 * Copyright (c) 2020 Luca Cantoreggi
 */

declare(strict_types=1);

namespace Vivarium\Assertion\Hierarchy;

use InvalidArgumentException;
use Vivarium\Assertion\Assertion;
use Vivarium\Assertion\Conditional\Either;
use Vivarium\Assertion\Helpers\TypeToString;
use Vivarium\Assertion\String\IsClass;
use Vivarium\Assertion\String\IsEmpty;
use Vivarium\Assertion\String\IsInterface;
use function is_a;
use function sprintf;

final class IsAssignableTo implements Assertion
{
    private string $class;

    public function __construct(string $class)
    {
        (new Either(
            new IsClass(),
            new IsInterface()
        ))->assert($class, 'Argument must be a class or interface name. Got %s');

        $this->class = $class;
    }

    /**
     * @param mixed $value
     *
     * @throws InvalidArgumentException
     */
    public function assert($value, string $message = '') : void
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
     * @param mixed $value
     */
    public function __invoke($value) : bool
    {
        (new Either(
            new IsClass(),
            new IsInterface()
        ))->assert($value, 'Argument must be a class or interface name. Got %s');

        return is_a($value, $this->class, true);
    }
}
