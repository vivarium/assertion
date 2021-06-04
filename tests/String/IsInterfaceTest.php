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
use Vivarium\Assertion\String\IsInterface;

/**
 * @coversDefaultClass \Vivarium\Assertion\String\IsInterface
 */
final class IsInterfaceTest extends TestCase
{
    /**
     * @covers ::assert()
     * @covers ::__invoke()
     */
    public function testAssert(): void
    {
        static::expectException(InvalidArgumentException::class);
        static::expectExceptionMessage('Expected string to be interface name. Got "Foo".');

        (new IsInterface())->assert('Traversable');
        (new IsInterface())->assert('Foo');
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
        (new IsInterface())->assert(42);
    }
}
