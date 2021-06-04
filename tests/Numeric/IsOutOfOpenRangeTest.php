<?php

/*
 * This file is part of Vivarium
 * SPDX-License-Identifier: MIT
 * Copyright (c) 2021 Luca Cantoreggi
 */

declare(strict_types=1);

namespace Vivarium\Assertion\Test\Numeric;

use PHPUnit\Framework\TestCase;
use Vivarium\Assertion\Exception\AssertionFailed;
use Vivarium\Assertion\Numeric\IsOutOfOpenRange;

/**
 * @coversDefaultClass \Vivarium\Assertion\Numeric\IsOutOfOpenRange
 */
final class IsOutOfOpenRangeTest extends TestCase
{
    /**
     * @covers ::__construct()
     * @covers ::assert()
     * @covers ::__invoke()
     */
    public function testAssert(): void
    {
        static::expectException(AssertionFailed::class);
        static::expectExceptionMessage('Expected value to be out of open range (0, 9). Got 8.');

        (new IsOutOfOpenRange(0, 9))->assert(-42);
        (new IsOutOfOpenRange(0, 9))->assert(0);
        (new IsOutOfOpenRange(0, 9))->assert(9);
        (new IsOutOfOpenRange(0, 9))->assert(42);
        (new IsOutOfOpenRange(0, 9))->assert(8);
    }

    /**
     * @covers ::assert()
     */
    public function testAssertWithWrongRange(): void
    {
        static::expectException(AssertionFailed::class);
        static::expectExceptionMessage('Lower bound must be lower than upper bound. Got (10, 0).');

        (new IsOutOfOpenRange(10, 0))->assert(5);
    }

    /**
     * @covers ::assert()
     * @covers ::__invoke()
     */
    public function testAssertWithoutNumeric(): void
    {
        static::expectException(AssertionFailed::class);
        static::expectExceptionMessage('Expected value to be either integer or float. Got "String".');

        /**
         * This is covered by static analysis but it is a valid runtime call
         *
         * @psalm-suppress InvalidScalarArgument
         * @phpstan-ignore-next-line
         */
        (new IsOutOfOpenRange(0, 10))->assert('String');
    }
}
