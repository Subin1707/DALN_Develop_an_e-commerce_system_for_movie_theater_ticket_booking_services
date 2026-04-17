<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('theaters', function (Blueprint $table) {
            $table->integer('total_rooms')->default(0)->after('phone');
        });
    }

    public function down(): void {
        Schema::table('theaters', function (Blueprint $table) {
            $table->dropColumn('total_rooms');
        });
    }
};
