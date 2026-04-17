<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('rooms', function (Blueprint $table) {
            $table->integer('seat_rows')->default(8)->after('capacity');
            $table->integer('seat_cols')->default(12)->after('seat_rows');
        });
    }

    public function down(): void
    {
        Schema::table('rooms', function (Blueprint $table) {
            $table->dropColumn(['seat_rows', 'seat_cols']);
        });
    }
};
