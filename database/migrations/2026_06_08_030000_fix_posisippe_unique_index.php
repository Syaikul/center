<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('posisippe')) {
            return;
        }

        $indexes = collect(DB::select('SHOW INDEX FROM posisippe'))
            ->pluck('Key_name')
            ->unique();

        if ($indexes->contains('posisippe_idposisi_idbarang_unique')) {
            DB::statement('ALTER TABLE posisippe DROP INDEX posisippe_idposisi_idbarang_unique');
        }

        if (! $indexes->contains('posisippe_idposisi_idsubbarang_unique')) {
            DB::statement('ALTER TABLE posisippe ADD UNIQUE posisippe_idposisi_idsubbarang_unique (idposisi, idsubbarang)');
        }
    }

    public function down(): void
    {
        // Tidak dikembalikan — index lama menyebabkan hanya 1 item per posisi.
    }
};
