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
        $total = $this->getCartTotal();
        return view('cart', compact('total'));
    }

    public function getCartTotal()
    {
        $total = 0;
        if (Auth::check()) {
            foreach (Auth::user()->cart->games as $item) {
                $total += $item->price * $item->pivot->quantity;
            }
        } else {
            $cart = session()->get('cart', []);
            foreach ($cart as $item) {
                $game = Game::find($item['game_id']);
                if ($game) {
                    $total += $game->price * $item['quantity'];
                }
            }
        }
        return $total;
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
                if ($newQuantity == 0) {
                    $this->destroy($request);
                }
                else {
                    $cart->games()->updateExistingPivot($gameId, [
                        'quantity' => $newQuantity
                    ]);
                }
            } else {
                $cart->games()->attach($gameId, ['quantity' => $quantity]);
            }
        } else {
            // Guest user logic (use session)
            $cart = session()->get('cart', []);

            if (isset($cart[$gameId])) {
                $cart[$gameId]['quantity'] += $quantity;
                if ($cart[$gameId]['quantity'] == 0) {
                    unset($cart[$gameId]);
                }
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

    public function destroy(Request $request)
    {
        $gameId = $request->input('game_id');
        $game = Game::findOrFail($gameId);

        if (Auth::check()) {
            $user = Auth::user();
            $cart = $user->cart()->firstOrCreate([
                'user_id' => $user->id,
            ]);

            $existingGame = $cart->games()->where('game_id', $gameId)->first();
            $cart->games()->detach($gameId);
        } else {
            $cart = session()->get('cart', []);

            if (isset($cart[$gameId])) {
                unset($cart[$gameId]);
            }

            session()->put('cart', $cart);
        }
        return redirect()->route('cart')->with('message', 'Game removed from cart!');
    }

    public function startPayment()
    {
        if ($this->getCartTotal() > 0) {
            $total = $this->getCartTotal();
            return view('details', compact('total'));
        } else {
            return redirect()->back()->with('error', 'Your cart is empty.');
        }
    }
}
