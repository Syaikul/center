<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('kategori')) {
            return;
        }

        try {
            DB::statement('ALTER TABLE barang DROP FOREIGN KEY barang_idkategori_foreign');
        } catch (\Throwable $e) {
            // ignore if already removed
        }

        Schema::rename('kategori', 'tipe');

        DB::statement('ALTER TABLE tipe CHANGE idkategori idtipe BIGINT UNSIGNED NOT NULL AUTO_INCREMENT');
        DB::statement('ALTER TABLE tipe CHANGE nama_kategori nama_tipe VARCHAR(191) NOT NULL');

        DB::statement('ALTER TABLE barang CHANGE idkategori idtipe BIGINT UNSIGNED NOT NULL');
        DB::statement('ALTER TABLE barang ADD CONSTRAINT barang_idtipe_foreign FOREIGN KEY (idtipe) REFERENCES tipe(idtipe) ON UPDATE CASCADE');
    }

    public function down(): void
    {
        if (! Schema::hasTable('tipe')) {
            return;
        }

        try {
            DB::statement('ALTER TABLE barang DROP FOREIGN KEY barang_idtipe_foreign');
        } catch (\Throwable $e) {
            // ignore
        }

        DB::statement('ALTER TABLE barang CHANGE idtipe idkategori BIGINT UNSIGNED NOT NULL');

        DB::statement('ALTER TABLE tipe CHANGE idtipe idkategori BIGINT UNSIGNED NOT NULL AUTO_INCREMENT');
        DB::statement('ALTER TABLE tipe CHANGE nama_tipe nama_kategori VARCHAR(191) NOT NULL');

        Schema::rename('tipe', 'kategori');

        DB::statement('ALTER TABLE barang ADD CONSTRAINT barang_idkategori_foreign FOREIGN KEY (idkategori) REFERENCES kategori(idkategori) ON UPDATE CASCADE');
    }
};
