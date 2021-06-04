<?php

/*
 * This file is part of Vivarium
 * SPDX-License-Identifier: MIT
 * Copyright (c) 2021 Luca Cantoreggi
 */

declare(strict_types=1);

namespace Vivarium\Assertion\Test\String;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Vivarium\Assertion\String\StartsWith;

/**
 * @coversDefaultClass \Vivarium\Assertion\String\StartsWith
 */
final class StartsWithTest extends TestCase
{
    /**
     * @covers ::__construct()
     * @covers ::assert()
     * @covers ::__invoke()
     */
    public function testAssert(): void
    {
        static::expectException(InvalidArgumentException::class);
        static::expectExceptionMessage('Expected that string "Hello World" starts with "World".');

        (new StartsWith('Hello'))->assert('Hello World');
        (new StartsWith('World'))->assert('Hello World');
    }

    /**
     * @covers ::assert()
     */
    public function testAssertWithoutString(): void
    {
        static::expectException(InvalidArgumentException::class);
        static::expectExceptionMessage('Expected value to be string. Got integer.');

        /**
         * This is covered by static analysis but it is a valid runtime call
         *
         * @psalm-suppress InvalidScalarArgument
         * @phpstan-ignore-next-line
         */
        (new StartsWith('H'))->assert(42);
    }
}
