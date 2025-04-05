<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\Game;
use App\Models\User;
use App\Models\Image;
use App\Models\Genre;
use App\Models\Video;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Seed users
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

        DB::table('carts')->insert([
            'user_id' => 2,
        ]);

        $genreNames = [
            'Action', 'Adventure', 'RPG', 'Horror', 'Strategy',
            'Simulation', 'Sports', 'Racing', 'Fighting', 'Puzzle'
        ];

        // Insert genres into database
        $genres = collect();
        foreach ($genreNames as $name) {
            $genres->push(Genre::create(['name' => $name]));
        }

        // Seed games
        $games = Game::factory()->count(100)->create();

        // Assign 3 random genres to each game
        foreach ($games as $game) {
            $randomGenres = $genres->random(3)->pluck('id');
            $game->genres()->attach($randomGenres);

            // Seed images
            Image::factory(3)->create(['game_id' => $game->id]);

            // Seed videos
            Video::factory(2)->create(['game_id' => $game->id]);
        }

        DB::table('game_cart')->insert([
            'game_id' => 1,
            'cart_id' => 1,
            'quantity' => 4,
        ]);

        DB::table('game_cart')->insert([
            'game_id' => 2,
            'cart_id' => 1,
            'quantity' => 1,
        ]);

        DB::table('game_cart')->insert([
            'game_id' => 3,
            'cart_id' => 1,
            'quantity' => 1,
        ]);
    }
}
