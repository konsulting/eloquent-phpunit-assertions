<?php

namespace Konsulting\EloquentAssertions\Tests;

use PHPUnit\Framework\ExpectationFailedException;

class TestCase extends \PHPUnit\Framework\TestCase
{
    /**
     * Check that PHPUnit throws an expectation failed exception when the given callable is executed.
     *
     * @param callable $constraint
     */
    protected function checkExpectationFails(callable $constraint)
    {
        try {
            $constraint();
        } catch (ExpectationFailedException $e) {
            return;
        }

        $this->fail('Constraint did not fail.');
    }
}
