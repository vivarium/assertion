<?php

/*
 * This file is part of Vivarium
 * SPDX-License-Identifier: MIT
 * Copyright (c) 2021 Luca Cantoreggi
 */

declare(strict_types=1);

namespace Vivarium\Assertion\Test\Encoding;

use PHPUnit\Framework\TestCase;
use Vivarium\Assertion\Encoding\IsEncoding;
use Vivarium\Assertion\Exception\AssertionFailed;

/**
 * @coversDefaultClass \Vivarium\Assertion\Encoding\IsEncoding
 */
final class IsEncodingTest extends TestCase
{
    /**
     * @covers ::assert()
     * @covers ::__invoke()
     */
    public function testAssert(): void
    {
        static::expectException(AssertionFailed::class);
        static::expectExceptionMessage('"Windows-1251" is not a valid encoding.');

        (new IsEncoding())->assert('UTF-8');
        (new IsEncoding())('UTF-8');
        (new IsEncoding())->assert('Windows-1251');
    }

    /**
     * @covers ::assert()
     * @covers ::__invoke()
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
        (new IsEncoding())->assert(42);
    }
}
