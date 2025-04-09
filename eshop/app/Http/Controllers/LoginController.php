<?php

namespace App\Http\Controllers;

use App\Models\Game;
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

        if (Auth::user()->role == 'admin') {
            return redirect()->route('admin');  // Use the correct route name 'admin'
        }

        $user = Auth::user();
        $userCart = $user->cart()->firstOrCreate([
            'user_id' => $user->id,
        ]);

        $cart = session()->get('cart', []);
        foreach ($cart as $item) {
            $game = Game::find($item['game_id']);

            $existingGame = $userCart->games()->where('game_id', $game->id)->first();

            if ($existingGame) {
                $newQuantity = $existingGame->pivot->quantity + $item['quantity'];
                $userCart->games()->updateExistingPivot($game->id, [
                    'quantity' => $newQuantity
                ]);
            }
            else {
                $userCart->games()->attach($game->id, ['quantity' => $item['quantity']]);
            }
        }
        session()->forget('cart');

        return redirect('/');
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/login');
    }
}
