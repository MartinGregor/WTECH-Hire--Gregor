<?php

namespace App\Http\Controllers;

use App\Models\Game; // Assuming Game is the model for your game data
use Illuminate\Http\Request;

class GameInfoController extends Controller
{

    // Save the updated game information
    public function update(Request $request, $id)
    {
        // Validate the basic game fields
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'publisher' => 'required|string|max:255',
            'price' => 'required|numeric',
            'description' => 'required|string',
            'platform' => 'required|in:PC,Play Station,Xbox,Nintendo,Wii',
            'genres' => 'array|max:3',              // genres array
            'genres.*' => 'nullable|exists:genres,id', // each must exist or be null
        ]);

        // Find the game
        $game = Game::findOrFail($id);

        // Update the fields
        $game->title = $validatedData['name'];
        $game->publisher = $validatedData['publisher'];
        $game->price = $validatedData['price'];
        $game->description = $validatedData['description'];
        $game->platform = $validatedData['platform'];
        $game->save();

        // Handle genre syncing
        if (isset($validatedData['genres'])) {
            $uniqueGenreIds = collect($validatedData['genres'])
                ->filter()   // remove nulls/empty
                ->unique()   // remove duplicates
                ->values();  // reindex
            $game->genres()->sync($uniqueGenreIds);
        }

        return redirect()->route('admin')->with('success', 'Game updated successfully!');
    }

    // Handle deleting the game
    public function destroy($id)
    {
        $game = Game::findOrFail($id);
        $game->delete();

        return redirect()->route('admin')->with('success', 'Game deleted successfully!');
    }

    public function storeDefaultGame()
    {
        // Create the game with default values
        $game = Game::create([
            'title' => 'Default Name',
            'publisher' => 'Default Publisher',
            'release_date' => now(),
            'price' => 0.0,
            'description' => 'Default Description',
            'platform' => 'PC',
            'logo' => 'images/game_logos/DEFAULT.png'
        ]);

        // Redirect to the edit page of the newly created game
        return redirect()->route('game.edit', ['id' => $game->id])->with('success', 'Default Game created. Now you can edit it.');
    }
}
