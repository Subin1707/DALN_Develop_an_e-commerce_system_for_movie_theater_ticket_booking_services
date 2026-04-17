<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // ================= ADMIN =================
        User::create([
            'name' => 'Admin Q&HCINEMA',
            'email' => 'admin@qhcinema.com',
            'password' => Hash::make('12345678'),
            'role' => 'admin',
        ]);

        // ================= STAFF (10 TK) =================
        for ($i = 1; $i <= 15; $i++) {
            User::create([
                'name' => "Staff Q&HCINEMA $i",
                'email' => "staff$i@qhcinema.com",
                'password' => Hash::make('12345678'),
                'role' => 'staff',
            ]);
        }

        // ================= USER / KHÁCH HÀNG (10 TK) =================
        for ($i = 1; $i <= 100; $i++) {
            User::create([
                'name' => "Khách Hàng $i",
                'email' => "user$i@gmail.com",
                'password' => Hash::make('12345678'),
                'role' => 'user',
            ]);
        }

        // ================= USER RANDOM (OPTIONAL) =================
        // Nếu không cần test tải, có thể xóa dòng này
        User::factory()->count(10)->create();
    }
}
