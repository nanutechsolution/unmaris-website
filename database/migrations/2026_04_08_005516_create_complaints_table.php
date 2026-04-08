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
       Schema::create('complaints', function (Blueprint $table) {
            $table->char('id', 36)->primary(); // Mengikuti standar char(36) di schema Anda
            $table->string('ticket_number')->unique();
            
            // Data Pelapor
            $table->string('name');
            $table->string('email');
            $table->string('phone')->nullable();
            
            // Detail Pengaduan
            $table->enum('category', ['akademik', 'fasilitas', 'layanan', 'keuangan', 'lainnya']);
            $table->string('subject');
            $table->text('content');
            $table->string('attachment')->nullable(); 
            
            // Status & Respon
            $table->enum('status', ['pending', 'process', 'resolved', 'rejected'])->default('pending');
            $table->text('admin_response')->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('complaints');
    }
};
