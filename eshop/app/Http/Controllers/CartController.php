<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index()
    {
        return view('cart');
    }

    public function insertToCart(Request $request)
    {
        $gameId = $request->input('game_id');
        $quantity = $request->input('quantity');
        $game = Game::findOrFail($gameId);

        if (Auth::check()) {
            // Logged-in user logic
            $user = Auth::user();
            $cart = $user->cart()->firstOrCreate([
                'user_id' => $user->id,
            ]);

            $existingGame = $cart->games()->where('game_id', $gameId)->first();

            if ($existingGame) {
                $newQuantity = $existingGame->pivot->quantity + $quantity;
                $cart->games()->updateExistingPivot($gameId, [
                    'quantity' => $newQuantity
                ]);
            } else {
                $cart->games()->attach($gameId, ['quantity' => $quantity]);
            }
        } else {
            // Guest user logic (use session)
            $cart = session()->get('cart', []);

            if (isset($cart[$gameId])) {
                $cart[$gameId]['quantity'] += $quantity;
            } else {
                $cart[$gameId] = [
                    'game_id' => $gameId,
                    'quantity' => $quantity
                ];
            }

            session()->put('cart', $cart);
        }

        return redirect()->route('cart')
            ->with('success', 'Game added to cart successfully!');
    }
}
