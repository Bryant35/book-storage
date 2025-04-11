<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Books;
use App\Models\Authors;
use App\Models\Category;
use Couchbase\Role;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Traits\HasRoles;
use Spatie\Permission\Traits\HasPermissions;
use Illuminate\Database\Eloquent\SoftDeletes;

class AuthorController extends Controller
{
    //
    use SoftDeletes, HasRoles, HasPermissions; 

    public function viewAuthor(){
        $authors = Authors::query()
        ->orderBy('name','asc')
        ->paginate(20);

        return view("author.author", compact("authors"));
    }

    public function viewBookByAuthor(Request $req){
        // $author = $req->query('author_id'); // get from URL
        
        $author = Authors::find($req->id);
        
        $books = Books::with('category')
        ->whereJsonContains('author_id', (int)$author->author_id)
        ->orderBy('title', 'asc')
        ->paginate(20);

        return view("author.book-by-author", compact("books", "author"));
    }

    public function editAuthor(Request $req){
        $author = Authors::find($req->id);

        return view("author.edit-author", compact("author"));
    }

    public function updateAuthor(Request $req){
        try {
            $req->validate([
                'name' => 'required|string|max:255',
            ]);
            $author = Authors::find($req->author_id);

            if($req->input('submit') == 'delete'){
                $author->delete();
                return redirect('/author/view')->with('success', 'Author deleted successfully');
            }elseif( $req->input('submit') == 'save'){
                $author->name = $req->input('name');
                $author->save();
                // Redirect Back to Author Pages, with error or success message
                if($author->name != $req->input('name')){
                    $message= 'Author name is not Updated';
                    return redirect()->back()->with('error', $message);
                }else{
                    return redirect('/author/view')->with('success', 'Author updated successfully');
                }
            }

        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()->withErrors($e->validator)->withInput();
        }   
    }
}
