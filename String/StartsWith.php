<?php

/**
 * This file is part of Vivarium
 * SPDX-License-Identifier: MIT
 * Copyright (c) 2020 Luca Cantoreggi
 */

declare(strict_types=1);

namespace Vivarium\Assertion\String;

use InvalidArgumentException;
use Vivarium\Assertion\Assertion;
use Vivarium\Assertion\Helpers\TypeToString;
use Vivarium\Assertion\Type\IsString;
use function sprintf;
use function strcmp;
use function strlen;
use function substr;

final class StartsWith implements Assertion
{
    private string $start;

    public function __construct(string $start)
    {
        $this->start = $start;
    }

    /**
     * @param mixed $value
     */
    public function assert($value, string $message = '') : void
    {
        if (! $this($value)) {
            $message = sprintf(
                ! (new IsEmpty())($message) ?
                     $message : 'Expected that string %s starts with %2$s.',
                (new TypeToString())($value),
                (new TypeToString())($this->start)
            );

            throw new InvalidArgumentException($message);
        }
    }

    /**
     * @param mixed $value
     */
    public function __invoke($value) : bool
    {
        (new IsString())->assert($value);

        $startLength = strlen($this->start);
        $substr      = substr($value, 0, $startLength);

        return strcmp($this->start, $substr) === 0;
    }
}
