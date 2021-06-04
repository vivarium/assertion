<?php

/*
 * This file is part of Vivarium
 * SPDX-License-Identifier: MIT
 * Copyright (c) 2021 Luca Cantoreggi
 */

declare(strict_types=1);

namespace Vivarium\Assertion\Test\Object;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use stdClass;
use Traversable;
use Vivarium\Assertion\Object\IsInstanceOf;
use Vivarium\Assertion\Test\Stub\Stub;

/**
 * @coversDefaultClass \Vivarium\Assertion\Object\IsInstanceOf
 */
final class IsInstanceOfTest extends TestCase
{
    /**
     * @covers ::__construct()
     * @covers ::assert()
     * @covers ::__invoke()
     */
    public function testAssert(): void
    {
        static::expectException(InvalidArgumentException::class);
        static::expectExceptionMessage('Expected object to be instance of "Traversable". Got "stdClass".');

        $stub = $this->createMock(Traversable::class);

        (new IsInstanceOf(Traversable::class))->assert($stub);
        (new IsInstanceOf(Traversable::class))->assert(new stdClass());
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
        (new IsInstanceOf('RandomString'))->assert(new stdClass());
    }

    /**
     * @covers ::__construct()
     */
    public function testAssertWithoutObject(): void
    {
        static::expectException(InvalidArgumentException::class);
        static::expectExceptionMessage('Expected value to be object. Got string.');

        /**
         * This is covered by static analysis but it is a valid runtime call
         *
         * @psalm-suppress InvalidArgument
         * @phpstan-ignore-next-line
         */
        (new IsInstanceOf(Stub::class))->assert('Random');
    }
}
