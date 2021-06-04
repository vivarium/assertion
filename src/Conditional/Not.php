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

use function get_class;
use function sprintf;

/**
 * @template T
 * @template-implements Assertion<T>
 */
final class Not implements Assertion
{
    /** @var Assertion<T> */
    private Assertion $assertion;

    /**
     * @param Assertion<T> $assertion
     */
    public function __construct(Assertion $assertion)
    {
        $this->assertion = $assertion;
    }

    /**
     * @param T $value
     */
    public function assert($value, string $message = ''): void
    {
        if (! $this($value)) {
            $message = sprintf(
                ! (new IsEmpty())($message) ?
                     $message : 'Failed negating the assertion %2$s with value %s.',
                (new TypeToString())($value),
                (new TypeToString())(get_class($this->assertion))
            );

            throw new AssertionFailed($message);
        }
    }

    /**
     * @param T $value
     */
    public function __invoke($value): bool
    {
        return ! ($this->assertion)($value);
    }
}
