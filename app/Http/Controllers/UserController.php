<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Traits\HasRoles;
use Spatie\Permission\Traits\HasPermissions;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use App\Models\User;
use DB;

class UserController extends Controller
{
    //
    use HasRoles, HasPermissions, SoftDeletes;

    public function index()
    {
        $sortField = request()->get('sort', 'name'); // default 'name'
        $sortOrder = request()->get('order', 'asc'); // default 'asc'

        $users = User::with('roles')->orderBy($sortField, $sortOrder)->paginate(20);


        return view("user-management.user", compact("users"));
    }

    public function addUser(Request $req){
        $username = $req->username;
        $checkUsername = User::where('username', $username)->first();
        if($checkUsername){
            return redirect()->back()->with('error', 'Username already exists');
        }
        $randomPassword = Str::random(8);

        $user = User::create([
            "name"=> $req->name,
            "username"=> $req->username,
            "password"=> bcrypt($randomPassword),
        ]);
        $user->assignRole($req->role);

        return redirect('/user')->with([
            'success' => 'User created successfully',
            'random_password' => $randomPassword,
            'new_user' => $req->username,
        ]);
    }

    public function editViewUser(Request $req){
        $user = User::find($req->id);
        $roles = Role::all();

        // Get an array of role names
        $userRole = $user->getRoleNames()->first(); 


        return view('user-management.user-edit', compact('user','roles','userRole'));
    }

    public function updateUser(Request $req){
        $user = User::find($req->id);
        if (empty($req->name)) {
            return redirect()->back()->with('error', 'Full name cannot be empty');
        }
        
        $existingName = User::where('name', $req->name)->where('id', '!=', $req->id)->first();
        if ($existingName) {
            return redirect()->back()->with('error', 'Fullname is already in use');
        }
        $existingUsername = User::where('username', $req->username)->where('id', '!=', $req->id)->first();
        if ($existingUsername) {
            return redirect()->back()->with('error', 'Username is already in use');
        }
        
        if($req->input('submit') !== 'delete'){
            $user->name = $req->name;
            $user->username = $req->username;
            if($user->role !== $user->getRoleNames()->first()){
                //remove Role
                $user->syncRoles([]); 
                // Assign the new role
                $user->assignRole($req->role);
            }
            
            if ($req->input('submit') == 'changePass') {
                $randomPassword = Str::random(8);
                $user->password = bcrypt($randomPassword);
                $user->save();

                return redirect('/user')->with([
                    'success' => 'User updated successfully',
                    'random_password' => $randomPassword,
                    'new_user' => $req->username,
                ]);
            }

            // Regular update without password change
            $user->save();

            return redirect('/user')->with('success', 'User updated successfully');
        }elseif( $req->input('submit') == 'delete'){
            $user->delete();
            return redirect('/user')->with('success', 'User deleted successfully');
        }
    }
}
