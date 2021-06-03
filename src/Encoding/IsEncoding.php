<?php

/**
 * This file is part of Vivarium
 * SPDX-License-Identifier: MIT
 * Copyright (c) 2020 Luca Cantoreggi
 */

declare(strict_types=1);

namespace Vivarium\Assertion\Encoding;

use InvalidArgumentException;
use Vivarium\Assertion\Assertion;
use Vivarium\Assertion\Conditional\All;
use Vivarium\Assertion\Helpers\TypeToString;
use Vivarium\Assertion\Type\IsString;
use function sprintf;

final class IsEncoding implements Assertion
{
    /**
     * @param mixed $value
     *
     * @throws InvalidArgumentException
     */
    public function assert($value, string $message = '') : void
    {
        if (! ($this)($value)) {
            $message = sprintf(
                '%s is not a valid encoding.',
                (new TypeToString())($value)
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

        return (new All(
            new IsSystemEncoding(),
            new IsRegexEncoding()
        ))($value);
    }
}
