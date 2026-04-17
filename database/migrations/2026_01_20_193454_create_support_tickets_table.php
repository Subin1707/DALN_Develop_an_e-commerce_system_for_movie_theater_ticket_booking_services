<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('support_tickets', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('booking_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete();

            $table->string('subject');
            $table->enum('category', [
                'booking',
                'payment',
                'movie',
                'theater',
                'other'
            ]);

            $table->text('message');

            $table->enum('status', [
                'open',
                'processing',
                'answered',
                'closed'
            ])->default('open');

            // staff/admin xử lý
            $table->foreignId('assigned_to')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('support_tickets');
    }
};
