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
        ];

        return [
            'title' => $this->faker->randomElement($titles),
            'publisher' => $this->faker->company,
            'release_date' => $this->faker->date,
            'price' => $this->faker->randomFloat(2, 10, 100),
            'description' => $this->faker->paragraph,
            'platform' => $this->faker->randomElement(['PC', 'Play Station', 'Xbox', 'Wii']),
            'logo' => $this->faker->randomElement($logos),
        ];
    }
}

