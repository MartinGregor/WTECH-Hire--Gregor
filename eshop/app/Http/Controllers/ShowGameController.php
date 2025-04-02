<?php

namespace App\Http\Controllers;

use App\Models\Game;

class ShowGameController extends Controller
{
    public function index()
    {

        $games1 = Game::orderBy('release_date', 'asc')->take(12)->get();
        $games2 = Game::orderBy('release_date', 'asc')->skip(12)->take(6)->get();
        $games3 = Game::orderBy('release_date', 'asc')->skip(18)->take(12)->get();

        return view('home',['games1' => $games1, 'games2' => $games2, 'games3' => $games3]);
    }
}
