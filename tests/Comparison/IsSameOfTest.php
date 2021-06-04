<?php

/*
 * This file is part of Vivarium
 * SPDX-License-Identifier: MIT
 * Copyright (c) 2021 Luca Cantoreggi
 */

declare(strict_types=1);

namespace Vivarium\Assertion\Test\Comparison;

use PHPUnit\Framework\TestCase;
use stdClass;
use Vivarium\Assertion\Comparison\IsSameOf;
use Vivarium\Assertion\Exception\AssertionFailed;

/**
 * @coversDefaultClass \Vivarium\Assertion\Comparison\IsSameOf
 */
final class IsSameOfTest extends TestCase
{
    /**
     * @covers ::__construct()
     * @covers ::assert()
     * @covers ::__invoke()
     */
    public function testAssert(): void
    {
        static::expectException(AssertionFailed::class);
        static::expectExceptionMessage('Expected value to be the same of "stdClass". Got different object.');

        $stdClass = new stdClass();
        (new IsSameOf(42))->assert(42);
        (new IsSameOf($stdClass))->assert($stdClass);
        (new IsSameOf($stdClass))->assert(new stdClass());
    }
}
