<?php

namespace Database\Factories;

use App\Models\Video;
use Illuminate\Database\Eloquent\Factories\Factory;

class VideoFactory extends Factory
{
    protected $model = Video::class;

    public function definition(): array
    {
        // Define an array of example YouTube video URLs
        $videos = [
            'https://www.youtube.com/embed/8X2kIfS6fb8?si=6lsrGnsYLwTRUKEm',
            'https://www.youtube.com/embed/kJQP7kiw5Fk?si=5BXiV9GH2xEgs7zP',
            'https://www.youtube.com/embed/tgbNymZ7vqY?si=2bS9_rN3f1sN-Ezp',
        ];

        return [
            'video_url' => $this->faker->randomElement($videos),
        ];
    }
}
