<?php

/*
 * This file is part of Vivarium
 * SPDX-License-Identifier: MIT
 * Copyright (c) 2021 Luca Cantoreggi
 */

declare(strict_types=1);

namespace Vivarium\Assertion\Test\Conditional;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Vivarium\Assertion\Conditional\Either;
use Vivarium\Assertion\Numeric\IsGreaterThan;
use Vivarium\Assertion\Numeric\IsInClosedRange;
use Vivarium\Assertion\Type\IsInteger;
use Vivarium\Assertion\Type\IsString;

/**
 * @coversDefaultClass \Vivarium\Assertion\Conditional\Either
 */
final class EitherTest extends TestCase
{
    /**
     * @covers ::__construct()
     * @covers ::assert()
     */
    public function testAssert(): void
    {
        static::expectException(InvalidArgumentException::class);
        static::expectExceptionMessage('Failed all assertions in either condition.');

        (new Either(
            new IsGreaterThan(100),
            new IsInClosedRange(0, 9)
        ))->assert(42);
    }

    /**
     * @covers ::__construct()
     * @covers ::__invoke()
     */
    public function testInvoke(): void
    {
        $value = 42;

        static::assertTrue(
            (new Either(
                new IsString(),
                new IsInteger()
            ))($value)
        );

        static::assertTrue(
            (new Either(
                new IsGreaterThan(5),
                new IsInClosedRange(40, 50)
            ))($value)
        );

        static::assertFalse(
            (new Either(
                new IsGreaterThan(100),
                new IsInClosedRange(0, 9)
            ))($value)
        );
    }
}
