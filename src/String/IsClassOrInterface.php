<?php

declare(strict_types=1);

/*
 * This file is part of Vivarium
 * SPDX-License-Identifier: MIT
 * Copyright (c) 2021 Luca Cantoreggi
 */

namespace Vivarium\Assertion\String;

use Vivarium\Assertion\Assertion;
use Vivarium\Assertion\Conditional\Either;
use Vivarium\Assertion\Exception\AssertionFailed;

/**
 * @template-implements Assertion<string>
 * @psalm-immutable
 */
final class IsClassOrInterface implements Assertion
{
    /** @var Assertion<string> */
    private Assertion $assertion;

    public function __construct()
    {
        $this->assertion = new Either(
            new IsClass(),
            new IsInterface()
        );
    }

    /**
     * @param string $value
     *
     * @throws AssertionFailed
     *
     * @psalm-assert class-string $value
     */
    public function assert($value, string $message = ''): void
    {
        $message = (new IsEmpty())($message) ?
            'Argument must be a class or interface name. Got %s' : $message;

        $this->assertion->assert($value, $message);
    }

    /**
     * @param string $value
     *
     * @psalm-assert-if-true class-string $value
     */
    public function __invoke($value): bool
    {
        return ($this->assertion)($value);
    }
}
