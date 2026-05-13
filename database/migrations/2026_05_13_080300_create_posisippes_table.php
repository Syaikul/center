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
        Schema::create('posisippe', function (Blueprint $table) {
            $table->bigIncrements('idposppe');
            $table->unsignedBigInteger('idposisi');
            $table->unsignedBigInteger('idbarang');
            $table->unsignedInteger('qty');
            $table->timestamps();

            $table->foreign('idposisi')->references('idposisi')->on('posisi')->cascadeOnUpdate();
            $table->foreign('idbarang')->references('idbarang')->on('barang')->cascadeOnUpdate();
            $table->unique(['idposisi', 'idbarang']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posisippe');
    }
};
