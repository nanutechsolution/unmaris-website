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
        Schema::create('leaders', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name');
            $table->string('position'); // Jabatan (Rektor, Warek 1, dll)
            $table->string('image')->nullable(); // Foto Pimpinan
            $table->integer('order')->default(0); // Urutan tampil
            $table->boolean('is_active')->default(true); // Status aktif
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leaders');
    }
};
