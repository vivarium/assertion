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
use Vivarium\Assertion\Numeric\IsLessThan;

/**
 * @coversDefaultClass \Vivarium\Assertion\Numeric\IsLessThan
 */
final class IsLessThanTest extends TestCase
{
    /**
     * @covers ::__construct()
     * @covers ::assert()
     * @covers ::__invoke()
     */
    public function testAssert(): void
    {
        static::expectException(InvalidArgumentException::class);
        static::expectExceptionMessage('Expected value to be less than 10. Got 10.');

        (new IsLessThan(10))->assert(5);
        (new IsLessThan(10))->assert(10);
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
        (new IsLessThan(10))->assert('String');
    }
}
