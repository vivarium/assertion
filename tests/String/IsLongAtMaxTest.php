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
use Vivarium\Assertion\String\IsLongAtMax;

/**
 * @coversDefaultClass \Vivarium\Assertion\String\IsLongAtMax
 */
final class IsLongAtMaxTest extends TestCase
{
    /**
     * @covers ::__construct()
     * @covers ::assert()
     * @covers ::__invoke()
     */
    public function testAssert(): void
    {
        static::expectException(AssertionFailed::class);
        static::expectExceptionMessage('Expected string to be long at max 5. Got 11');

        (new IsLongAtMax(6))->assert('Hello');
        (new IsLongAtMax(5))->assert('Hello');
        (new IsLongAtMax(5))->assert('Hello World');
    }

    /**
     * @covers ::__construct()
     * @covers ::assert()
     * @covers ::__invoke()
     */
    public function testIsLongAtLeastWithWrongEncoding(): void
    {
        static::expectException(AssertionFailed::class);
        static::expectExceptionMessage('"Foo" is not a valid system encoding.');

        (new IsLongAtMax(3, 'Foo'))->assert('Hello');
    }

    /**
     * @covers ::__construct()
     * @covers ::assert()
     * @covers ::__invoke()
     */
    public function testiIsLongAtLeastWithZeroLenght(): void
    {
        static::expectException(AssertionFailed::class);
        static::expectExceptionMessage('Expected number to be greater than 0. Got 0.');

        (new IsLongAtMax(0))->assert('Hello');
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
        (new IsLongAtMax(5))->assert(42);
    }

    /**
     * @covers ::assert()
     */
    public function testAssertWithMultibyte(): void
    {
        static::expectException(AssertionFailed::class);
        static::expectExceptionMessage('Expected string to be long at max 1. Got 2.');

        (new IsLongAtMax(1, 'UTF-8'))->assert('ππ');
    }

    /**
     * @covers ::assert()
     */
    public function testInvokeWithMultibyte(): void
    {
        static::assertTrue(
            (new IsLongAtMax(2, 'UTF-8'))('ππ')
        );
    }
}
