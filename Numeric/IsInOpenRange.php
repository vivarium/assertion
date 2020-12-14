<?php

/**
 * This file is part of Vivarium
 * SPDX-License-Identifier: MIT
 * Copyright (c) 2020 Luca Cantoreggi
 */

declare(strict_types=1);

namespace Vivarium\Assertion\Numeric;

use InvalidArgumentException;
use Vivarium\Assertion\Assertion;
use Vivarium\Assertion\Helpers\TypeToString;
use Vivarium\Assertion\String\IsEmpty;
use Vivarium\Assertion\Type\IsNumeric;
use function sprintf;

final class IsInOpenRange implements Assertion
{
    private float $min;

    private float $max;

    public function __construct(float $min, float $max)
    {
        (new IsLessThan($max))
            ->assert($min, 'Lower bound must be lower than upper bound. Got (%1$s, %2$s).');

        $this->min = $min;
        $this->max = $max;
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
                     $message : 'Expected number to be in open range (%2$s, %3$s). Got %s.',
                (new TypeToString())($value),
                (new TypeToString())($this->min),
                (new TypeToString())($this->max)
            );

            throw new InvalidArgumentException($message);
        }
    }

    /**
     * @param mixed $value
     */
    public function __invoke($value) : bool
    {
        (new IsNumeric())->assert($value);

        return ($this->min < $value) && ($value < $this->max);
    }
}
