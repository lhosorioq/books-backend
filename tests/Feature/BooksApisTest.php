<?php

namespace Tests\Feature;

use App\Models\Book;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BooksApisTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function can_get_all_books()
    {
        // $book = Book::factory()->create();
        $books = Book::factory(5)->create();
        // dd($book);
        // dd($books->count());
        // $this->get('/api/books')->dump();
        // $this->get(route('books.index'))->dump();
        $response = $this->getJson(route('books.index'));
        $response->assertJsonFragment(
            [
                'title' => $books[0]->title
            ]
            );
    }
}
