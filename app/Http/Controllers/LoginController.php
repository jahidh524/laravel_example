<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class LoginController extends Controller
{
    /**
     * Show the login form
     *
     * @return \Illuminate\View\View
     */
    public function showLoginForm()
    {
        return view('/login');
    }

    /**
     * Handle login request
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function login(Request $request)
    {
        $request->validate([
            'identifier' => 'required|string',
            'password' => 'required|string',
        ]);

        $identifier = $request->input('identifier');
        $password = $request->input('password');
        $fieldType = filter_var($identifier, FILTER_VALIDATE_EMAIL) ? 'email' : 
                    (is_numeric($identifier) ? 'phone' : 'username');

        // Attempt to authenticate the user
        $credentials = [
            $fieldType => $identifier,
            'password' => $password
        ];

        if (Auth::attempt($credentials)) {
            // Authentication successful
            $request->session()->regenerate();
            
            // Redirect to welcome page
            return redirect()->intended('/welcome');
        }

        // Authentication failed
        return back()->withErrors([
            'error' => 'The provided credentials do not match our records.',
        ]);
    }

    /**
     * Log the user out
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}