<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('news', function (Blueprint $table) {
            // Menambah kolom shares setelah kolom views
            // views
            $table->unsignedInteger('views')->default(0)->after('published_at');
            $table->unsignedInteger('shares')->default(0)->after('views');
        });
    }

    public function down(): void
    {
        Schema::table('news', function (Blueprint $table) {
            $table->dropColumn('views');
            $table->dropColumn('shares');
        });
    }
};
