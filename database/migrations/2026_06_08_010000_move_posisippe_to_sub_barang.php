<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasColumn('posisippe', 'idsubbarang')) {
            Schema::table('posisippe', function (Blueprint $table) {
                $table->unsignedBigInteger('idsubbarang')->nullable()->after('idposisi');
            });
        }

        if (Schema::hasColumn('posisippe', 'idbarang')) {
            $items = DB::table('posisippe')->get();

            foreach ($items as $item) {
                $sub = DB::table('barang_sub')
                    ->where('idbarang', $item->idbarang)
                    ->orderBy('idsubbarang')
                    ->first();

                if ($sub) {
                    DB::table('posisippe')
                        ->where('idposppe', $item->idposppe)
                        ->update(['idsubbarang' => $sub->idsubbarang]);
                }
            }

            try {
                DB::statement('ALTER TABLE posisippe DROP FOREIGN KEY posisippe_idbarang_foreign');
            } catch (\Throwable $e) {
                // ignore if constraint is already removed
            }

            try {
                DB::statement('ALTER TABLE posisippe DROP INDEX posisippe_idposisi_idbarang_unique');
            } catch (\Throwable $e) {
                // ignore if index is already removed
            }

            Schema::table('posisippe', function (Blueprint $table) {
                $table->dropColumn('idbarang');
            });
        }

        Schema::table('posisippe', function (Blueprint $table) {
            $table->unsignedBigInteger('idsubbarang')->nullable(false)->change();
        });

        try {
            DB::statement('ALTER TABLE posisippe ADD CONSTRAINT posisippe_idsubbarang_foreign FOREIGN KEY (idsubbarang) REFERENCES barang_sub(idsubbarang) ON UPDATE CASCADE');
        } catch (\Throwable $e) {
            // ignore if constraint already exists
        }

        try {
            DB::statement('ALTER TABLE posisippe ADD UNIQUE posisippe_idposisi_idsubbarang_unique (idposisi, idsubbarang)');
        } catch (\Throwable $e) {
            // ignore if index already exists
        }
    }

    public function down(): void
    {
        if (! Schema::hasColumn('posisippe', 'idbarang')) {
            Schema::table('posisippe', function (Blueprint $table) {
                $table->unsignedBigInteger('idbarang')->nullable()->after('idposisi');
            });
        }

        if (Schema::hasColumn('posisippe', 'idsubbarang')) {
            $items = DB::table('posisippe')->get();

            foreach ($items as $item) {
                $sub = DB::table('barang_sub')
                    ->where('idsubbarang', $item->idsubbarang)
                    ->first();

                if ($sub) {
                    DB::table('posisippe')
                        ->where('idposppe', $item->idposppe)
                        ->update(['idbarang' => $sub->idbarang]);
                }
            }

            try {
                DB::statement('ALTER TABLE posisippe DROP FOREIGN KEY posisippe_idsubbarang_foreign');
            } catch (\Throwable $e) {
                // ignore if constraint is already removed
            }

            try {
                DB::statement('ALTER TABLE posisippe DROP INDEX posisippe_idposisi_idsubbarang_unique');
            } catch (\Throwable $e) {
                // ignore if index is already removed
            }

            Schema::table('posisippe', function (Blueprint $table) {
                $table->dropColumn('idsubbarang');
            });
        }

        Schema::table('posisippe', function (Blueprint $table) {
            $table->unsignedBigInteger('idbarang')->nullable(false)->change();
        });

        try {
            DB::statement('ALTER TABLE posisippe ADD CONSTRAINT posisippe_idbarang_foreign FOREIGN KEY (idbarang) REFERENCES barang(idbarang) ON UPDATE CASCADE');
        } catch (\Throwable $e) {
            // ignore if constraint already exists
        }

        try {
            DB::statement('ALTER TABLE posisippe ADD UNIQUE posisippe_idposisi_idbarang_unique (idposisi, idbarang)');
        } catch (\Throwable $e) {
            // ignore if index already exists
        }
    }
};
