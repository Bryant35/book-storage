<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Books;
use App\Models\Authors;
use App\Models\Category;
use DB;

class BookController extends Controller
{
    /**
     * Display a listing of the Books.
     */
    public function index()
    {
        //create join book and author and category
        $books = Books::join('authors', 'books.author_id', '=', 'authors.author_id')
        ->join('category', 'books.category_id', '=', 'category.category_id')
        ->select('books.*', 'authors.name as author_name', 'category.name as category_name')
        ->orderBy('books.title', 'asc')
        ->paginate(20);


        $books = Books::with('category')  // Eager load category to avoid N+1 query
        //add category name
            ->join('category', 'books.category_id', '=', 'category.category_id')
            ->select('books.*', 'category.name as category_name')
            ->orderBy('title', 'asc')  // Optionally, order books by title
            ->paginate(20);

        // dd($books);

        return view('welcome', compact('books'));
    }
}
