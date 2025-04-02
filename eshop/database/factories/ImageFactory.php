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
        ];

        return [
            'image_url' => $this->faker->randomElement($images),
        ];
    }
}
