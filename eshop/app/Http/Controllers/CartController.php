<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function insertToCart(Request $request)
    {
        // Get the authenticated user
        $user = Auth::user();

        // Get the user's cart, or create a new one if it doesn't exist
        $cart = $user->cart()->firstOrCreate([
            'user_id' => $user->id,
            'added_date' => now(),
        ]);

        // Get the game ID and quantity from the request
        $gameId = $request->input('game_id');
        $quantity = $request->input('quantity');

        // Find the game
        $game = Game::findOrFail($gameId);

        // Check if the game is already in the cart
        $existingGame = $cart->games()->where('game_id', $gameId)->first();

        if ($existingGame) {
            // If the game already exists in the cart, update the quantity
            $newQuantity = $existingGame->pivot->quantity + $quantity;
            $cart->games()->updateExistingPivot($gameId, [
                'quantity' => $newQuantity
            ]);
        } else {
            // If the game is not in the cart, add it with the given quantity
            $cart->games()->attach($gameId, ['quantity' => $quantity]);
        }

        // Redirect or return a response (you can modify this to your needs)
        return redirect()->route('game.show', ['id' => $game->id])
            ->with('success', 'Game added to cart successfully!');
    }
}
