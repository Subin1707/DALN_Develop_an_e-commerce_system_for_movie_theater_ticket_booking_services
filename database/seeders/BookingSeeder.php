<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Booking;
use App\Models\User;
use App\Models\Showtime;

class BookingSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::where('role', 'user')->get();
        $showtimes = Showtime::all();

        if ($users->isEmpty() || $showtimes->isEmpty()) {
            $this->command->warn('⚠️ Không có user hoặc showtime.');
            return;
        }

        foreach ($users as $user) {

            $sampleShowtimes = $showtimes->random(rand(1, 2));

            foreach ($sampleShowtimes as $showtime) {

                // Danh sách ghế
                $rows = range('A', 'F');
                $seatPool = [];

                foreach ($rows as $row) {
                    for ($i = 1; $i <= 10; $i++) {
                        $seatPool[] = $row . $i;
                    }
                }

                shuffle($seatPool);

                // Thực tế: thường 1–4 ghế
                $seatCount = rand(1, 4);
                $seats = array_slice($seatPool, 0, $seatCount);

                Booking::create([
                    'user_id'        => $user->id,
                    'showtime_id'    => $showtime->id,
                    'seats'          => implode(',', $seats),
                    'total_price'    => $showtime->price * $seatCount,

                    // Chuyển khoản phổ biến hơn
                    'payment_method' => collect(['transfer', 'transfer', 'cash'])->random(),

                    // Vé đã xác nhận nhiều hơn
                    'status'         => collect(['confirmed', 'confirmed', 'pending'])->random(),

                    'created_at'     => now()->subDays(rand(1, 45)),
                    'updated_at'     => now(),
                ]);
            }
        }

        $this->command->info('✅ BookingSeeder (thực tế rạp) chạy thành công!');
    }
}
