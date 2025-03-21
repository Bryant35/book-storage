<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Session;

class User extends Authenticatable
{
    use HasFactory, SoftDeletes;

    // Define the table associated with the model (optional if the table name follows convention)
    protected $table = 'users';

    // Define the primary key if it's not the default 'id'
    protected $primaryKey = 'id';

    // Define the fillable attributes to protect against mass-assignment
    protected $fillable = [
        'name', 
        'username', 
        'password'
    ];

    // Specify which attributes should be hidden (for security)
    protected $hidden = [
        'password', 
        'remember_token'
    ];

    // Specify the attributes that should be cast to native types
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Relationships (if applicable, e.g., a user can have many sessions)
    public function sessions()
    {
        return $this->hasMany(Session::class);
    }
}
