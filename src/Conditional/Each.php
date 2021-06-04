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
use Vivarium\Assertion\Type\IsArray;

use function array_merge;
use function sprintf;

/**
 * @template T
 * @template-implements Assertion<array<T>>
 */
final class Each implements Assertion
{
    /** @var Assertion<T>[] */
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
     * @param array<T> $value
     */
    public function assert($value, string $message = ''): void
    {
        (new IsArray())->assert($value);

        foreach ($value as $key => $element) {
            foreach ($this->assertions as $assertion) {
                try {
                    $assertion->assert($element);
                } catch (AssertionFailed $ex) {
                    $message = sprintf(
                        ! (new IsEmpty())($message) ?
                             $message : 'Element at index %2$s failed the assertion.',
                        (new TypeToString())($element),
                        (new TypeToString())($key)
                    );

                    throw new AssertionFailed($message, 0, $ex);
                }
            }
        }
    }

    /**
     * @param array<T> $value
     */
    public function __invoke($value): bool
    {
        (new IsArray())->assert($value);

        foreach ($value as $element) {
            foreach ($this->assertions as $assertion) {
                if (! $assertion($element)) {
                    return false;
                }
            }
        }

        return true;
    }
}
