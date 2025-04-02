<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

use App\Models\Game;
use App\Models\User;
use App\Models\Image;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Vytvorenie admin a customer používateľov
        DB::table('users')->insert([
            'role' => 'admin',
            'username' => 'admin_user',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('password123'),
        ]);

        DB::table('users')->insert([
            'role' => 'customer',
            'username' => 'customer_user',
            'email' => 'customer@gmail.com',
            'password' => Hash::make('password123'),
        ]);

        // Vygeneruj hry
        $games = Game::factory()->count(30)->create();  // 30 hier

        // Pre každú hru vytvor 3 obrázky
        foreach ($games as $game) {
            // Vytvorenie obrázkov a priradenie ku hre
            Image::factory(3)->create([
                'game_id' => $game->id,  // priradenie game_id ku každému obrázku
            ]);
        }
    }
}
