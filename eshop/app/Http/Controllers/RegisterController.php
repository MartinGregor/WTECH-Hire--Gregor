<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Game;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{

    public function showRegistrationForm()
    {
        return view('register');
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|string|unique:users,username|max:255',
            'email' => 'required|string|email|unique:users,email|max:255',
            'password' => 'required|string|confirmed|min:8',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $user = User::create([
            'role' => 'customer',
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $cart = Cart::create([
            'user_id' => $user->id,
        ]);

        auth()->login($user);

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
            } else {
                $userCart->games()->attach($game->id, ['quantity' => $item['quantity']]);
            }
        }
        session()->forget('cart');

        return redirect('/');
    }
}
