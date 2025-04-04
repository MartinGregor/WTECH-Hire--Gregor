<?php

namespace App\Http\Controllers;

use App\Models\Game;
use Illuminate\Http\Request;

class AdminEditController extends Controller
{
    // Show the product page for a specific game
    public function show($id)
    {
        // Fetch the game with its related images and videos
        $game = Game::with(['images', 'videos'])->findOrFail($id);

        // Return the product view with the game data
        return view('adminproduct', compact('game'));
    }
}

