<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Image;

class ImageFactory extends Factory
{
    protected $model = Image::class;

    public function definition(): array
    {
        $images = [
            'images/game_screens/CBP1.png',
            'images/game_screens/FH5.png',
            'images/game_screens/BF1.png',
            'images/game_screens/BF2.png',
            'images/game_screens/F1_1.png',
            'images/game_screens/F1_2.png',
        ];

        return [
            'image_url' => $this->faker->randomElement($images),
        ];
    }
}
