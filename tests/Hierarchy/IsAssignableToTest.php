<?php

/*
 * This file is part of Vivarium
 * SPDX-License-Identifier: MIT
 * Copyright (c) 2021 Luca Cantoreggi
 */

declare(strict_types=1);

namespace Vivarium\Assertion\Test\Hierarchy;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Vivarium\Assertion\Hierarchy\IsAssignableTo;
use Vivarium\Assertion\Test\Stub\Stub;
use Vivarium\Assertion\Test\Stub\StubClass;
use Vivarium\Assertion\Test\Stub\StubClassExtension;

use function sprintf;

/**
 * @coversDefaultClass \Vivarium\Assertion\Hierarchy\IsAssignableTo
 */
final class IsAssignableToTest extends TestCase
{
    /**
     * @covers ::__construct()
     * @covers ::assert()
     * @covers ::__invoke()
     */
    public function testAssert(): void
    {
        static::expectException(InvalidArgumentException::class);
        static::expectExceptionMessage(
            sprintf(
                'Expected class "%s" to be assignable to "%2$s".',
                Stub::class,
                StubClassExtension::class
            )
        );

        (new IsAssignableTo(Stub::class))->assert(Stub::class);
        (new IsAssignableTo(Stub::class))->assert(StubClass::class);
        (new IsAssignableTo(StubClass::class))->assert(StubClassExtension::class);
        (new IsAssignableTo(StubClassExtension::class))->assert(Stub::class);
    }

    /**
     * @covers ::__construct()
     */
    public function testConstructorWithoutClass(): void
    {
        static::expectException(InvalidArgumentException::class);
        static::expectExceptionMessage('Argument must be a class or interface name. Got "RandomString"');

        /**
         * This is covered by static analysis but it is a valid runtime call
         *
         * @psalm-suppress ArgumentTypeCoercion
         * @psalm-suppress UndefinedClass
         * @phpstan-ignore-next-line
         */
        (new IsAssignableTo('RandomString'))->assert(Stub::class);
    }

    /**
     * @covers ::__construct()
     * @covers ::assert()
     * @covers ::__invoke()
     */
    public function testAssertWithoutClass(): void
    {
        static::expectException(InvalidArgumentException::class);
        static::expectExceptionMessage('Argument must be a class or interface name. Got "RandomString"');

        /**
         * This is covered by static analysis but it is a valid runtime call
         *
         * @psalm-suppress ArgumentTypeCoercion
         * @psalm-suppress UndefinedClass
         * @phpstan-ignore-next-line
         */
        (new IsAssignableTo(Stub::class))->assert('RandomString');
    }
}
