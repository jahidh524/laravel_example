<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\User;

class RegisterController extends Controller
{
    public function signup(Request $request)
    {
        $user = new User();
        $user->name = $request->name;    
        $user->phone = $request->phone;
        $user->username = $request->username;
        $user->password = Hash::make($request->password);
        $user->save();

        return redirect('/login')->with('success', 'Registration successful. Please log in.');
    }
}
