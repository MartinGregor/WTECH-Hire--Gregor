<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

use App\Models\Game;
use App\Models\User;

Game::factory()->count(30)->create();


class DatabaseSeeder extends Seeder
{
    public function run()
    {
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
    }
}

