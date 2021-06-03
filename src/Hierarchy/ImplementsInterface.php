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
use Vivarium\Assertion\Helpers\TypeToString;
use Vivarium\Assertion\String\IsClass;
use Vivarium\Assertion\String\IsEmpty;
use Vivarium\Assertion\String\IsInterface;
use function class_implements;
use function in_array;
use function sprintf;

final class ImplementsInterface implements Assertion
{
    private string $interface;

    public function __construct(string $interface)
    {
        (new IsInterface())->assert($interface);

        $this->interface = $interface;
    }

    /**
     * @param mixed $value
     */
    public function assert($value, string $message = '') : void
    {
        if (! $this($value)) {
            $message = sprintf(
                ! (new IsEmpty())($message) ?
                     $message : 'Expected class %s to implements %2$s.',
                (new TypeToString())($value),
                (new TypeToString())($this->interface)
            );

            throw new InvalidArgumentException($message);
        }
    }

    /**
     * @param mixed $value
     */
    public function __invoke($value) : bool
    {
        (new IsClass())->assert($value);

        return in_array($this->interface, class_implements($value), true);
    }
}
