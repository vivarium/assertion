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

final class EndsWith implements Assertion
{
    private string $end;

    public function __construct(string $end)
    {
        $this->end = $end;
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
                     $message : 'Expected that string %s ends with %2$s.',
                (new TypeToString())($value),
                (new TypeToString())($this->end)
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

        $stringLength = strlen($value);
        $endLength    = strlen($this->end);
        $startOffset  = $stringLength - $endLength;
        $substr       = substr($value, $startOffset, strlen($value));

        return strcmp($this->end, $substr) === 0;
    }
}
