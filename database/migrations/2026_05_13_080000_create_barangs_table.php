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
        Schema::create('barang', function (Blueprint $table) {
            $table->bigIncrements('idbarang');
            $table->string('kodebarang', 100)->unique();
            $table->string('namabarang', 191);
            $table->unsignedBigInteger('idkategori');
            $table->unsignedBigInteger('idsatuan');
            $table->timestamps();

            $table->foreign('idkategori')->references('idkategori')->on('kategori')->cascadeOnUpdate();
            $table->foreign('idsatuan')->references('idsatuan')->on('satuan')->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('barang');
    }
};
