<?php

/*
 * This file is part of Vivarium
 * SPDX-License-Identifier: MIT
 * Copyright (c) 2021 Luca Cantoreggi
 */

declare(strict_types=1);

namespace Vivarium\Assertion\Test\Type;

use PHPUnit\Framework\TestCase;
use Vivarium\Assertion\Exception\AssertionFailed;
use Vivarium\Assertion\Type\IsCallable;
use Vivarium\Assertion\Type\IsInteger;

/**
 * @coversDefaultClass \Vivarium\Assertion\Type\IsCallable
 */
final class IsCallableTest extends TestCase
{
    /**
     * @covers ::assert()
     * @covers ::__invoke()
     */
    public function testAssert(): void
    {
        static::expectException(AssertionFailed::class);
        static::expectExceptionMessage('Expected value to be callable. Got integer.');

        (new IsCallable())->assert(new IsInteger());
        (new IsCallable())->assert(42);
    }
}
