<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('announcements', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('title');
            $table->string('slug')->unique();
            $table->enum('type', ['pengumuman', 'agenda'])->default('pengumuman');
            $table->longText('content');
            $table->string('location')->nullable(); // Khusus untuk tipe 'agenda'
            $table->dateTime('start_date'); // Tanggal mulai / Tanggal pengumuman
            $table->dateTime('end_date')->nullable(); // Tanggal selesai (opsional)
            $table->string('attachment')->nullable(); // File unduhan (PDF, dll)
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('announcements');
    }
};
