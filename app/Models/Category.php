<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Model untuk Table Category
 * @var int
 */
class Category extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'category';

    protected $primaryKey = 'category_id';


    //isi kolom yang bisa diisi
    protected $fillable = [
        'name',
    ];

    // Relationships
    public function books()
    {
        return $this->hasMany(Books::class, 'category_id', 'category_id');
    }

    public $timestamps = true; 
}
