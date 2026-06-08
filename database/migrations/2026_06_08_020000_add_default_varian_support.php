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
            $table->string('kodevarian', 100)->nullable()->change();
        });

        DB::table('barang_varian')
            ->where('kodevarian', '0')
            ->update([
                'kodevarian' => null,
                'namavarian' => '-',
            ]);

        $subBarangs = DB::table('barang_sub')->get();

        foreach ($subBarangs as $sub) {
            $hasVarian = DB::table('barang_varian')
                ->where('idsubbarang', $sub->idsubbarang)
                ->exists();

            if (! $hasVarian) {
                DB::table('barang_varian')->insert([
                    'idsubbarang' => $sub->idsubbarang,
                    'kodevarian' => null,
                    'namavarian' => '-',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }

    public function down(): void
    {
        DB::table('barang_varian')
            ->where('namavarian', '-')
            ->whereNull('kodevarian')
            ->update(['kodevarian' => '0']);

        Schema::table('barang_varian', function (Blueprint $table) {
            $table->string('kodevarian', 100)->nullable(false)->change();
        });
    }
};
