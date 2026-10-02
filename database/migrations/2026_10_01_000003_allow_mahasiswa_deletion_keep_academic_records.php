<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('mata_kuliahs', function (Blueprint $table) {
            $table->dropForeign(['mahasiswa_id']);
            $table->unsignedBigInteger('mahasiswa_id')->nullable()->change();
        });

        Schema::table('mata_kuliahs', function (Blueprint $table) {
            $table->foreign('mahasiswa_id')->references('id')->on('mahasiswas')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('mata_kuliahs', function (Blueprint $table) {
            $table->dropForeign(['mahasiswa_id']);
            $table->unsignedBigInteger('mahasiswa_id')->nullable(false)->change();
        });

        Schema::table('mata_kuliahs', function (Blueprint $table) {
            $table->foreign('mahasiswa_id')->references('id')->on('mahasiswas')->restrictOnDelete();
        });
    }
};
