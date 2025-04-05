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
        $user = Auth::user();

        $cart = $user->cart()->firstOrCreate([
            'user_id' => $user->id,
        ]);

        $gameId = $request->input('game_id');
        $quantity = $request->input('quantity');

        $game = Game::findOrFail($gameId);

        $existingGame = $cart->games()->where('game_id', $gameId)->first();

        if ($existingGame) {
            $newQuantity = $existingGame->pivot->quantity + $quantity;
            $cart->games()->updateExistingPivot($gameId, [
                'quantity' => $newQuantity,
            ]);
        } else {
            $cart->games()->attach($gameId, ['quantity' => $quantity]);
        }

        return redirect()->route('search', ['id' => $game->id])
            ->with('success', 'Game added to cart successfully!');
    }
}
