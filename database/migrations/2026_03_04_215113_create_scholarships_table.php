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
        Schema::create('scholarships', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('provider'); // Penyelenggara: Kampus, Pemerintah, Swasta
            $table->text('description'); // Penjelasan beasiswa
            $table->text('requirements')->nullable(); // Persyaratan (Rich Text)
            $table->text('benefits')->nullable(); // Manfaat/Fasilitas yang didapat (Rich Text)
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->string('registration_url')->nullable(); // Link eksternal pendaftaran
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('scholarships');
    }
};
