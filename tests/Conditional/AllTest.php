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
use Vivarium\Assertion\Conditional\All;
use Vivarium\Assertion\Hierarchy\IsAssignableTo;
use Vivarium\Assertion\Numeric\IsInClosedRange;
use Vivarium\Assertion\String\Contains;
use Vivarium\Assertion\String\IsClass;
use Vivarium\Assertion\String\IsLongAtLeast;
use Vivarium\Assertion\Test\Stub\Stub;
use Vivarium\Assertion\Test\Stub\StubClassExtension;
use Vivarium\Assertion\Type\IsInteger;

/**
 * @coversDefaultClass \Vivarium\Assertion\Conditional\All
 */
final class AllTest extends TestCase
{
    /**
     * @covers ::__construct()
     * @covers ::assert()
     */
    public function testAssert(): void
    {
        static::expectException(InvalidArgumentException::class);
        static::expectExceptionMessage('Expected string to be long at least 10. Got 6.');

        (new All(
            new IsInteger(),
            new IsInClosedRange(0, 9)
        ))->assert(5);

        (new All(
            new IsLongAtLeast(10),
            new Contains('Random')
        ))->assert('Random');
    }

    /**
     * @covers ::__construct()
     * @covers ::assert()
     */
    public function testAssertFailLater(): void
    {
        static::expectException(InvalidArgumentException::class);
        static::expectExceptionMessage('Expected number to be in closed range [0, 1]. Got 5.');

        (new All(
            new IsInteger(),
            new IsInClosedRange(0, 1)
        ))->assert(5);
    }

    /**
     * @covers ::__invoke()
     */
    public function testInvoke(): void
    {
        $assertion = new All(
            new IsClass(),
            /**
             * @TODO PHPStan does not recognize class-string as subtype of string.
             * @phpstan-ignore-next-line
             */
            new IsAssignableTo(StubClassExtension::class)
        );

        $assertion1 = new All(
            new IsInteger(),
            new IsInClosedRange(0, 9)
        );

        static::assertFalse($assertion(Stub::class));
        static::assertTrue($assertion1(5));
    }
}
