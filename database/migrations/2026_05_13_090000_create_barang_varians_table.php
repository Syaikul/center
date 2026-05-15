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
        Schema::create('barang_varian', function (Blueprint $table) {
            $table->bigIncrements('idvarian');
            $table->unsignedBigInteger('idbarang');
            $table->string('kodevarian', 100);
            $table->string('namavarian', 191);
            $table->timestamps();

            $table->foreign('idbarang')->references('idbarang')->on('barang')->cascadeOnUpdate()->cascadeOnDelete();
            $table->unique(['idbarang', 'kodevarian']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('barang_varian');
    }
};
