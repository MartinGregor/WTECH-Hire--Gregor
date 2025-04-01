<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class User extends Model
{
    use HasFactory;

    protected $fillable = [
        'role',
        'username',
        'email',
        'password_hash',
    ];

    /**
     * Get the purchases for the user.
     */
    public function purchases()
    {
        return $this->hasMany(Purchase::class);
    }

    /**
     * Get the games that belong to the user (through the cart).
     */
    public function cartGames()
    {
        return $this->belongsToMany(Game::class, 'cart');
    }

    /**
     * Get the games that belong to the user (through the game_purchases).
     */
    public function purchasedGames()
    {
        return $this->belongsToMany(Game::class, 'game_purchases');
    }
}
