<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Traits\HasRoles;
use Spatie\Permission\Traits\HasPermissions;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\User;

class UserController extends Controller
{
    //
    use HasRoles, HasPermissions, SoftDeletes;

    public function index()
    {
        // $users = User::query()
        //     ->orderBy('name', 'asc')
        //     ->paginate(20);
        //create $users join with model_has_roles and roles
        $users = User::with('roles')->orderBy('name', 'asc')->paginate(20);
        // dd($users);
        
        dd($users);
        return view("user-management.user", compact("users"));
    }
}
