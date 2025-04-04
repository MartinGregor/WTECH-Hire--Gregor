<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    use HasFactory;

    protected $fillable = [
        'video_url',
        'game_id',
    ];

    public function game()
    {
        return $this->belongsTo(Game::class); // assuming your Video model relates to Game model
    }
}
