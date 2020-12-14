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
use Vivarium\Assertion\Type\IsString;
use function mb_internal_encoding;
use function mb_strlen;
use function sprintf;

final class IsLongBetween implements Assertion
{
    private int $min;

    private int $max;

    private string $encoding;

    public function __construct(int $min, int $max, ?string $encoding = null)
    {
        $encoding = $encoding ?? mb_internal_encoding();
        (new IsSystemEncoding())->assert($encoding);

        $this->min      = $min;
        $this->max      = $max;
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
                     $message : 'Expected string to be long between %3$s and %4$s. Got %2$s.',
                (new TypeToString())($value),
                (new TypeToString())(mb_strlen($value)),
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
        (new IsString())->assert($value);

        $length = mb_strlen($value, $this->encoding);

        return ($this->min <= $length) && ($length <= $this->max);
    }
}
