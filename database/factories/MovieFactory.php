<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class MovieFactory extends Factory
{
    public function definition(): array
    {
        $genres = ['Hành động', 'Kinh dị', 'Hài', 'Tình cảm', 'Khoa học viễn tưởng', 'Hoạt hình'];
        $statuses = ['active', 'inactive'];

        return [
            'title'       => $this->faker->sentence(3),
            'genre'       => $this->faker->randomElement($genres),
            'duration'    => $this->faker->numberBetween(90, 180),
            'description' => $this->faker->paragraph(4),
            'poster'      => 'img/' . rand(1, 5) . '.jpg', // 📸 giả lập 5 ảnh mẫu
            'status'      => $this->faker->randomElement($statuses),
        ];
    }
}
