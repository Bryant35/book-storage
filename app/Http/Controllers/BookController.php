<?php

namespace App\Http\Controllers;

use App\Models\Books;
use App\Models\Authors;
use App\Models\Category;
use Couchbase\Role;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Traits\HasRoles;
use Spatie\Permission\Traits\HasPermissions;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Validator;

class BookController extends Controller
{
    use HasRoles, HasPermissions, HasRoles;
    use SoftDeletes;


    /**
     * Display a listing of the Books.
     */
    public function index()
    {
        $books = Books::getBooksWithDetails()->paginate(20);
    
        if(Auth::check()){
            return view('book.books', compact('books'));
        }else{
            return view('book.books', compact('books'));
        }
    }

    /**
     * Show the form for editing the specified book.
     * Fill the form with the choosen book data
     */
    public function bookEditView(Request $req){
        $book_id = $req->input('id');
        $page = $req->input('page');
        $author_id = '';
        $category_id = '';
        // get id author or category from previous page(Using if, so the page can be used for multiple page)
        if($req->input('author_id') != null){
            $author_id = $req->input('author_id');
        }
        if($req->input('category_id') != null){
            $category_id = $req->input('category_id');
        }

        // Go To Model
        $book = Books::getBookById($book_id);

        //Call all authors and categories list
        $authors = Authors::all();
        $categories = Category::all();

        //Validate user
        if(Auth::check()){
            return view('book.edit-book', compact('book', 'categories','authors', 'page', 'author_id', 'category_id'));
        }else{
            return redirect('/book/view')->with('error', 'You do not have access to this page.');
        }

        //Has Permission edit book
        //Comment this if you want to use the permission
        // if (Auth::user()->can('edit book')) {
        //     return view('book.edit-book', compact('book', 'categories','authors'));
        // } else {
        //     return redirect('/book/view')->with('error', 'You do not have access to this page.');
        // }        
    }

    /**
     * Update the specified book 
     */
    public function updateBook(Request $req)
    {
        try {
            $book = Books::find($req->book_id);

            // Check if book exists
            if (!$book) {
                $respond = 'error';
                $message = 'Book not found';
                if($req->input('page') == 'books'){
                    return redirect('/book/view')->with($respond, $message);
                }elseif($req->input('page') == 'book-by-author'){
                    return redirect('/author/view')->with($respond, $message);
                }
            }

            // Check what the user submitted
            if ($req->input('submit') == 'save') {
                // Basic validation (optional, you can customize)
                $req->validate([
                    'name' => 'required|string|max:255',
                    'category' => 'required|exists:category,category_id',
                    'authors' => 'required|array',
                    'content' => 'nullable|string',
                ]);

                $book->title = $req->input('name');
                $book->category_id = $req->input('category');
                $book->author_id = array_map('intval', $req->input('authors')); //array map to convert to int not string
                $book->content = $req->input('content');
                $book->save();

                $respond = 'success';
                $message = 'Book is Updated';
                // return redirect('/book/view')->with('success', 'Book is Updated');
            } elseif ($req->input('submit') == 'delete') {
                $book->delete();

                // Check if delete is success
                if ($book->deleted_at == null) {
                    $respond = 'error';
                    $message = 'Invalid action';
                    // return redirect('/book/view')->with('error', 'Book could not be deleted');
                } else {
                    $respond = 'success';
                    $message = 'Books is Deleted';
                    // return redirect('/book/view')->with('success', 'Book is Deleted');
                }
            } else {
                $respond = 'error';
                $message = 'Invalid action';
                // return redirect('/book/view')->with('error', 'Invalid action');
            }
 
            // return with existing respond and message
            if($req->input('page') == 'books'){
                return redirect('/book/view')->with($respond, $message);
            }elseif($req->input('page') == 'book-by-author'){
                $author_id = $req->input('author_id');
                return redirect('/author/book?id=' . $author_id)
                 ->with($respond, $message);
            }elseif($req->input('page') == 'book-by-category'){
                $category_id = $req->input('category_id');

                return redirect('/category/book?id=' . $category_id)
                 ->with($respond, $message);
            }
        } catch (\Exception $e) {
            // Catch any unexpected exception
            // return redirect('/book/view')->with('error', 'Something went wrong: ' . $e->getMessage());

            //back to last page
            // return redirect()->back()->with('error', 'Something went wrong: ' . $e->getMessage());
            $respond = 'error';
            $message = 'Something went wrong: ' . $e->getMessage();
            if($req->input('page') == 'books'){
                return redirect('/book/view')->with($respond, $message);
            }elseif($req->input('page') == 'book-by-author'){
                return redirect('/author/view')->with($respond, $message);
            }
        }
    }

    public function bookCreateView(){
        //Call all authors and categories list
        $authors = Authors::all();
        $categories = Category::all();

        return view('book.create-book', compact('categories','authors'));
    }

    public function addBook(Request $req){
        $validator = Validator::make($req->all(), [
            'name'=> 'required|string|max:255',
            'category' => 'required|exists:category,category_id',
            'authors' => 'required|array',
            'content' => 'nullable|string',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        try {
            $book = Books::create([
                'title' => $req->input('name'),
                'category_id' => $req->input('category'),
                'author_id' => array_map('intval', $req->input('authors')), //array map to convert to int not string
                'content' => $req->input('content'),
            ]);
            return redirect('/book/view')->with('success', 'Book is Created');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors($e->getMessage())->withInput();
        }
    }
}
