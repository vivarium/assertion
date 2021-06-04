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
use Vivarium\Assertion\Hierarchy\IsSubclassOf;
use Vivarium\Assertion\Test\Stub\Stub;
use Vivarium\Assertion\Test\Stub\StubClass;
use Vivarium\Assertion\Test\Stub\StubClassExtension;

use function sprintf;

/**
 * @coversDefaultClass \Vivarium\Assertion\Hierarchy\IsSubclassOf
 */
final class IsSubclassOfTest extends TestCase
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
                'Expected class "%s" to be subclass of "%2$s".',
                StubClass::class,
                StubClassExtension::class
            )
        );

        (new IsSubclassOf(Stub::class))->assert(StubClass::class);
        (new IsSubclassOf(StubClass::class))->assert(StubClassExtension::class);
        (new IsSubclassOf(StubClassExtension::class))->assert(StubClass::class);
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
        (new IsSubclassOf('RandomString'))->assert(Stub::class);
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
        (new IsSubclassOf(Stub::class))->assert('RandomString');
    }
}
