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
        Schema::create('research', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('title');
            $table->string('slug')->unique();
            $table->enum('type', ['jurnal', 'pengabdian', 'buku', 'hki'])->default('jurnal');
            $table->string('author'); // Nama penulis/peneliti utama
            $table->text('abstract')->nullable();
            $table->string('link_url')->nullable(); // Tautan ke jurnal eksternal (OJS, Google Scholar, dll)
            $table->string('file_path')->nullable(); // File PDF (jika di-hosting internal)
            $table->date('publication_date')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('research');
    }
};
