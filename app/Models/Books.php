<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


    /**
     * Model untukTable Books
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
        'content'
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
    // public function author()
    // {
    //     return $this->hasMany(Authors::class, 'author_id', 'author_id');
    // }

    public function getAuthorsAttribute()
    {
        // Retrieve the author names from the authors table where author_id is in the author_id array
        return Authors::whereIn('author_id', $this->author_id)
            ->pluck('name')  // Get an array of author names
            ->toArray();  // Convert it to an array
    }
    
}
