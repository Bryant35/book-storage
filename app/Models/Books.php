<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Model untukTable Books
 *
 * @var string
 */
class Books extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'books';

    protected $primaryKey = 'book_id';

    protected $fillable = [
        'category_id',
        'author_id',
        'title',
        'content',
    ];

    protected $casts = [
        'author_id' => 'array',  // Make sure it's treated as an array
    ];

    public $timestamps = true;

    /**
     * Relationship with Category
     */
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'category_id');
    }

    /**
     * Get relationship with Authors
     */
    // public function getAuthorsAttribute()
    // {
    //     return Authors::whereIn('author_id', $this->author_id ?? [])->get();
    // }

    /**
     * Relationship with Authors
     */
    public function getAuthorsAttribute()
    {
        // Retrieve the author names from the authors table where author_id is in the author_id array
        return Authors::whereIn('author_id', $this->author_id)
            ->pluck('name')  // Get an array of author names
            ->toArray();  // Convert it to an array
    }


    /**
     * Get all books with their details
     *
     * @return string
     */
    public static function getBooksWithDetails()
    {
        // create join book and author and category
        $books = Books::join('authors', 'books.author_id', '=', 'authors.author_id')
            ->join('category', 'books.category_id', '=', 'category.category_id')
            ->select('books.*', 'authors.name as author_name', 'category.name as category_name')
            ->orderBy('books.title', 'asc');

        $books = Books::with('category')  // Eager load category to avoid N+1 query
        // add category name
            ->join('category', 'books.category_id', '=', 'category.category_id')
            ->select('books.*', 'category.name as category_name')
            ->orderBy('title', 'asc');

        return $books;
    }

    /**
     * get 1 book by id
     * @param mixed $book_id
     * @return Books|null
     */
    public static function getBookById($book_id)
    {
        // create join book and author and category
        $book = Books::join('authors', 'books.author_id', '=', 'authors.author_id')
            ->join('category', 'books.category_id', '=', 'category.category_id')
            ->select('books.*', 'authors.name as author_name', 'category.name as category_name')
            ->orderBy('books.title', 'asc');

        $book = Books::with('category')  // Eager load category to avoid N+1 query
        // add category name
            ->join('category', 'books.category_id', '=', 'category.category_id')
            ->select('books.*', 'category.name as category_name')
            ->where('books.book_id', $book_id)
            ->first();

        return $book;
    }
}
