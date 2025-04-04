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
            'https://www.youtube.com/embed/NnyCWsA6KSI?si=kuUDHybquJqFJn4U',
            'https://www.youtube.com/embed/QdBZY2fkU-0?si=MU4QooBUEHgsz6QJ',
            'https://www.youtube.com/embed/_q51LZ2HpbE?si=lCH8AYkET-aOvYX_',
            'https://www.youtube.com/embed/FYH9n37B7Yw?si=o1eHRuRLQikL1WgP',
            'https://www.youtube.com/embed/WTBbwgsyxvg?si=R6zKCFGpG98kK0TV',
            'https://www.youtube.com/embed/xzCEdSKMkdU?si=HEFBOmCgjN2Q4QNQ',


        ];

        return [
            'video_url' => $this->faker->randomElement($videos),
        ];
    }
}
