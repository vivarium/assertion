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
use Vivarium\Assertion\Encoding\IsRegexEncoding;

use function mb_regex_encoding;

/**
 * @coversDefaultClass \Vivarium\Assertion\Encoding\IsRegexEncoding
 */
final class IsRegexEncodingTest extends TestCase
{
    /**
     * @covers ::assert()
     * @covers ::__invoke()
     */
    public function testAssert(): void
    {
        static::expectException(InvalidArgumentException::class);
        static::expectExceptionMessage('"Windows-1251" is not a valid regex encoding.');

        (new IsRegexEncoding())->assert('UTF-8');
        (new IsRegexEncoding())('UTF-8');
        (new IsRegexEncoding())->assert('Windows-1251');
    }

    /**
     * @covers ::__invoke()
     */
    public function testDefaultEncodingUntouched(): void
    {
        $valid = mb_regex_encoding('UTF-8');

        static::assertTrue($valid);
        static::assertTrue((new IsRegexEncoding())('ASCII'));
        static::assertSame('UTF-8', mb_regex_encoding());
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
        (new IsRegexEncoding())->assert(42);
    }
}
