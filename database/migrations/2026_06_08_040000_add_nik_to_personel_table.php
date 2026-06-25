<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('personel', function (Blueprint $table) {
            $table->string('nik', 50)->nullable()->after('idpersonel');
        });

        foreach (DB::table('personel')->orderBy('idpersonel')->get() as $row) {
            DB::table('personel')
                ->where('idpersonel', $row->idpersonel)
                ->update(['nik' => 'TMP-'.$row->idpersonel]);
        }

        DB::statement('ALTER TABLE personel MODIFY nik VARCHAR(50) NOT NULL');

        Schema::table('personel', function (Blueprint $table) {
            $table->unique('nik');
        });
    }

    public function down(): void
    {
        Schema::table('personel', function (Blueprint $table) {
            $table->dropUnique(['nik']);
            $table->dropColumn('nik');
        });
    }
};
