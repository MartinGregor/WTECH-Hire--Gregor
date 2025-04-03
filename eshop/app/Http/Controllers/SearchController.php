<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Game;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $query = Game::query();

        // Filter by platform
        if ($request->has('platform') && $request->platform !== 'ALL') {
            $query->where('platform', $request->platform);
        }

        // Filter by category (genre)
        if ($request->has('category') && $request->category !== 'ALL') {
            $query->whereHas('genres', function ($q) use ($request) {
                $q->where('name', $request->category);
            });
        }

        // Filter by price range
        if ($request->filled('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }
        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }

        // Filter by game title
        if ($request->filled('title')) {
            $query->where(function ($q) use ($request) {
                $q->whereRaw('LOWER(title) LIKE ?', ['%' . strtolower($request->title) . '%'])
                    ->orWhereRaw('LOWER(description) LIKE ?', ['%' . strtolower($request->title) . '%'])
                    ->orWhereHas('genres', function ($q) use ($request) {
                        $q->whereRaw('LOWER(name) LIKE ?', ['%' . strtolower($request->title) . '%']);
                    })
                    ->orWhereRaw('LOWER(platform) LIKE ?', ['%' . strtolower($request->title) . '%']);
            });
        }

        // Sorting
        if ($request->has('sort')) {
            switch ($request->sort) {
                case 'Price⇧': $query->orderBy('price', 'asc'); break;
                case 'Price⇩': $query->orderBy('price', 'desc'); break;
                case 'Date⇧': $query->orderBy('release_date', 'asc'); break;
                case 'Date⇩': $query->orderBy('release_date', 'desc'); break;
            }
        }

        // Pagination (12 games per page)
        $games = $query->paginate(12)->appends($request->query());

        return view('search', [
            'games' => $games,
            'request' => $request // Pass request back to view for keeping search filters
        ]);
    }
}
