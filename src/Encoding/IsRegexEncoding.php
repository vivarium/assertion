<?php

/*
 * This file is part of Vivarium
 * SPDX-License-Identifier: MIT
 * Copyright (c) 2021 Luca Cantoreggi
 */

declare(strict_types=1);

namespace Vivarium\Assertion\Encoding;

use ValueError;
use Vivarium\Assertion\Assertion;
use Vivarium\Assertion\Exception\AssertionFailed;
use Vivarium\Assertion\Helpers\TypeToString;
use Vivarium\Assertion\Type\IsBoolean;
use Vivarium\Assertion\Type\IsString;

use function mb_regex_encoding;
use function sprintf;

/**
 * @template-implements Assertion<string>
 * @psalm-immutable
 */
final class IsRegexEncoding implements Assertion
{
    /**
     * @param string $value
     */
    public function assert($value, string $message = ''): void
    {
        if (! ($this)($value)) {
            $message = sprintf(
                '%s is not a valid regex encoding.',
                (new TypeToString())($value)
            );

            throw new AssertionFailed($message);
        }
    }

    /**
     * @param string $value
     *
     * @psalm-suppress ImpureFunctionCall  mb_regex_encoding is called and then restored
     * @SuppressWarnings(PHPMD.ErrorControlOperator)
     */
    public function __invoke($value): bool
    {
        (new IsString())->assert($value);

        $encoding = mb_regex_encoding();
        (new IsString())->assert($encoding);

        try {
            $valid = @mb_regex_encoding($value);
            (new IsBoolean())->assert($valid);
        } catch (ValueError $error) {
            $valid = false;
        } finally {
            /** @psalm-suppress UnusedFunctionCall We can ignore the result since we are restoring the previous value */
            mb_regex_encoding($encoding);
        }

        return $valid;
    }
}
