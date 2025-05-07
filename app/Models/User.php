<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;
use Session;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;
    use HasFactory, HasRoles, SoftDeletes;

    // Define the table associated with the model (optional if the table name follows convention)
    protected $table = 'users';

    // Define the primary key if it's not the default 'id'
    protected $primaryKey = 'id';

    // Define the fillable attributes to protect against mass-assignment
    protected $fillable = [
        'name',
        'username',
        'email',
        'email_verified_at',
        'password',
    ];

    // Specify which attributes should be hidden (for security)
    protected $hidden = [
        'password',
        'remember_token',
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

    //relattionship with roles (1 roles can have many users)
    // and 1 user can have many roles
    // public function roles()
    // {
    //     return $this->belongsToMany(Role::class, 'model_has_roles', 'model_id', 'role_id');
    // }
}
