<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Traits\HasRoles;
use Spatie\Permission\Traits\HasPermissions;

class RoleController extends Controller
{
    //
    use HasRoles, HasPermissions;
    
    /**
     * show Roles list with sorting
     * @return \Illuminate\Contracts\View\View
     */
    public function indexRoles(){
        $sortField = request()->get('sort', 'name'); // default 'name'
        $sortOrder = request()->get('order', 'asc'); // default 'asc'
        $roles = Role::query()->orderBy($sortField, $sortOrder)->paginate(20);

        return view("role-management.role", compact("roles"));
    }

    public function editViewRole(Request $req, Role $role){
        $permissions = Permission::all();
        $role = Role::find($req->id);
        $rolePermissions = $role->permissions; // Collection of Permission objects
        dd($role, $permissions, $rolePermissions);
        return view("role-management.edit-role", compact("role", "permissions", "rolePermissions"));
    }
}
