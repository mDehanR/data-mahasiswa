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
        });

        Schema::table('mahasiswas', function (Blueprint $table) {
            $table->foreign('prodi_id')->references('id')->on('prodis')->restrictOnDelete();
        });

        Schema::table('mata_kuliahs', function (Blueprint $table) {
            $table->dropForeign(['mahasiswa_id']);
            $table->dropForeign(['prodi_id']);
        });

        Schema::table('mata_kuliahs', function (Blueprint $table) {
            $table->foreign('mahasiswa_id')->references('id')->on('mahasiswas')->restrictOnDelete();
            $table->foreign('prodi_id')->references('id')->on('prodis')->restrictOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('mahasiswas', function (Blueprint $table) {
            $table->dropForeign(['prodi_id']);
        });

        Schema::table('mahasiswas', function (Blueprint $table) {
            $table->foreign('prodi_id')->references('id')->on('prodis')->cascadeOnDelete();
        });

        Schema::table('mata_kuliahs', function (Blueprint $table) {
            $table->dropForeign(['mahasiswa_id']);
            $table->dropForeign(['prodi_id']);
        });

        Schema::table('mata_kuliahs', function (Blueprint $table) {
            $table->foreign('mahasiswa_id')->references('id')->on('mahasiswas')->cascadeOnDelete();
            $table->foreign('prodi_id')->references('id')->on('prodis')->cascadeOnDelete();
        });
    }
};
