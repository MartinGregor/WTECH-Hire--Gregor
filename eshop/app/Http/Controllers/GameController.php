<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\Image;
use App\Models\Video;
use Illuminate\Http\Request;

class GameController extends Controller
{
    // Show the product page for a specific game
    public function show($id)
    {
        // Fetch the game with its related images and videos
        $game = Game::with(['images', 'videos', 'genres'])->findOrFail($id);

        // Return the product view with the game data
        return view('product', compact('game'));
    }
}
