<?php

namespace Konsulting\EloquentAssertions\Tests;

use Konsulting\EloquentAssertions\EloquentAssertions;
use Konsulting\EloquentAssertions\Tests\Stubs\Book;
use PHPUnit\Framework\ExpectationFailedException;
use PHPUnit\Framework\TestCase;

class EloquentAssertionsTest extends TestCase
{
    use EloquentAssertions;

    /** @test */
    public function it_passes_if_two_models_are_the_same()
    {
        $book1 = new Book(['id' => 1]);
        $book2 = new Book(['id' => 1]);

        $this->assertNotSame($book1, $book2);
        $this->assertSameModel($book1, $book2);
    }

    /** @test */
    public function it_fails_if_two_models_have_different_ids()
    {
        $book1 = new Book(['id' => 1]);
        $book2 = new Book(['id' => 2]);

        $this->checkConstraintFails(fn() => $this->assertSameModel($book1, $book2));
    }

    protected function checkConstraintFails(callable $constraint)
    {
        try {
            $constraint();
        } catch (ExpectationFailedException $e) {
            return;
        }

        $this->fail('Constraint did not fail.');
    }
}
