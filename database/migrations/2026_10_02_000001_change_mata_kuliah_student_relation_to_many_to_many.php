<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('mahasiswa_mata_kuliah', function (Blueprint $table) {
            $table->foreignId('mahasiswa_id')->constrained('mahasiswas')->cascadeOnDelete();
            $table->foreignId('mata_kuliah_id')->constrained('mata_kuliahs')->cascadeOnDelete();
            $table->primary(['mahasiswa_id', 'mata_kuliah_id']);
        });

        DB::table('mata_kuliahs')
            ->whereNotNull('mahasiswa_id')
            ->orderBy('id')
            ->get(['id', 'mahasiswa_id'])
            ->each(function (object $mataKuliah): void {
                DB::table('mahasiswa_mata_kuliah')->insert([
                    'mahasiswa_id' => $mataKuliah->mahasiswa_id,
                    'mata_kuliah_id' => $mataKuliah->id,
                ]);
            });

        Schema::table('mata_kuliahs', function (Blueprint $table) {
            $table->dropForeign(['mahasiswa_id']);
        });

        Schema::table('mata_kuliahs', function (Blueprint $table) {
            $table->dropColumn('mahasiswa_id');
        });
    }

    public function down(): void
    {
        Schema::table('mata_kuliahs', function (Blueprint $table) {
            $table->foreignId('mahasiswa_id')->nullable()->constrained('mahasiswas')->nullOnDelete();
        });

        $restoredCourses = [];
        DB::table('mahasiswa_mata_kuliah')
            ->orderBy('mata_kuliah_id')
            ->orderBy('mahasiswa_id')
            ->get(['mata_kuliah_id', 'mahasiswa_id'])
            ->each(function (object $relationship) use (&$restoredCourses): void {
                if (in_array($relationship->mata_kuliah_id, $restoredCourses, true)) {
                    return;
                }

                DB::table('mata_kuliahs')
                    ->where('id', $relationship->mata_kuliah_id)
                    ->update(['mahasiswa_id' => $relationship->mahasiswa_id]);
                $restoredCourses[] = $relationship->mata_kuliah_id;
            });

        Schema::dropIfExists('mahasiswa_mata_kuliah');
    }
};
