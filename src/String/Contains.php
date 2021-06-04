<?php

/*
 * This file is part of Vivarium
 * SPDX-License-Identifier: MIT
 * Copyright (c) 2021 Luca Cantoreggi
 */

declare(strict_types=1);

namespace Vivarium\Assertion\String;

use InvalidArgumentException;
use Vivarium\Assertion\Assertion;
use Vivarium\Assertion\Helpers\TypeToString;
use Vivarium\Assertion\Type\IsString;

use function sprintf;
use function strpos;

/**
 * @template-implements Assertion<string>
 */
final class Contains implements Assertion
{
    private string $substring;

    public function __construct(string $substring)
    {
        $this->substring = $substring;
    }

    /**
     * @param string $value
     */
    public function assert($value, string $message = ''): void
    {
        if (! $this($value)) {
            $message = sprintf(
                ! (new IsEmpty())($message) ?
                     $message : 'Expected that string contains %2$s.',
                (new TypeToString())($value),
                (new TypeToString())($this->substring)
            );

            throw new InvalidArgumentException($message);
        }
    }

    /**
     * @param string $value
     */
    public function __invoke($value): bool
    {
        (new IsString())->assert($value);

        return strpos($value, $this->substring, 0) !== false;
    }
}
