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
use Vivarium\Assertion\Type\IsBoolean;

/**
 * @coversDefaultClass \Vivarium\Assertion\Type\IsBoolean
 */
final class IsBooleanTest extends TestCase
{
    /**
     * @covers ::assert()
     * @covers ::__invoke()
     */
    public function testAssert(): void
    {
        static::expectException(InvalidArgumentException::class);
        static::expectExceptionMessage('Expected value to be boolean. Got integer.');

        (new IsBoolean())->assert(true);
        (new IsBoolean())->assert(42);
    }
}
