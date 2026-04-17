<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Showtime;
use App\Models\Movie;
use App\Models\Room;
use Carbon\Carbon;

class ShowtimeSeeder extends Seeder
{
    public function run(): void
    {
        $movies = Movie::all(); // cần duration
        $rooms  = Room::all();

        $timeSlots = [10, 13, 16, 19, 22];

        foreach ($rooms as $room) {

            // 👉 seed cho 7 ngày (cả tuần)
            for ($day = 0; $day < 7; $day++) {

                $slots = collect($timeSlots)->random(rand(3, 4));

                foreach ($slots as $hour) {

                    // 🎟️ Giá vé theo giờ
                    if ($hour < 12) {
                        $price = 70000;
                    } elseif ($hour < 17) {
                        $price = 85000;
                    } elseif ($hour < 20) {
                        $price = 100000;
                    } else {
                        $price = 120000;
                    }

                    $movie = $movies->random();

                    $startTime = Carbon::today()
                        ->addDays($day)
                        ->setHour($hour)
                        ->setMinute(0);

                    $endTime = $startTime->copy()
                        ->addMinutes($movie->duration);

                    Showtime::create([
                        'movie_id'   => $movie->id,
                        'room_id'    => $room->id,
                        'start_time' => $startTime,
                        'end_time'   => $endTime,
                        'price'      => $price,
                    ]);
                }
            }
        }
    }
}
