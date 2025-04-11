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

class CategoryController extends Controller
{
    //
    use SoftDeletes, HasRoles, HasPermissions; 

    /**
     * Overview of Category
     * @return \Illuminate\Contracts\View\View
     */
    public function viewCategory(){
        $categories = Category::query()
        ->orderBy('name','asc')
        ->paginate(20);

        return view("category.category", compact("categories"));
    }

    /**
     * View book list by Category Selected
     * @param \Illuminate\Http\Request $req
     * @return \Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     */
    public function viewBookByCategory(Request $req){
        try {
            $category = Category::find($req->id);

        if (!$category) {
            return redirect()->back()->with('error', 'Category not found');
        }

        // create join book and author and category
        $books = Books::join('authors', 'books.author_id', '=', 'authors.author_id')
            ->join('category', 'books.category_id', '=', 'category.category_id')
            ->select('books.*', 'authors.name as author_name')
            ->orderBy('books.title', 'asc');
            
        $books = Books::with('category')  // Eager load category to avoid N+1 query
            ->join('category', 'books.category_id', '=', 'category.category_id')
            ->select('books.*', 'category.name as category_name')
            ->where('books.category_id', $category->category_id)
            ->paginate(20);

        return view("category.book-by-category", compact("books", "category"));

        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /** 
     * Show the form for editing the specified category.
     * Fill the form with the choosen category data
     * @param \Illuminate\Http\Request $req
     * using GET method
     */
    public function editViewCategory(Request $req){
        try {
            $category = Category::find($req->id);

            if (!$category) {
                return redirect()->back()->with('error', 'Category not found');
            }

            return view("category.edit-category", compact("category"));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Save or Delete the Category
     * @param \Illuminate\Http\Request $req
     * using POST method
     */
    public function updateCategory(Request $req){

        try {
            $category = Category::find($req->input('category_id'));

            if (!$category) {
                return redirect()->back()->with('error', 'Category not found');
            }

            if ($req->input('submit') == 'delete') {
                $category->delete();
                return redirect('/category/view')->with('success', 'Category deleted successfully');
            } elseif ($req->input('submit') == 'save') {
                $category->name = $req->input('name');
                $category->save();
                // Redirect Back to Category Pages, with error or success message
                if ($category->name != $req->input('name')) {
                    $message = 'Category name is not Updated';
                    return redirect()->back()->with('error', $message);
                } else {
                    return redirect('/category/view')->with('success', 'Category updated successfully');
                }
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
