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
        Schema::create('testimonials', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name');
            $table->string('job_title'); // Jabatan (Misal: Digital Marketer)
            $table->string('company')->nullable(); // Perusahaan (Misal: Bank NTT)
            $table->text('message'); // Pesan / Kesan selama kuliah
            $table->string('image')->nullable(); // Foto Alumni
            $table->integer('order')->default(0); // Urutan Tampil
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('testimonials');
    }
};
