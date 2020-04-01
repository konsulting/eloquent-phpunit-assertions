<?php

namespace Konsulting\EloquentAssertions\Tests;

use Konsulting\EloquentAssertions\EloquentAssertions;
use Konsulting\EloquentAssertions\Tests\Stubs\Author;
use Konsulting\EloquentAssertions\Tests\Stubs\Book;

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

        $this->checkExpectationFails(
            fn() => $this->assertSameModel($book1, $book2)
        );
    }

    /** @test */
    public function it_fails_if_two_models_are_of_different_types()
    {
        $book = new Book(['id' => 1]);
        $author = new Author(['id' => 1]);

        $this->checkExpectationFails(
            fn() => $this->assertSameModel($book, $author)
        );
    }

    /** @test */
    public function it_checks_if_a_model_has_soft_deletes()
    {
        $this->assertHasSoftDeletes(Author::class);
        $this->assertHasSoftDeletes(new Author);

        $this->checkExpectationFails(
            fn() => $this->assertHasSoftDeletes(Book::class)
        );
        $this->checkExpectationFails(
            fn() => $this->assertHasSoftDeletes(new Book)
        );
    }
}
