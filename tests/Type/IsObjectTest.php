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
use stdClass;
use Vivarium\Assertion\Type\IsObject;

/**
 * @coversDefaultClass \Vivarium\Assertion\Type\IsObject
 */
final class IsObjectTest extends TestCase
{
    /**
     * @covers ::assert()
     * @covers ::__invoke()
     */
    public function testAssert(): void
    {
        static::expectException(InvalidArgumentException::class);
        static::expectExceptionMessage('Expected value to be object. Got integer.');

        (new IsObject())->assert(new stdClass());
        (new IsObject())->assert(42);
    }
}
