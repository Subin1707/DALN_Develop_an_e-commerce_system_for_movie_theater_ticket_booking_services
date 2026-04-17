<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Theater;
use App\Models\Room;

class RoomSeeder extends Seeder
{
    public function run(): void
    {
        $theaters = Theater::all();

        foreach ($theaters as $theater) {

            // cấu hình ghế mặc định
            $seatRows = 8;
            $seatCols = 12;

            for ($i = 1; $i <= $theater->total_rooms; $i++) {
                Room::create([
                    'theater_id' => $theater->id,
                    'name'       => 'Phòng ' . $i,
                    'seat_rows'  => $seatRows,
                    'seat_cols'  => $seatCols,
                    'capacity'   => $seatRows * $seatCols,
                ]);
            }
        }
    }
}
