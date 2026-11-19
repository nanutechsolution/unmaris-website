<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Kolom yang ditambahkan oleh migration ini.
     *
     * @var list<string>
     */
    private array $columns = [
        'lembaga_akreditasi',
        'study_program_id',
        'nomor_sk',
        'peringkat',
        'berlaku_mulai',
        'berlaku_sampai',
    ];

    /**
     * Menambahkan kolom khusus dokumen akreditasi.
     *
     * Semua kolom bersifat nullable dan hanya ditambahkan apabila belum ada,
     * sehingga migration aman dijalankan ulang dan tidak mengubah data lama.
     */
    public function up(): void
    {
        if (! Schema::hasColumn('documents', 'lembaga_akreditasi')) {
            Schema::table('documents', function (Blueprint $table): void {
                $table->string('lembaga_akreditasi')->nullable();
            });
        }

        if (! Schema::hasColumn('documents', 'study_program_id')) {
            Schema::table('documents', function (Blueprint $table): void {
                $table->foreignUuid('study_program_id')
                    ->nullable()
                    ->constrained('study_programs')
                    ->nullOnDelete();
            });
        }

        if (! Schema::hasColumn('documents', 'nomor_sk')) {
            Schema::table('documents', function (Blueprint $table): void {
                $table->string('nomor_sk')->nullable();
            });
        }

        if (! Schema::hasColumn('documents', 'peringkat')) {
            Schema::table('documents', function (Blueprint $table): void {
                $table->string('peringkat')->nullable();
            });
        }

        if (! Schema::hasColumn('documents', 'berlaku_mulai')) {
            Schema::table('documents', function (Blueprint $table): void {
                $table->date('berlaku_mulai')->nullable();
            });
        }

        if (! Schema::hasColumn('documents', 'berlaku_sampai')) {
            Schema::table('documents', function (Blueprint $table): void {
                $table->date('berlaku_sampai')->nullable();
            });
        }
    }

    /**
     * Menghapus hanya kolom yang ditambahkan oleh migration ini.
     */
    public function down(): void
    {
        if (Schema::hasColumn('documents', 'study_program_id')) {
            $foreignKey = collect(Schema::getForeignKeys('documents'))
                ->first(fn (array $foreignKey): bool => in_array(
                    'study_program_id',
                    $foreignKey['columns'] ?? [],
                    true,
                ));

            if ($foreignKey) {
                Schema::table('documents', function (Blueprint $table) use ($foreignKey): void {
                    $table->dropForeign($foreignKey['name']);
                });
            }

            Schema::table('documents', function (Blueprint $table): void {
                $table->dropColumn('study_program_id');
            });
        }

        foreach ($this->columns as $column) {
            if ($column === 'study_program_id') {
                continue;
            }

            if (Schema::hasColumn('documents', $column)) {
                Schema::table('documents', function (Blueprint $table) use ($column): void {
                    $table->dropColumn($column);
                });
            }
        }
    }
};
