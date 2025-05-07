<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Traits\HasRoles;
use Spatie\Permission\Traits\HasPermissions;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use App\Models\User;
use DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Auth\Events\Registered;

class ProfileController extends Controller
{
    use HasRoles, HasPermissions, SoftDeletes;

    /**
     * Show Profile Page
     */
    public function viewProfile(Request $req)
    {
        // dd($req->user()->id);
        $user = Auth::user()->with('roles')->where('id', '=', $req->user()->id)->first();

        return view("profile.user-profile", compact("user"));
    }

    public function sendVerificationEmail()
    {
        $user = Auth::user();
        
        if ($user->hasVerifiedEmail()) {
            return response()->json(['message' => 'Email is already verified.'], 400);
        }

        $user->sendEmailVerificationNotification();
        return response()->json(['message' => 'Verification email sent!'], 200);
    }


    /**
     * Update Profile
     */
    public function updateProfile(Request $req){
        $req->validate([
            'username' => 'required|string|max:255',
            'email' => 'required|email|max:255',
        ]);

        $user = Auth::user();
        $newEmail = $req->input('email');

        $user->username = $req->input('username');

        // Handle email change
        if ($user->email !== $newEmail) {
            $user->email = $newEmail;
            $user->email_verified_at = null;
            $user->save();

            // Send email verification to new address
            $user->sendEmailVerificationNotification();

            return redirect()->back()->with('message', 'Email updated. Please verify your new email.');
        }
        $user->save();

        return redirect('/profile')->with('success', 'Profile updated successfully');

    }

    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . Auth::id(),
        ]);

        $user = Auth::user();

        $emailChanged = $request->email !== $user->email;

        $user->name = $request->name;
        $user->email = $request->email;

        if ($emailChanged) {
            $user->email_verified_at = null;
        }

        $user->save();

        // 🔔 This triggers Laravel to send the email verification
        if ($emailChanged) {
            event(new Registered($user));
        }

        return redirect('/profile')->with('success', 'Profile updated successfully');
    }
}
