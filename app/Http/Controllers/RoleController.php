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

        $grouped = [];

        foreach ($permissions as $permission) {
            // explode by space: ['view', 'book']
            [$action, $feature] = explode(' ', $permission->name);
            $grouped[$feature][] = $permission->name;
        }
        
        return view("role-management.edit-role", compact("role", "permissions", "rolePermissions", "grouped"));
    }

    public function updateRole(Request $req, Role $role){
        $role = Role::find($req->role_id);//get role id
        $permissionsArray = $req->permissions;//get permission array that checked

        // sync permissions
        $role->syncPermissions($permissionsArray);//input the permissions to the role

        return redirect()->route('role')->with('success', 'Role updated successfully');
    }

    /**
     * show create role view (Pass permission data)
     * @return \Illuminate\Contracts\View\View
     */
    public function addRoleView(Request $req){
        $permissions = Permission::all();

        $grouped = [];

        foreach ($permissions as $permission) {
            // explode by space: ['view', 'book']
            [$action, $feature] = explode(' ', $permission->name);
            $grouped[$feature][] = $permission->name;
        }

        return view("role-management.create-role", compact("permissions", "grouped"));
    }

    /**
     * Creating New Role
     */
    public function addRole(Request $req){
        $role = Role::create(['name' => $req->role_name]);
        $permissionsArray = $req->permissions;

        // sync permissions
        $role->syncPermissions($permissionsArray);

        return redirect()->route('role')->with('success', 'Role created successfully');
    }
}
