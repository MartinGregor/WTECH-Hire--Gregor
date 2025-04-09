<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'publisher',
        'release_date',
        'price',
        'description',
        'platform',
        'logo',
        'pg',
        'style',
    ];

    public function genres()
    {
        return $this->belongsToMany(Genre::class, 'game_genres');
    }

    public function purchases()
    {
        return $this->belongsToMany(Purchase::class, 'game_purchases');
    }

    public function images()
    {
        return $this->hasMany(Image::class);
    }

    public function videos()
    {
        return $this->hasMany(Video::class);
    }

    public function carts()
    {
        return $this->belongsToMany(Cart::class, 'game_cart')->withPivot('quantity');
    }
}
