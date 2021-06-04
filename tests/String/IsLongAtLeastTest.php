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
use Vivarium\Assertion\String\IsLongAtLeast;

/**
 * @coversDefaultClass \Vivarium\Assertion\String\IsLongAtLeast
 */
final class IsLongAtLeastTest extends TestCase
{
    /**
     * @covers ::__construct()
     * @covers ::assert()
     * @covers ::__invoke()
     */
    public function testAssert(): void
    {
        static::expectException(InvalidArgumentException::class);
        static::expectExceptionMessage('Expected string to be long at least 6. Got 5');

        (new IsLongAtLeast(3))->assert('Hello');
        (new IsLongAtLeast(5))->assert('Hello');
        (new IsLongAtLeast(6))->assert('Hello');
    }

    /**
     * @covers ::__construct()
     * @covers ::assert()
     * @covers ::__invoke()
     */
    public function testIsLongAtLeastWithWrongEncoding(): void
    {
        static::expectException(InvalidArgumentException::class);
        static::expectExceptionMessage('"Foo" is not a valid system encoding.');

        (new IsLongAtLeast(3, 'Foo'))->assert('Hello');
    }

    /**
     * @covers ::__construct()
     * @covers ::assert()
     * @covers ::__invoke()
     */
    public function testIsLongAtLeastWithZeroLength(): void
    {
        static::expectException(InvalidArgumentException::class);
        static::expectExceptionMessage('Expected number to be greater than 0. Got 0.');

        (new IsLongAtLeast(0))->assert('Hello');
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
        (new IsLongAtLeast(5))->assert(42);
    }

    /**
     * @covers ::assert()
     */
    public function testAssertWithMultibyte(): void
    {
        static::expectException(InvalidArgumentException::class);
        static::expectExceptionMessage('Expected string to be long at least 2. Got 1.');

        (new IsLongAtLeast(2, 'UTF-8'))->assert('π');
    }
}
