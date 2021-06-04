<?php

/*
 * This file is part of Vivarium
 * SPDX-License-Identifier: MIT
 * Copyright (c) 2021 Luca Cantoreggi
 */

declare(strict_types=1);

namespace Vivarium\Assertion\Test\Conditional;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Vivarium\Assertion\Conditional\Not;
use Vivarium\Assertion\Type\IsString;

/**
 * @coversDefaultClass \Vivarium\Assertion\Conditional\Not
 */
final class NotTest extends TestCase
{
    /**
     * @covers ::__construct()
     * @covers ::assert()
     */
    public function testAssert(): void
    {
        static::expectException(InvalidArgumentException::class);
        static::expectExceptionMessage(
            'Failed negating the assertion "Vivarium\Assertion\Type\IsString" with value "Hello World".'
        );

        (new Not(new IsString()))->assert(42);
        (new Not(new IsString()))->assert('Hello World');
    }

    /**
     * @covers ::__invoke()
     */
    public function testInvoke(): void
    {
        static::assertTrue((new Not(new IsString()))(42));
        static::assertFalse((new Not(new IsString()))('Hello World'));
    }
}
