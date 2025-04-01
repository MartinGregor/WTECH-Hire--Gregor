<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string|min:8',
        ]);

        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput();
        }

        $user = \App\Models\User::where('email', $request->email)->first();

        if (!$user) {
            return Redirect::back()->withErrors(['email' => 'Email not found'])->withInput();
        }

        if (!Auth::attempt(['email' => $request->email, 'password' => $request->password], $request->has('remember'))) {
            return Redirect::back()->withErrors(['password' => 'Incorrect password'])->withInput();
        }

        return redirect('/home');
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }
}
