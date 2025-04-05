<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\User;
use App\Models\Cart;
use App\Models\Game_Cart;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function insertToCart(Request $request) {
        $request->validate([
            'game_id' => 'required|exists:games,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $game = Game::findOrFail($request->game_id);

        $game_cart = session()->get('game_cart', []);
        $cart = Cart::where('user_id', $request->user_id);

        if (isset($game_cart[$game->id])) {
            // If the item is already in the cart, update the quantity
            $game_cart[$game->id]['quantity'] += $request->quantity;
        } else {
            // Otherwise, add it to the cart
            $game_cart = Game_Cart::create([
                'game_id' => $game->id,
                'cart_id' => 1,
                'quantity' => $request->quantity,
            ]);
        }

        session()->put('cart', $cart);

        return redirect()->back()->with('success', 'Game added to cart!');
    }
}
