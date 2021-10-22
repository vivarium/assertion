<?php

/*
 * This file is part of Vivarium
 * SPDX-License-Identifier: MIT
 * Copyright (c) 2021 Luca Cantoreggi
 */

declare(strict_types=1);

namespace Vivarium\Assertion\Encoding;

use Vivarium\Assertion\Assertion;
use Vivarium\Assertion\Conditional\All;
use Vivarium\Assertion\Exception\AssertionFailed;
use Vivarium\Assertion\Helpers\TypeToString;
use Vivarium\Assertion\Type\IsString;

use function sprintf;

/**
 * @template-implements Assertion<string>
 * @psalm-immutable
 */
final class IsEncoding implements Assertion
{
    /**
     * @param string $value
     */
    public function assert($value, string $message = ''): void
    {
        if (! ($this)($value)) {
            $message = sprintf(
                '%s is not a valid encoding.',
                (new TypeToString())($value)
            );

            throw new AssertionFailed($message);
        }
    }

    /**
     * @param string $value
     */
    public function __invoke($value): bool
    {
        (new IsString())->assert($value);

        return (new All(
            new IsSystemEncoding(),
            new IsRegexEncoding()
        ))($value);
    }
}
