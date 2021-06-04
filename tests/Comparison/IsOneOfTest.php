<?php

/*
 * This file is part of Vivarium
 * SPDX-License-Identifier: MIT
 * Copyright (c) 2021 Luca Cantoreggi
 */

declare(strict_types=1);

namespace Vivarium\Assertion\Test\Comparison;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Vivarium\Assertion\Comparison\IsOneOf;
use Vivarium\Equality\Equality;

/**
 * @coversDefaultClass \Vivarium\Assertion\Comparison\IsOneOf
 */
final class IsOneOfTest extends TestCase
{
    /**
     * @covers ::__construct()
     * @covers ::assert()
     * @covers ::__invoke()
     */
    public function testAssert(): void
    {
        static::expectException(InvalidArgumentException::class);
        static::expectExceptionMessage('Expected value to be one of the values provided. Got 27.');

        $oneOf = new IsOneOf(1, 5, 7, 42);

        $oneOf->assert(1);
        $oneOf->assert(5);
        $oneOf->assert(7);
        $oneOf->assert(42);

        $oneOf->assert(27);
    }

    /**
     * @covers ::__construct()
     * @covers ::assert()
     * @covers ::__invoke()
     */
    public function testAssertWithEquality(): void
    {
        static::expectException(InvalidArgumentException::class);
        static::expectExceptionMessage('Expected value to be one of the values provided. Got different object.');

        $element1 = $this->createMock(Equality::class);
        $element2 = $this->createMock(Equality::class);
        $element3 = $this->createMock(Equality::class);
        $element4 = $this->createMock(Equality::class);

        $search = $this->createMock(Equality::class);
        $search
            ->expects(static::exactly(4))
            ->method('equals')
            ->withConsecutive([$element1], [$element2], [$element3], [$element4])
            ->willReturn(false);

        (new IsOneOf($element1, $element2, $element3, $element4))->assert($search);
    }
}
