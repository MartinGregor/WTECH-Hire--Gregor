<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Game;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $query = Game::query();

        // Platform filter
        if ($request->filled('platform') && $request->platform !== 'ALL') {
            $query->where('platform', $request->platform);
        }

        // Style filter (Singleplayer, Multiplayer, etc.)
        if ($request->filled('style') && $request->style !== 'ALL') {
            $query->where('style', $request->style);
        }

        // PEGI filter
        if ($request->filled('pg') && $request->pg !== 'ALL') {
            $query->where('pg', $request->pg);
        }

        // Genre filter (with genre relationship)
        if ($request->filled('category') && $request->category !== 'ALL') {
            $query->whereHas('genres', function ($q) use ($request) {
                $q->where('name', $request->category);
            });
        }

        // Price range filter
        if ($request->filled('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }
        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }

        // Title, description, genre or platform fuzzy search
        if ($request->filled('title')) {
            $title = strtolower($request->title);
            $query->where(function ($q) use ($title) {
                $q->whereRaw('LOWER(title) LIKE ?', ['%' . $title . '%'])
                    ->orWhereRaw('LOWER(description) LIKE ?', ['%' . $title . '%'])
                    ->orWhereHas('genres', function ($q) use ($title) {
                        $q->whereRaw('LOWER(name) LIKE ?', ['%' . $title . '%']);
                    })
                    ->orWhereRaw('LOWER(platform) LIKE ?', ['%' . $title . '%']);
            });
        }

        // Sorting
        if ($request->has('sort')) {
            switch ($request->sort) {
                case 'Price⇧':
                    $query->orderBy('price', 'asc');
                    break;
                case 'Price⇩':
                    $query->orderBy('price', 'desc');
                    break;
                case 'Date⇧':
                    $query->orderBy('release_date', 'asc');
                    break;
                case 'Date⇩':
                    $query->orderBy('release_date', 'desc');
                    break;
            }
        }

        // Pagination - 12 items per page
        $games = $query->paginate(12)->appends($request->query());

        return view('search', compact('games'));
    }
}
