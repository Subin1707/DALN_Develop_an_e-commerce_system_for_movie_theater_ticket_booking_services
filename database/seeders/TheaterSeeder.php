<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Theater;

class TheaterSeeder extends Seeder
{
    public function run(): void
    {
        $theaters = [

            // ===== HỒ CHÍ MINH =====
            ['name' => 'Q&HCINEMA Nguyễn Du', 'address' => '116 Nguyễn Du, Quận 1, HCM', 'total_rooms' => 6],
            ['name' => 'Q&HCINEMA Đồng Khởi', 'address' => '72 Lê Thánh Tôn, Quận 1, HCM', 'total_rooms' => 7],
            ['name' => 'Q&HCINEMA Nowzone', 'address' => '235 Nguyễn Văn Cừ, Quận 1, HCM', 'total_rooms' => 5],
            ['name' => 'Q&HCINEMA Bitexco', 'address' => '2 Hải Triều, Quận 1, HCM', 'total_rooms' => 4],
            ['name' => 'Q&HCINEMA Hai Bà Trưng', 'address' => '135 Hai Bà Trưng, Quận 3, HCM', 'total_rooms' => 4],

            // ===== HÀ NỘI =====
            ['name' => 'Q&HCINEMA Royal City', 'address' => '72A Nguyễn Trãi, Thanh Xuân, Hà Nội', 'total_rooms' => 8],
            ['name' => 'Q&HCINEMA Keangnam', 'address' => 'Phạm Hùng, Nam Từ Liêm, Hà Nội', 'total_rooms' => 6],
            ['name' => 'Q&HCINEMA Phạm Ngọc Thạch', 'address' => '01 Phạm Ngọc Thạch, Đống Đa, Hà Nội', 'total_rooms' => 5],
            ['name' => 'Q&HCINEMA Mipec Tây Sơn', 'address' => '229 Tây Sơn, Đống Đa, Hà Nội', 'total_rooms' => 4],

            // ===== ĐÀ NẴNG =====
            ['name' => 'Q&HCINEMA Vĩnh Trung', 'address' => '255–257 Hùng Vương, Đà Nẵng', 'total_rooms' => 6],
            ['name' => 'Q&HCINEMA Hải Châu', 'address' => '6 Nại Nam, Hải Châu, Đà Nẵng', 'total_rooms' => 5],

            // ===== CẦN THƠ =====
            ['name' => 'Q&HCINEMA Ninh Kiều', 'address' => '1 Hòa Bình, Ninh Kiều, Cần Thơ', 'total_rooms' => 4],

            // ===== HẢI PHÒNG =====
            ['name' => 'Q&HCINEMA Lê Chân', 'address' => 'Aeon Mall Lê Chân, Hải Phòng', 'total_rooms' => 5],

            // ===== BÌNH DƯƠNG =====
            ['name' => 'Q&HCINEMA Bình Dương', 'address' => 'Aeon Mall Bình Dương', 'total_rooms' => 6],

        ];

        foreach ($theaters as $data) {
            Theater::create($data);
        }
    }
}
