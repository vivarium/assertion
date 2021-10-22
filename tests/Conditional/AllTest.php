<?php

/*
 * This file is part of Vivarium
 * SPDX-License-Identifier: MIT
 * Copyright (c) 2021 Luca Cantoreggi
 */

declare(strict_types=1);

namespace Vivarium\Assertion\Test\Conditional;

use PHPUnit\Framework\TestCase;
use Vivarium\Assertion\Conditional\All;
use Vivarium\Assertion\Exception\AssertionFailed;
use Vivarium\Assertion\Numeric\IsGreaterThan;
use Vivarium\Assertion\Numeric\IsLessOrEqualThan;
use Vivarium\Assertion\String\Contains;
use Vivarium\Assertion\String\IsLongAtLeast;

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
        static::expectException(AssertionFailed::class);
        static::expectExceptionMessage('Expected string to be long at least 10. Got 6.');

        (new All(
            new IsGreaterThan(0),
            new IsLessOrEqualThan(7)
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
        static::expectException(AssertionFailed::class);
        static::expectExceptionMessage('Expected number to be less or equal than 1. Got 5.');

        (new All(
            new IsGreaterThan(0),
            new IsLessOrEqualThan(1)
        ))->assert(5);
    }

    /**
     * @covers ::__invoke()
     */
    public function testInvoke(): void
    {
        $assertion1 = (new All(
            new IsGreaterThan(0),
            new IsLessOrEqualThan(7)
        ));

        static::assertTrue($assertion1(5));
    }

    /**
     * @covers ::__construct()
     * @covers ::__invoke()
     */
    public function testInvokeFail(): void
    {
        $assertion = (new All(
            new IsGreaterThan(0),
            new IsLessOrEqualThan(1)
        ));

        static::assertFalse($assertion(7));
    }
}
