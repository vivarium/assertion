<?php

/*
 * This file is part of Vivarium
 * SPDX-License-Identifier: MIT
 * Copyright (c) 2021 Luca Cantoreggi
 */

declare(strict_types=1);

namespace Vivarium\Assertion\Numeric;

use InvalidArgumentException;
use Vivarium\Assertion\Assertion;
use Vivarium\Assertion\Helpers\TypeToString;
use Vivarium\Assertion\String\IsEmpty;
use Vivarium\Assertion\Type\IsNumeric;

use function sprintf;

/**
 * @template-implements Assertion<int|float>
 */
final class IsLessOrEqualThan implements Assertion
{
    /** @var int|float */
    private $compare;

    public function __construct(float $compare)
    {
        $this->compare = $compare;
    }

    /**
     * @param int|float $value
     */
    public function assert($value, string $message = ''): void
    {
        if (! $this($value)) {
            $message = sprintf(
                ! (new IsEmpty())($message) ?
                     $message : 'Expected number to be less or equal than %2$s. Got %s.',
                (new TypeToString())($value),
                (new TypeToString())($this->compare)
            );

            throw new InvalidArgumentException($message);
        }
    }

    /**
     * @param int|float $value
     */
    public function __invoke($value): bool
    {
        (new IsNumeric())->assert($value);

        return $value <= $this->compare;
    }
}
