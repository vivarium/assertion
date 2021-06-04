<?php

/*
 * This file is part of Vivarium
 * SPDX-License-Identifier: MIT
 * Copyright (c) 2021 Luca Cantoreggi
 */

declare(strict_types=1);

namespace Vivarium\Assertion\Test\Numeric;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Vivarium\Assertion\Numeric\IsInOpenRange;

/**
 * @coversDefaultClass \Vivarium\Assertion\Numeric\IsInOpenRange
 */
final class IsInOpenRangeTest extends TestCase
{
    /**
     * @covers ::__construct()
     * @covers ::assert()
     * @covers ::__invoke()
     */
    public function testAssert(): void
    {
        static::expectException(InvalidArgumentException::class);
        static::expectExceptionMessage('Expected number to be in open range (0, 9). Got 9.');

        static::assertFalse((new IsInOpenRange(0, 9))(0));

        (new IsInOpenRange(0, 9))->assert(5);
        (new IsInOpenRange(0, 9))->assert(9);
    }

    /**
     * @covers ::assert()
     */
    public function testAssertWithWrongRange(): void
    {
        static::expectException(InvalidArgumentException::class);
        static::expectExceptionMessage('Lower bound must be lower than upper bound. Got (10, 0).');

        (new IsInOpenRange(10, 0))->assert(5);
    }

    /**
     * @covers ::assert()
     * @covers ::__invoke()
     */
    public function testAssertWithoutNumeric(): void
    {
        static::expectException(InvalidArgumentException::class);
        static::expectExceptionMessage('Expected value to be either integer or float. Got "String".');

        /**
         * This is covered by static analysis but it is a valid runtime call
         *
         * @psalm-suppress InvalidScalarArgument
         * @phpstan-ignore-next-line
         */
        (new IsInOpenRange(0, 10))->assert('String');
    }
}
