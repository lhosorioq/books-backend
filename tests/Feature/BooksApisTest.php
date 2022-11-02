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
        )->assertJsonFragment(
            [
                'title' => $books[1]->title
            ]
        );
    }

    /** @test */
    function can_get_one_book()
    {
        $book = Book::factory()->create();
        // $response = $this->getJson(route('books.show', $book));
        // $response->assertJsonFragment(
        //     [
        //         'title' => $book->title
        //     ]
        // );
        $this->getJson(route('books.show', $book))
            ->assertJsonFragment(
                [
                    'title' => $book->title
                ]
            );
    }

    /** @test */
    function can_create_book()
    {
        $this->postJson(route('books.store'), [])
            ->assertJsonValidationErrorFor('title');
        $this->postJson(route('books.store'), [
            'title' => 'My new little book'
            ]
        )->assertJsonFragment(
            [
                'title' => 'My new little book'
            ]
        );
        $this->assertDatabaseHas(
            'books',
            [
                'title' => 'My new little book'
            ]
        );
    }

    /** @test */
    function can_update_books()
    {
        $book = Book::factory()->create();
        $this->patchJson(route('books.update', $book), [])
            ->assertJsonValidationErrorFor('title');
        $this->patchJson(route('books.update', $book), [
            'title' => 'Edited little book'
        ])->assertJsonFragment(
            [
                'title' => 'Edited little book'
            ]
        );
        $this->assertDatabaseHas('books', [
            'title' => 'Edited little book'
        ]);
    }

    /** @test */
    function can_delete_books()
    {
        $book = Book::factory()->create();
        $this->deleteJson(route('books.destroy', $book))
            ->assertNoContent();
        $this->assertDatabaseCount('books', 0);
    }

}
