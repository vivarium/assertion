<?php

/*
 * This file is part of Vivarium
 * SPDX-License-Identifier: MIT
 * Copyright (c) 2021 Luca Cantoreggi
 */

declare(strict_types=1);

namespace Vivarium\Assertion\Comparison;

use InvalidArgumentException;
use Vivarium\Assertion\Assertion;
use Vivarium\Assertion\Helpers\TypeToString;
use Vivarium\Assertion\String\IsEmpty;
use Vivarium\Equality\EqualsBuilder;

use function array_merge;
use function is_object;
use function sprintf;

/**
 * @template T
 * @template-implements Assertion<T>
 */
final class IsOneOf implements Assertion
{
    /** @var array<T> */
    private array $choices;

    /**
     * @param T $choice
     * @param T ...$choices
     */
    public function __construct($choice, ...$choices)
    {
        $this->choices = array_merge([$choice], $choices);
    }

    /**
     * @param mixed $value
     *
     * @psalm-assert T $value
     */
    public function assert($value, string $message = ''): void
    {
        if (! $this($value)) {
            $message = sprintf(
                ! (new IsEmpty())($message) ?
                    $message : 'Expected value to be one of the values provided. Got %s.',
                is_object($value) ? 'different object' : (new TypeToString())($value)
            );

            throw new InvalidArgumentException($message);
        }
    }

    /**
     * @param mixed $value
     *
     * @psalm-assert-if-true T $value
     */
    public function __invoke($value): bool
    {
        foreach ($this->choices as $choice) {
            if ((new EqualsBuilder())->append($value, $choice)->isEquals()) {
                return true;
            }
        }

        return false;
    }
}
