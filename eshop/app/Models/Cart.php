<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
    ];

    public function games()
    {
        return $this->belongsToMany(Genre::class, 'game_cart');
    }

    public function users()
    {
        return $this->belongsTo(Genre::class, 'users');
    }
}
