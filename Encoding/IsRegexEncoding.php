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
use Vivarium\Assertion\Helpers\TypeToString;
use Vivarium\Assertion\Type\IsString;
use function mb_regex_encoding;
use function sprintf;

final class IsRegexEncoding implements Assertion
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
                '%s is not a valid regex encoding.',
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

        $encoding = mb_regex_encoding();
        $valid    = @mb_regex_encoding($value);
        mb_regex_encoding($encoding);

        return $valid;
    }
}