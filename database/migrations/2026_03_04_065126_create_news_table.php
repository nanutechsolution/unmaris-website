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
    Schema::create('news', function (Blueprint $table) {
        $table->uuid('id')->primary();
        $table->foreignUuid('category_id')->constrained()->cascadeOnDelete();
        $table->string('title');
        $table->string('slug')->unique();
        $table->text('excerpt');
        $table->longText('content');
        $table->string('featured_image')->nullable();
        $table->boolean('is_published')->default(true);
        $table->timestamp('published_at')->nullable();
        $table->timestamps();
        
        $table->index('published_at'); // Optimasi query pengurutan berita
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('news');
    }
};
