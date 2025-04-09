<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Books;
use Auth;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    /**
     * Validate the user login
     */
    public function login(Request $request)
    {
        $username = $request->input('username');
        $password = $request->input('password');
        $rememberMe = $request->input('remember');
        if ($username == null || $password == null) {
            flash()->error('Username atau Password tidak boleh kosong!');

            return redirect()->back()->withInput();
        }
        $user = User::where('username', $username)->first();

        // Check if the username exists
        if (! $user) {
            flash()->error('Username atau Password Salah!');

            return redirect()->back()->withInput();
        }
        // Check if the password is correct
        elseif ($user->username === $username && password_verify($password, $user->password)) {
            if ($rememberMe) {
                Auth::login($user, true);
            } else {
                Auth::login($user);
            }
            flash()->success('Login Berhasil!');

            return redirect('/system/home');
        }
        // If the password is incorrect
        else {
            flash()->error('Username atau Password Salah!');

            return redirect()->back()->withInput();
        }

    }

    /**
     * Logout the user
     */
    public function logout(Request $request)
    {
        Auth::logout();
        // dd(Auth::check());
        if (Auth::check()) {
            return view('dashboard.landing');
        } else {
            flash()->info('Logout Berhasil!');

            return redirect('/');
        }
    }
}
