<?php

use App\Models\Movie;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('comments', function (Blueprint $table) {
            $table->id();
            $table->text('content');
            $table->foreignId('movies_id')->constrained('movies')->onDelete('cascade');
            $table->string('title')->nullable();
            $table->unsignedBigInteger('author_id')->nullable();
            $table->foreign('author_id')
                  ->references('id')
                  ->on('users')
                  ->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('comments');
    }
};
