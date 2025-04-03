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
            'images/game_screens/CP1.jpg',
            'images/game_screens/CP2.jpg',
            'images/game_screens/CP3.jpg',
            'images/game_screens/BF1.png',
            'images/game_screens/BF2.png',
            'images/game_screens/F1.png',
            'images/game_screens/FH5.png',
            'images/game_screens/RDR.png',
        ];

        return [
            'image_url' => $this->faker->randomElement($images),
        ];
    }
}
