<?php

/*
 * This file is part of Vivarium
 * SPDX-License-Identifier: MIT
 * Copyright (c) 2021 Luca Cantoreggi
 */

declare(strict_types=1);

namespace Vivarium\Assertion\Test\Helpers;

use PHPUnit\Framework\TestCase;
use stdClass;
use Vivarium\Assertion\Helpers\TypeToString;

/**
 * @coversDefaultClass \Vivarium\Assertion\Helpers\TypeToString
 */
final class ToStringTest extends TestCase
{
    /**
     * @covers ::__invoke()
     */
    public function testToString(): void
    {
        static::assertSame('true', (new TypeToString())(true));
        static::assertSame('false', (new TypeToString())(false));
        static::assertSame('null', (new TypeToString())(null));
        static::assertSame('array', (new TypeToString())([]));
        static::assertSame('"string"', (new TypeToString())('string'));
        static::assertSame('"stdClass"', (new TypeToString())(new stdClass()));
        static::assertSame('42', (new TypeToString())(42));
    }
}
