<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        
        // 👤 Tạo user mẫu
        $this->call(UserSeeder::class);

        // 🎬 Tạo phim mẫu
        $this->call(MovieSeeder::class);

        // 🏢 Tạo rạp
        $this->call(TheaterSeeder::class);

        // 🏢 Tạo phòng chiếu
        $this->call(RoomSeeder::class);

        // 🕒 Tạo suất chiếu
        $this->call(ShowtimeSeeder::class);

        // 🎟️ Tạo booking mẫu
        $this->call(BookingSeeder::class);
    }
}
