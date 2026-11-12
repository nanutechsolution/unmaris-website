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
        Schema::table('study_programs', function (Blueprint $table) {
            $table->string('edom_path')->nullable()->after('career_prospects');
            $table->string('edom_title')->nullable()->after('edom_path');
            $table->text('edom_description')->nullable()->after('edom_title');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('study_programs', function (Blueprint $table) {
            $table->dropColumn(['edom_path', 'edom_title', 'edom_description']);
        });
    }
};
