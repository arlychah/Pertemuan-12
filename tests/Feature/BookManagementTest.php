<?php

namespace Tests\Feature;

use App\Models\Book;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Tests\TestCase;

class BookManagementTest extends TestCase
{
    use LazilyRefreshDatabase;

    public function test_books_index_shows_saved_books(): void
    {
        $book = Book::create([
            'title' => 'Belajar Laravel',
            'author' => 'Ayu',
            'published_year' => 2025,
        ]);

        $response = $this->get(route('books.index'));

        $response->assertOk()
            ->assertViewIs('books.index')
            ->assertViewHas('books', fn ($books) => $books->contains($book))
            ->assertSee('Belajar Laravel')
            ->assertSee('Ayu');
    }

    public function test_create_page_displays_the_book_form(): void
    {
        $response = $this->get(route('books.create'));

        $response->assertOk()
            ->assertViewIs('books.create')
            ->assertSee('Tambah Buku')
            ->assertSee('name="published_year"', false);
    }

    public function test_valid_book_submission_persists_and_redirects_to_the_list(): void
    {
        $response = $this->post(route('books.store'), [
            'title' => 'Pemrograman Web',
            'author' => 'Budi',
            'published_year' => 2024,
        ]);

        $response->assertRedirect(route('books.index'))
            ->assertSessionHas('success', 'Buku berhasil ditambahkan.');

        $this->assertDatabaseHas('books', [
            'title' => 'Pemrograman Web',
            'author' => 'Budi',
            'published_year' => 2024,
        ]);
    }

    public function test_empty_book_submission_returns_required_field_errors(): void
    {
        $response = $this->from(route('books.create'))
            ->post(route('books.store'), []);

        $response->assertRedirect(route('books.create'))
            ->assertSessionHasErrors([
                'title' => 'The title field is required.',
                'author' => 'The author field is required.',
                'published_year' => 'The published year field is required.',
            ]);

        $this->assertDatabaseCount('books', 0);
    }

    public function test_delete_removes_the_book_and_redirects_to_the_list(): void
    {
        $book = Book::create([
            'title' => 'Buku untuk Dihapus',
            'author' => 'Citra',
            'published_year' => 2023,
        ]);

        $response = $this->delete(route('books.destroy', $book));

        $response->assertRedirect(route('books.index'))
            ->assertSessionHas('success', 'Buku berhasil dihapus.');

        $this->assertDatabaseMissing('books', ['id' => $book->id]);
    }
}
