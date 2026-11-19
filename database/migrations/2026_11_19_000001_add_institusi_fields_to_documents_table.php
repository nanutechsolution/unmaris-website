<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Menambahkan penanda institusi penerbit pada dokumen.
 *
 * Seluruh kolom bersifat nullable agar dokumen lama tidak berubah perilaku:
 * nilai NULL dianggap sebagai dokumen universitas yang bukan arsip.
 * Migration ini hanya menambah kolom dan tidak mengubah kolom yang sudah ada.
 */
return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasColumn('documents', 'institusi')) {
            Schema::table('documents', function (Blueprint $table): void {
                $table->string('institusi', 32)
                    ->nullable()
                    ->after('category')
                    ->comment('universitas atau sekolah_tinggi');
            });
        }

        if (! Schema::hasColumn('documents', 'nama_institusi_lama')) {
            Schema::table('documents', function (Blueprint $table): void {
                $table->string('nama_institusi_lama')
                    ->nullable()
                    ->after('institusi');
            });
        }

        if (! Schema::hasColumn('documents', 'is_arsip')) {
            Schema::table('documents', function (Blueprint $table): void {
                $table->boolean('is_arsip')
                    ->nullable()
                    ->after('is_active');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('documents', 'is_arsip')) {
            Schema::table('documents', function (Blueprint $table): void {
                $table->dropColumn('is_arsip');
            });
        }

        if (Schema::hasColumn('documents', 'nama_institusi_lama')) {
            Schema::table('documents', function (Blueprint $table): void {
                $table->dropColumn('nama_institusi_lama');
            });
        }

        if (Schema::hasColumn('documents', 'institusi')) {
            Schema::table('documents', function (Blueprint $table): void {
                $table->dropColumn('institusi');
            });
        }
    }
};
