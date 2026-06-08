<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('barang_varian', function (Blueprint $table) {
            $table->unsignedBigInteger('idsubbarang')->nullable()->after('idvarian');
        });

        $barangIds = DB::table('barang_varian')->distinct()->pluck('idbarang');

        foreach ($barangIds as $idbarang) {
            $barang = DB::table('barang')->where('idbarang', $idbarang)->first();
            if (! $barang) {
                continue;
            }

            $idsubbarang = DB::table('barang_sub')->insertGetId([
                'idbarang' => $idbarang,
                'kodesubbarang' => '0',
                'namasubbarang' => $barang->namabarang,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            DB::table('barang_varian')
                ->where('idbarang', $idbarang)
                ->update(['idsubbarang' => $idsubbarang]);
        }

        Schema::table('barang_varian', function (Blueprint $table) {
            $table->dropForeign(['idbarang']);
            $table->dropUnique(['idbarang', 'kodevarian']);
            $table->dropColumn('idbarang');

            $table->unsignedBigInteger('idsubbarang')->nullable(false)->change();

            $table->foreign('idsubbarang')->references('idsubbarang')->on('barang_sub')->cascadeOnUpdate()->cascadeOnDelete();
            $table->unique(['idsubbarang', 'kodevarian']);
        });
    }

    public function down(): void
    {
        Schema::table('barang_varian', function (Blueprint $table) {
            $table->unsignedBigInteger('idbarang')->nullable()->after('idvarian');
        });

        $subBarangs = DB::table('barang_sub')->get();

        foreach ($subBarangs as $sub) {
            DB::table('barang_varian')
                ->where('idsubbarang', $sub->idsubbarang)
                ->update(['idbarang' => $sub->idbarang]);
        }

        Schema::table('barang_varian', function (Blueprint $table) {
            $table->dropForeign(['idsubbarang']);
            $table->dropUnique(['idsubbarang', 'kodevarian']);
            $table->dropColumn('idsubbarang');

            $table->unsignedBigInteger('idbarang')->nullable(false)->change();

            $table->foreign('idbarang')->references('idbarang')->on('barang')->cascadeOnUpdate()->cascadeOnDelete();
            $table->unique(['idbarang', 'kodevarian']);
        });

        Schema::dropIfExists('barang_sub');
    }
};
