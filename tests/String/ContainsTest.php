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
use Vivarium\Assertion\String\Contains;

/**
 * @coversDefaultClass \Vivarium\Assertion\String\Contains
 */
class ContainsTest extends TestCase
{
    /**
     * @covers ::__construct()
     * @covers ::assert()
     * @covers ::__invoke()
     */
    public function testAssert(): void
    {
        static::expectException(InvalidArgumentException::class);
        static::expectExceptionMessage('Expected that string contains "Hello".');

        (new Contains('Bar'))->assert('Foo Bar');
        (new Contains('Hello'))->assert('Foo Bar');
    }

    /**
     * @covers ::__invoke()
     */
    public function testInvoke(): void
    {
        static::assertTrue((new Contains('H'))('Hello World'));
        static::assertTrue((new Contains('Hello'))('Hello World'));
        static::assertFalse((new Contains('Foo'))('Hello World'));
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
        (new Contains('Hello'))->assert(42);
    }
}
