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
use DB;use Illuminate\Contracts\Auth\MustVerifyEmail;


class UserController extends Controller
{
    //
    use HasRoles, HasPermissions, SoftDeletes;

    /**
     * Show user list with sorting
     */
    public function index()
    {
        $sortField = request()->get('sort', 'name'); // default 'name'
        $sortOrder = request()->get('order', 'asc'); // default 'asc'
        $search = request()->get('search', ''); // default empty
        $searchField = request()->get('searchField', 'name'); // default 'name'

        $users = User::with('roles')
                ->when($search, function ($query) use ($searchField, $search) {
                    $query->where($searchField, 'like', "%{$search}%");
                })
                ->orderBy($sortField, $sortOrder)
                ->paginate(20);


        return view("user-management.user", compact("users"));
    }

    /**
     * Create new User for login with random password
     * @param \Illuminate\Http\Request $req
     * @return \Illuminate\Http\RedirectResponse
     */
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

    /**
     * View selected data user on Form to Edit
     */
    public function editViewUser(Request $req){
        $user = User::find($req->id);
        $roles = Role::all();

        // Get an array of role names
        $userRole = $user->getRoleNames()->first(); 


        return view('user-management.user-edit', compact('user','roles','userRole'));
    }

    /**
     * Update user data or with password change or delete user
     */
    public function updateUser(Request $req){
        $user = User::find($req->id);
        if (empty($req->name) || empty($req->username)) {
            return redirect()->back()->with('error', 'Data cannot be empty');
        }
        
        $existingName = User::where('name', $req->name)->where('id', '!=', $req->id)->first();
        if ($existingName) { // Check if name is used
            return redirect()->back()->with('error', 'Fullname is already in use');
        }
        $existingUsername = User::where('username', $req->username)->where('id', '!=', $req->id)->first();
        if ($existingUsername) { // Check if username is used
            return redirect()->back()->with('error', 'Username is already in use');
        }
        
        if($req->input('submit') !== 'delete'){//Save or update user
            $user->name = $req->name;
            $user->username = $req->username;
            if($user->role !== $user->getRoleNames()->first()){
                //remove Role
                $user->syncRoles([]); 
                // Assign the new role
                $user->assignRole($req->role);
            }
            
            if ($req->input('submit') == 'changePass') { //with password change
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
        }elseif( $req->input('submit') == 'delete'){ //Delete user
            $user->delete();
            return redirect('/user')->with('success', 'User deleted successfully');
        }
    }

    /**
     * Create guest user
     */
    public function createGuestUser(Request $req){
        $name = $req->name;
        $username = $req->username;
        // $email = $req->email;
        $checkUsername = User::where('username', $username)->first();
        $password = $req->password;
        if(empty($username) || empty($password)){
            return redirect()->back()->with('error', 'Data cannot be empty');
        }
        if($checkUsername){
            return redirect()->back()->with('error', 'Username already exists')->withInput([
                'name' => $name,
            ]); 
        }

        $user = User::create([
            "name"=> $req->name,
            "username"=> $req->username,
            "password"=> bcrypt($password),
        ]);
        $user->assignRole('Guest');

        return redirect('/book/view')->with([
            'success' => 'Guest user created successfully'
        ]);
    }
}
