<?php

namespace App\Http\Controllers;

use App\Models\Books;
use App\Models\Category;
use Couchbase\Role;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Traits\HasRoles;
use Spatie\Permission\Traits\HasPermissions;
use Illuminate\Http\Request;

class BookController extends Controller
{
    /**
     * Display a listing of the Books.
     */
    public function index()
    {

        $books = Books::getBooksWithDetails()->paginate(20);
        
        // // create join book and author and category
        // $books = Books::join('authors', 'books.author_id', '=', 'authors.author_id')
        //     ->join('category', 'books.category_id', '=', 'category.category_id')
        //     ->select('books.*', 'authors.name as author_name', 'category.name as category_name')
        //     ->orderBy('books.title', 'asc')
        //     ->paginate(20);

        // $books = Books::with('category')  // Eager load category to avoid N+1 query
        // // add category name
        //     ->join('category', 'books.category_id', '=', 'category.category_id')
        //     ->select('books.*', 'category.name as category_name')
        //     ->orderBy('title', 'asc')  // Optionally, order books by title
        //     ->paginate(20);
    
        // dd($books);
        if(Auth::check()){
            // dd(Auth::user()->hasRole('Admin'));
            return view('book.books', compact('books'));
        }else{
            return view('welcome', compact('books'));
        }
    }

    public function bookEditView(Request $req){
        $book_id = $req->input('id');

        // Go To Model
        $book = Books::getBookById($book_id);
        dd($book);

        if(Auth::check()){
            return view('book.edit', compact('book'));
        }else{
            return redirect('/system/home')->with('error', 'You do not have access to this page.');
        }
    }
}
