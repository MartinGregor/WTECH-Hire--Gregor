<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Game_Cart extends Model
{
    use HasFactory;

    protected $fillable = [
        'quantity',
    ];

    public function cart()
    {
        return $this->belongsTo(Cart::class);
    }

    public function game()
    {
        return $this->belongsTo(Game::class);
    }
}
