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
        Schema::create('popup_promos', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('title'); // Judul Utama (Contoh: PMB 2026)
            $table->string('subtitle')->nullable(); // Label atas (Contoh: Gelombang 1)
            $table->string('image')->nullable(); // Gambar banner
            $table->text('description')->nullable(); // Teks penjelasan
            $table->string('button_text')->nullable(); // Teks tombol (Contoh: Daftar Sekarang)
            $table->string('button_url')->nullable(); // Link tombol
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('popup_promos');
    }
};
