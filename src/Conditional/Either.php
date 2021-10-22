<?php

/*
 * This file is part of Vivarium
 * SPDX-License-Identifier: MIT
 * Copyright (c) 2021 Luca Cantoreggi
 */

declare(strict_types=1);

namespace Vivarium\Assertion\Conditional;

use Vivarium\Assertion\Assertion;
use Vivarium\Assertion\Exception\AssertionFailed;
use Vivarium\Assertion\Helpers\TypeToString;
use Vivarium\Assertion\String\IsEmpty;

use function array_merge;
use function sprintf;

/**
 * @template T
 * @template-implements Assertion<T>
 * @psalm-immutable
 */
final class Either implements Assertion
{
    /** @var array<Assertion<T>> */
    private array $assertions;

    /**
     * @param Assertion<T> $assertion
     * @param Assertion<T> ...$assertions
     */
    public function __construct(Assertion $assertion, Assertion ...$assertions)
    {
        $this->assertions = array_merge([$assertion], $assertions);
    }

    /**
     * @param T $value
     *
     * @psalm-assert T $value
     */
    public function assert($value, string $message = ''): void
    {
        if (! $this($value)) {
            $message = sprintf(
                ! (new IsEmpty())($message) ?
                     $message : 'Failed all assertions in either condition.',
                (new TypeToString())($value)
            );

            throw new AssertionFailed($message);
        }
    }

    /**
     * @param T $value
     *
     * @psalm-assert-if-true T $value
     */
    public function __invoke($value): bool
    {
        foreach ($this->assertions as $assertion) {
            if ($assertion($value)) {
                return true;
            }
        }

        return false;
    }
}
