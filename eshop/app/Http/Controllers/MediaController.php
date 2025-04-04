<?php

namespace App\Http\Controllers;
use App\Models\Game;
use Illuminate\Support\Facades\Storage;
use App\Models\Image;
use App\Models\Video;
use Illuminate\Http\Request;

class MediaController extends Controller
{
    public function deleteImage($id)
    {
        $image = Image::findOrFail($id);

        $imagePath = $image->image_url;
        $fullPath = public_path($imagePath);

        $isInCorrectFolder = str_starts_with($imagePath, 'images/new_game_screens');
        $isUsedElsewhere = Image::where('image_url', $imagePath)->where('id', '!=', $id)->exists();

        // Only delete the physical file if it's in the right folder and not used by any other game
        if ($isInCorrectFolder && !$isUsedElsewhere && file_exists($fullPath)) {
            unlink($fullPath);
        }

        // Always delete the DB record to unlink from the game
        $image->delete();

        return back()->with('success', 'Image unlinked from game successfully.');
    }


    public function deleteVideo($id)
    {
        $video = Video::findOrFail($id);
        $video->delete();

        return back()->with('success', 'Video deleted successfully.');
    }

    public function updateLogo(Request $request, $id)
    {
        $game = Game::findOrFail($id);

        // Validate new file
        $request->validate([
            'logo' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        // Store new logo
        $file = $request->file('logo');
        $filename = 'images/new_game_logos/' . uniqid() . '.' . $file->getClientOriginalExtension();
        $file->move(public_path('images/new_game_logos'), basename($filename));

        // Check if old logo is in the same directory before deleting
        if ($game->logo && str_starts_with($game->logo, 'images/new_game_logos/') && file_exists(public_path($game->logo))) {
            unlink(public_path($game->logo));
        }

        // Update model with new logo
        $game->logo = $filename;
        $game->save();

        return back()->with('success', 'Logo updated successfully.');
    }

    public function uploadImage(Request $request, $gameId)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $file = $request->file('image');
        $filename = 'images/new_game_screens/' . uniqid() . '.' . $file->getClientOriginalExtension();
        $file->move(public_path('images/new_game_screens'), basename($filename));

        // Save new image
        Image::create([
            'game_id' => $gameId,
            'image_url' => $filename,
        ]);

        return back()->with('success', 'Image uploaded successfully.');
    }



    public function uploadVideoLink(Request $request, $gameId)
    {
        $request->validate([
            'video_link' => ['required', 'regex:/^(https?\:\/\/)?(www\.youtube\.com|youtu\.?be)\/.+$/'],
        ]);

        Video::create([
            'game_id' => $gameId,
            'video_url' => $request->video_link,
        ]);

        return back()->with('success', 'YouTube video link added successfully.');
    }

}
