<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    /**
     * Zobraziť prihlasovací formulár.
     *
     * @return \Illuminate\View\View
     */
    public function showLoginForm()
    {
        return view('auth.login'); // Tento riadok zobrazuje vašu Blade šablónu pre prihlásenie
    }

    /**
     * Prihlásenie používateľa.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function login(Request $request)
    {
        // Validácia prihlasovacích údajov
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput();
        }

        // Pokus o prihlásenie
        if (Auth::attempt([
            'email' => $request->email,
            'password' => $request->password,
        ], $request->has('remember'))) {
            // Po úspešnom prihlásení presmerovanie na domovskú stránku alebo stránku, ktorú mal používateľ predtým
            return redirect()->intended('/');
        }

        // Ak sa prihlasenie nepodarí
        return Redirect::back()->withErrors(['email' => 'Invalid credentials'])->withInput();
    }

    /**
     * Odhlásenie používateľa.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }
}
