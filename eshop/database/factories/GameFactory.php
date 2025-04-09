<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Game;

class GameFactory extends Factory
{
    protected $model = Game::class;

    public function definition(): array
    {
        $titles = [
            'Cyberpunk 2077',
            'Assassins Creed Valhalla',
            'The Witcher 3: Wild Hunt',
            'Red Dead Redemption 2',
            'Elden Ring',
            'God of War',
            'Halo Infinite',
            'Final Fantasy VII Remake'
        ];

        $logos = [
            'images/game_logos/CBP.png',
            'images/game_logos/F1.jpg',
            'images/game_logos/FHZ.jpg',
            'images/game_logos/FMS.jpg',
            'images/game_logos/GTA.jpg',
            'images/game_logos/NHL.jpg',
            'images/game_logos/ZLD.jpg',
            'images/game_logos/FC.jpg',
            'images/game_logos/MAD.jpg',
            'images/game_logos/NBA.jpg',
            'images/game_logos/NFS.jpg',
            'images/game_logos/PUBG.jpg',
            'images/game_logos/RDR.jpg',
            'images/game_logos/WUK.jpg',
            'images/game_logos/STB2.jpg',
            'images/game_logos/STB.jpg',
        ];

        return [
            'title' => $this->faker->randomElement($titles),
            'publisher' => $this->faker->company,
            'release_date' => $this->faker->date,
            'price' => $this->faker->randomFloat(2, 10, 100),
            'description' => $this->faker->paragraph,
            'platform' => $this->faker->randomElement(['PC', 'Play Station', 'Xbox', 'Nintendo', 'Wii']),
            'style' => $this->faker->randomElement(['Singleplayer', 'Multiplayer', 'Coop', 'PvP', 'PvE']),
            'pg' => $this->faker->randomElement(['PG-3', 'PG-7', 'PG-12', 'PG-16', 'PG-18']),
            'logo' => $this->faker->randomElement($logos),
        ];
    }
}

