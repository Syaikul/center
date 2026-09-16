<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('personel', function (Blueprint $table) {
            $table->text('alamat')->nullable()->after('namapersonel');
            $table->string('nomorhp', 20)->nullable()->after('alamat');
            $table->string('email', 191)->nullable()->after('nomorhp');
        });
    }

    public function down(): void
    {
        Schema::table('personel', function (Blueprint $table) {
            $table->dropColumn(['alamat', 'nomorhp', 'email']);
        });
    }
};
