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
use Vivarium\Assertion\Encoding\IsSystemEncoding;
use Vivarium\Assertion\Helpers\TypeToString;
use Vivarium\Assertion\Numeric\IsGreaterThan;
use Vivarium\Assertion\Type\IsString;
use function mb_internal_encoding;
use function mb_strlen;
use function sprintf;

final class IsLongAtMax implements Assertion
{
    private int $length;

    private string $encoding;

    public function __construct(int $length, ?string $encoding = null)
    {
        $encoding = $encoding ?? mb_internal_encoding();
        (new IsSystemEncoding())->assert($encoding);
        (new IsGreaterThan(0))->assert($length);

        $this->length   = $length;
        $this->encoding = $encoding;
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
                     $message : 'Expected string to be long at max %3$s. Got %2$s.',
                (new TypeToString())($value),
                (new TypeToString())(mb_strlen($value)),
                (new TypeToString())($this->length)
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

        return mb_strlen($value, $this->encoding) <= $this->length;
    }
}
