<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('mahasiswas', function (Blueprint $table) {
            $table->dropForeign(['prodi_id']);
            $table->unsignedBigInteger('prodi_id')->nullable()->change();
        });

        Schema::table('mahasiswas', function (Blueprint $table) {
            $table->foreign('prodi_id')->references('id')->on('prodis')->nullOnDelete();
        });

        Schema::table('mata_kuliahs', function (Blueprint $table) {
            $table->dropForeign(['prodi_id']);
            $table->unsignedBigInteger('prodi_id')->nullable()->change();
        });

        Schema::table('mata_kuliahs', function (Blueprint $table) {
            $table->foreign('prodi_id')->references('id')->on('prodis')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('mahasiswas', function (Blueprint $table) {
            $table->dropForeign(['prodi_id']);
            $table->foreign('prodi_id')->references('id')->on('prodis')->restrictOnDelete();
        });

        Schema::table('mata_kuliahs', function (Blueprint $table) {
            $table->dropForeign(['prodi_id']);
            $table->foreign('prodi_id')->references('id')->on('prodis')->restrictOnDelete();
        });
    }
};
