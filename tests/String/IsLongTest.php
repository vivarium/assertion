<?php

/*
 * This file is part of Vivarium
 * SPDX-License-Identifier: MIT
 * Copyright (c) 2021 Luca Cantoreggi
 */

declare(strict_types=1);

namespace Vivarium\Assertion\Test\String;

use PHPUnit\Framework\TestCase;
use Vivarium\Assertion\Exception\AssertionFailed;
use Vivarium\Assertion\String\IsLong;

/**
 * @coversDefaultClass \Vivarium\Assertion\String\IsLong
 */
final class IsLongTest extends TestCase
{
    /**
     * @covers ::__construct()
     * @covers ::assert()
     * @covers ::__invoke()
     */
    public function testAssert(): void
    {
        static::expectException(AssertionFailed::class);
        static::expectExceptionMessage('Expected string to be long 6. Got 5.');

        (new IsLong(11))->assert('Hello World');
        (new IsLong(6))->assert('Hello');
    }

    /**
     * @covers ::__construct()
     * @covers ::assert()
     * @covers ::__invoke()
     */
    public function testIsLongWithWrongEncoding(): void
    {
        static::expectException(AssertionFailed::class);
        static::expectExceptionMessage('"Foo" is not a valid system encoding.');

        (new IsLong(11, 'Foo'))->assert('foo');
    }

    /**
     * @covers ::assert()
     */
    public function testAssertWithoutString(): void
    {
        static::expectException(AssertionFailed::class);
        static::expectExceptionMessage('Expected value to be string. Got integer.');

        /**
         * This is covered by static analysis but it is a valid runtime call
         *
         * @psalm-suppress InvalidScalarArgument
         * @phpstan-ignore-next-line
         */
        (new IsLong(3))->assert(42);
    }

    /**
     * @covers ::assert()
     */
    public function testAssertWithMultibyte(): void
    {
        static::expectException(AssertionFailed::class);
        static::expectExceptionMessage('Expected string to be long 2. Got 1.');

        (new IsLong(2, 'UTF-8'))->assert('π');
    }
}
