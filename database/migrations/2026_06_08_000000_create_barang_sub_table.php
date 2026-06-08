<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('barang_sub', function (Blueprint $table) {
            $table->bigIncrements('idsubbarang');
            $table->unsignedBigInteger('idbarang');
            $table->string('kodesubbarang', 100);
            $table->string('namasubbarang', 191);
            $table->timestamps();

            $table->foreign('idbarang')->references('idbarang')->on('barang')->cascadeOnUpdate()->cascadeOnDelete();
            $table->unique(['idbarang', 'kodesubbarang']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('barang_sub');
    }
};
