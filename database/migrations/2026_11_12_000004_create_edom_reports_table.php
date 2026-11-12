<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('edom_reports', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('study_program_id')->constrained('study_programs')->cascadeOnDelete();
            $table->string('title');
            $table->string('academic_year')->nullable();
            $table->string('semester')->nullable();
            $table->text('description')->nullable();
            $table->string('file_path');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // Pindahkan dokumen EDOM tunggal yang sudah ada ke tabel riwayat agar
        // tidak hilang saat kolom lama dihapus.
        if (Schema::hasColumn('study_programs', 'edom_path')) {
            $now = now();

            DB::table('study_programs')
                ->whereNotNull('edom_path')
                ->get()
                ->each(function ($prodi) use ($now) {
                    DB::table('edom_reports')->insert([
                        'id' => (string) Str::uuid(),
                        'study_program_id' => $prodi->id,
                        'title' => $prodi->edom_title ?: 'Laporan Evaluasi Dosen oleh Mahasiswa (EDOM)',
                        'description' => $prodi->edom_description,
                        'file_path' => $prodi->edom_path,
                        'is_active' => true,
                        'created_at' => $now,
                        'updated_at' => $now,
                    ]);
                });

            Schema::table('study_programs', function (Blueprint $table) {
                $table->dropColumn(['edom_path', 'edom_title', 'edom_description']);
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('study_programs', function (Blueprint $table) {
            $table->string('edom_path')->nullable()->after('career_prospects');
            $table->string('edom_title')->nullable()->after('edom_path');
            $table->text('edom_description')->nullable()->after('edom_title');
        });

        if (Schema::hasTable('edom_reports')) {
            DB::table('edom_reports')
                ->orderByDesc('created_at')
                ->get()
                ->unique('study_program_id')
                ->each(function ($report) {
                    DB::table('study_programs')->where('id', $report->study_program_id)->update([
                        'edom_path' => $report->file_path,
                        'edom_title' => $report->title,
                        'edom_description' => $report->description,
                    ]);
                });

            Schema::dropIfExists('edom_reports');
        }
    }
};
