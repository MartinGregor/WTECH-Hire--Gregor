<?php

namespace App\Http\Controllers;

use App\Models\Game;

class ShowGameController extends Controller
{
    public function index()
    {

        $games1 = Game::orderBy('release_date', 'desc')->take(6)->get();
        $games2 = Game::orderBy('release_date', 'asc')->take(12)->get();

        return view('home',['games' => $games1, 'games2' => $games2]);
    }
}
