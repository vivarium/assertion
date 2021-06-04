<?php

/*
 * This file is part of Vivarium
 * SPDX-License-Identifier: MIT
 * Copyright (c) 2021 Luca Cantoreggi
 */

declare(strict_types=1);

namespace Vivarium\Assertion\Test\Encoding;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Vivarium\Assertion\Encoding\IsSystemEncoding;

use function mb_internal_encoding;

/**
 * @coversDefaultClass \Vivarium\Assertion\Encoding\IsSystemEncoding
 */
final class IsSystemEncodingTest extends TestCase
{
    /**
     * @covers ::assert()
     * @covers ::__invoke()
     */
    public function testAssert(): void
    {
        static::expectException(InvalidArgumentException::class);
        static::expectExceptionMessage('"Foo" is not a valid system encoding');

        (new IsSystemEncoding())->assert('UTF-8');
        (new IsSystemEncoding())('UTF-8');
        (new IsSystemEncoding())->assert('Foo');
    }

    /**
     * @covers ::__invoke()
     */
    public function testDefaultEncodingUntouched(): void
    {
        mb_internal_encoding('UTF-8');
        static::assertTrue((new IsSystemEncoding())('ASCII'));
        static::assertSame('UTF-8', mb_internal_encoding());
    }

    /**
     * @covers ::assert()
     * @covers ::__invoke()
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
        (new IsSystemEncoding())->assert(42);
    }
}
