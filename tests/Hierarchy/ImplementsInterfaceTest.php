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
use stdClass;
use Traversable;
use Vivarium\Assertion\Hierarchy\ImplementsInterface;

use function get_class;

/**
 * @coversDefaultClass \Vivarium\Assertion\Hierarchy\ImplementsInterface
 */
final class ImplementsInterfaceTest extends TestCase
{
    /**
     * @covers ::__construct()
     * @covers ::assert()
     * @covers ::__invoke()
     */
    public function testAssert(): void
    {
        static::expectException(InvalidArgumentException::class);
        static::expectExceptionMessage('Expected class "stdClass" to implements "Traversable".');

        $mock = $this->createMock(Traversable::class);

        (new ImplementsInterface(Traversable::class))->assert(get_class($mock));
        (new ImplementsInterface(Traversable::class))->assert(stdClass::class);
    }

    /**
     * @covers ::assert()
     */
    public function testAssertWithoutInterface(): void
    {
        static::expectException(InvalidArgumentException::class);
        static::expectExceptionMessage('Expected string to be interface name. Got "stdClass".');

        (new ImplementsInterface(stdClass::class))->assert(stdClass::class);
    }

    /**
     * @covers ::assert()
     * @covers ::__invoke()
     */
    public function testAssertWithoutClass(): void
    {
        static::expectException(InvalidArgumentException::class);
        static::expectExceptionMessage('Expected string to be a class name. Got "Traversable".');

        (new ImplementsInterface(Traversable::class))->assert(Traversable::class);
    }
}
