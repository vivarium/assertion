<?php

/**
 * This file is part of Vivarium
 * SPDX-License-Identifier: MIT
 * Copyright (c) 2020 Luca Cantoreggi
 */

declare(strict_types=1);

namespace Vivarium\Assertion\Conditional;

use InvalidArgumentException;
use Vivarium\Assertion\Assertion;
use function array_merge;

final class All implements Assertion
{
    /** @var Assertion[] */
    private array $assertions;

    public function __construct(Assertion $assertion, Assertion ...$assertions)
    {
        $this->assertions = array_merge([$assertion], $assertions);
    }

    /**
     * @param mixed $value
     *
     * @throws InvalidArgumentException
     */
    public function assert($value, string $message = '') : void
    {
        foreach ($this->assertions as $assertion) {
            $assertion->assert($value, $message);
        }
    }

    /**
     * @param mixed $value
     */
    public function __invoke($value) : bool
    {
        try {
            $this->assert($value);
        } catch (InvalidArgumentException $ex) {
            return false;
        }

        return true;
    }
}
