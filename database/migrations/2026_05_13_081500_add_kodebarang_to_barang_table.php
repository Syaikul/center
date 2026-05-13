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
        Schema::table('barang', function (Blueprint $table) {
            $table->string('kodebarang', 100)->nullable()->after('idbarang');
        });

        Schema::table('barang', function (Blueprint $table) {
            $table->unique('kodebarang');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('barang', function (Blueprint $table) {
            $table->dropUnique(['kodebarang']);
            $table->dropColumn('kodebarang');
        });
    }
};
