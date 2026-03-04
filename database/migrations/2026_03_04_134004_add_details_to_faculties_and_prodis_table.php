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
        // Menambah kolom di tabel Faculties
        Schema::table('faculties', function (Blueprint $table) {
            $table->longText('vision')->nullable()->after('description');
            $table->longText('mission')->nullable()->after('vision');
            $table->string('email')->nullable()->after('image');
            $table->string('phone')->nullable()->after('email');
        });

        // Menambah kolom di tabel Study Programs (Prodi)
        Schema::table('study_programs', function (Blueprint $table) {
            $table->longText('vision')->nullable()->after('description');
            $table->longText('mission')->nullable()->after('vision');
            $table->longText('career_prospects')->nullable()->after('mission');
        });
    }

    public function down(): void
    {
        Schema::table('faculties', function (Blueprint $table) {
            $table->dropColumn(['vision', 'mission', 'email', 'phone']);
        });

        Schema::table('study_programs', function (Blueprint $table) {
            $table->dropColumn(['vision', 'mission', 'career_prospects']);
        });
    }
};
