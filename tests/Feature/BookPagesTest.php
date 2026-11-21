<?php

namespace Tests\Feature;

use App\Models\Book;
use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookPagesTest extends TestCase
{
    use RefreshDatabase;

    public function test_books_page_shows_category_names_for_books_in_multiple_categories(): void
    {
        $technology = Category::create(['name' => 'Teknologi']);
        $accounting = Category::create(['name' => 'Akuntansi']);

        Book::create([
            'title' => 'Belajar Laravel',
            'author' => 'Penulis A',
            'category_id' => $technology->id,
        ]);
        Book::create([
            'title' => 'Dasar Akuntansi',
            'author' => 'Penulis B',
            'category_id' => $accounting->id,
        ]);

        $this->get('/books')
            ->assertOk()
            ->assertSee('Belajar Laravel')
            ->assertSee('Teknologi')
            ->assertSee('Dasar Akuntansi')
            ->assertSee('Akuntansi');
    }

    public function test_create_form_uses_category_ids_and_saving_a_book_links_it_to_category(): void
    {
        $category = Category::create(['name' => 'Manajemen']);

        $this->get('/books/create')
            ->assertOk()
            ->assertSee('<option value="'.$category->id.'"', false)
            ->assertSee('Manajemen');

        $this->post('/books', [
            'title' => 'Manajemen Organisasi',
            'author' => 'Penulis C',
            'category_id' => $category->id,
        ])->assertRedirect(route('books.index'));

        $this->assertDatabaseHas('books', [
            'title' => 'Manajemen Organisasi',
            'category_id' => $category->id,
        ]);

        $this->get('/books')->assertSee('Manajemen');
    }
}
