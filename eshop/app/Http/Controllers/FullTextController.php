<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Game;

class FullTextController extends Controller
{
    public function index(Request $request)
    {
        if ($request->filled('title')) {
            $title = strtolower($request->title);
            $games = Game::whereRaw('LOWER(title) LIKE ?', ['%' . $title . '%'])
                ->orWhereRaw('LOWER(description) LIKE ?', ['%' . $title . '%'])
                ->orWhereRaw('LOWER(publisher) LIKE ?', ['%' . $title . '%'])
                ->orWhereRaw('LOWER(platform) LIKE ?', ['%' . $title . '%'])
                ->orWhereRaw('LOWER(style) LIKE ?', ['%' . $title . '%'])
                ->orWhereRaw('LOWER(pg) LIKE ?', ['%' . $title . '%'])
                ->paginate(12);
        } else {
            $games = Game::whereRaw('1 = 0')->paginate(12);
        }

        return view('fulltextsearch', compact('games'));
    }
}
