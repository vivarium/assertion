<?php

/**
 * This file is part of Vivarium
 * SPDX-License-Identifier: MIT
 * Copyright (c) 2020 Luca Cantoreggi
 */

declare(strict_types=1);

namespace Vivarium\Assertion\Comparison;

use InvalidArgumentException;
use Vivarium\Assertion\Assertion;
use Vivarium\Assertion\Helpers\TypeToString;
use Vivarium\Assertion\String\IsEmpty;
use Vivarium\Equality\EqualsBuilder;
use function sprintf;

final class IsEqualsTo implements Assertion
{
    /** @var mixed  */
    private $compare;

    /**
     * @param mixed $compare
     */
    public function __construct($compare)
    {
        $this->compare = $compare;
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
                    $message : 'Expected value to be equals to %2$s. Got %s',
                (new TypeToString())($value),
                (new TypeToString())($this->compare)
            );

            throw new InvalidArgumentException($message);
        }
    }

    /**
     * @param mixed $value
     */
    public function __invoke($value) : bool
    {
        return (new EqualsBuilder())
            ->append($value, $this->compare)
            ->isEquals();
    }
}
