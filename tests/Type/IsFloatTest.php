<?php

/*
 * This file is part of Vivarium
 * SPDX-License-Identifier: MIT
 * Copyright (c) 2021 Luca Cantoreggi
 */

declare(strict_types=1);

namespace Vivarium\Assertion\Test\Type;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Vivarium\Assertion\Type\IsFloat;

/**
 * @coversDefaultClass \Vivarium\Assertion\Type\IsFloat
 */
final class IsFloatTest extends TestCase
{
    /**
     * @covers ::assert()
     * @covers ::__invoke()
     */
    public function testAssert(): void
    {
        static::expectException(InvalidArgumentException::class);
        static::expectExceptionMessage('Expected value to be float. Got string.');

        (new IsFloat())->assert(4.5);
        (new IsFloat())->assert('Hello World');
    }
}
