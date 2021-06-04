<?php

/*
 * This file is part of Vivarium
 * SPDX-License-Identifier: MIT
 * Copyright (c) 2021 Luca Cantoreggi
 */

declare(strict_types=1);

namespace Vivarium\Assertion\Test\Comparison;

use PHPUnit\Framework\TestCase;
use Vivarium\Assertion\Comparison\IsEqualsTo;
use Vivarium\Assertion\Exception\AssertionFailed;
use Vivarium\Equality\Equality;

/**
 * @coversDefaultClass \Vivarium\Assertion\Comparison\IsEqualsTo
 */
final class IsEqualsToTest extends TestCase
{
    /**
     * @covers ::__construct()
     * @covers ::assert()
     * @covers ::__invoke()
     */
    public function testAssert(): void
    {
        static::expectException(AssertionFailed::class);
        static::expectExceptionMessage('Expected value to be equals to "RandomString". Got "Hello World"');

        (new IsEqualsTo(5))->assert(5);
        (new IsEqualsTo('RandomString'))->assert('Hello World');
    }

    /**
     * @covers ::__construct()
     * @covers ::assert()
     * @covers ::__invoke()
     */
    public function testAssertWithEqualityInterface(): void
    {
        static::expectException(AssertionFailed::class);
        static::expectExceptionMessage('Expected objects to be equals.');

        $equality  = $this->createMock(Equality::class);
        $equality1 = $this->createMock(Equality::class);

        $equality1
            ->expects(static::once())
            ->method('equals')
            ->with($equality)
            ->willReturn(false);

        (new IsEqualsTo($equality))
            ->assert($equality1, 'Expected objects to be equals.');
    }
}
