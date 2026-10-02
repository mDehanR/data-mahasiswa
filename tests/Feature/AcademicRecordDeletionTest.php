<?php

namespace Tests\Feature;

use App\Models\Mahasiswa;
use App\Models\MataKuliah;
use App\Models\Prodi;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AcademicRecordDeletionTest extends TestCase
{
    use RefreshDatabase;

    public function test_deleting_a_prodi_keeps_students_and_courses(): void
    {
        $prodi = Prodi::create(['nama_prodi' => 'Informatika', 'akreditasi' => 'Baik']);
        $mahasiswa = Mahasiswa::create([
            'nim' => '1001',
            'nama_mahasiswa' => 'Ayu',
            'jenis_kelamin' => 'P',
            'alamat' => 'Bandung',
            'prodi_id' => $prodi->id,
        ]);
        $mataKuliah = MataKuliah::create([
            'nama_mata_kuliah' => 'Basis Data',
            'sks' => 3,
            'prodi_id' => $prodi->id,
        ]);
        $mataKuliah->mahasiswas()->attach($mahasiswa);

        $this->delete(route('prodi.destroy', $prodi))
            ->assertRedirect(route('prodi.index'))
            ->assertSessionHas('success');

        $this->assertDatabaseMissing('prodis', ['id' => $prodi->id]);
        $this->assertDatabaseHas('mahasiswas', ['id' => $mahasiswa->id, 'prodi_id' => null]);
        $this->assertDatabaseHas('mata_kuliahs', [
            'id' => $mataKuliah->id,
            'nama_mata_kuliah' => 'Basis Data',
            'prodi_id' => null,
        ]);
        $this->assertDatabaseHas('mahasiswa_mata_kuliah', [
            'mahasiswa_id' => $mahasiswa->id,
            'mata_kuliah_id' => $mataKuliah->id,
        ]);
    }

    public function test_deleting_a_mahasiswa_with_related_courses_keeps_all_records(): void
    {
        $prodi = Prodi::create(['nama_prodi' => 'Informatika', 'akreditasi' => 'Baik']);
        $mahasiswa = Mahasiswa::create([
            'nim' => '1002',
            'nama_mahasiswa' => 'Budi',
            'jenis_kelamin' => 'L',
            'alamat' => 'Jakarta',
            'prodi_id' => $prodi->id,
        ]);
        $mataKuliah = MataKuliah::create([
            'nama_mata_kuliah' => 'Algoritma',
            'sks' => 3,
            'prodi_id' => $prodi->id,
        ]);
        $mataKuliah->mahasiswas()->attach($mahasiswa);

        $this->delete(route('mahasiswa.destroy', $mahasiswa))
            ->assertRedirect(route('mahasiswa.index'))
            ->assertSessionHas('success');

        $this->assertDatabaseMissing('mahasiswas', ['id' => $mahasiswa->id]);
        $this->assertDatabaseHas('mata_kuliahs', [
            'id' => $mataKuliah->id,
            'nama_mata_kuliah' => 'Algoritma',
            'prodi_id' => $prodi->id,
        ]);
        $this->assertDatabaseMissing('mahasiswa_mata_kuliah', [
            'mahasiswa_id' => $mahasiswa->id,
            'mata_kuliah_id' => $mataKuliah->id,
        ]);
    }

    public function test_mata_kuliah_index_shows_related_names_without_id_columns(): void
    {
        $prodi = Prodi::create(['nama_prodi' => 'Informatika', 'akreditasi' => 'Baik']);
        $mahasiswa = Mahasiswa::create([
            'nim' => '1003',
            'nama_mahasiswa' => 'Citra',
            'jenis_kelamin' => 'P',
            'alamat' => 'Bandung',
            'prodi_id' => $prodi->id,
        ]);
        $mataKuliah = MataKuliah::create([
            'nama_mata_kuliah' => 'Pemrograman Web',
            'sks' => 3,
            'prodi_id' => $prodi->id,
        ]);
        $mataKuliah->mahasiswas()->attach($mahasiswa);

        $this->get(route('mata-kuliah.index'))
            ->assertOk()
            ->assertSee('Mahasiswa')
            ->assertSee('Program Studi')
            ->assertSee('Citra')
            ->assertSee('Informatika')
            ->assertDontSee('Mahasiswa ID')
            ->assertDontSee('Prodi ID')
            ->assertDontSee('Relasi Data');
    }

    public function test_mahasiswa_index_shows_prodi_name_instead_of_prodi_id(): void
    {
        $prodi = Prodi::create(['nama_prodi' => 'Teknik Informatika', 'akreditasi' => 'Baik']);
        Mahasiswa::create([
            'nim' => '1006',
            'nama_mahasiswa' => 'Fajar',
            'jenis_kelamin' => 'L',
            'alamat' => 'Bandung',
            'prodi_id' => $prodi->id,
        ]);

        $this->get(route('mahasiswa.index'))
            ->assertOk()
            ->assertSee('Program Studi')
            ->assertSee('Teknik Informatika')
            ->assertDontSee('Prodi ID');
    }

    public function test_one_course_can_be_assigned_to_multiple_students(): void
    {
        $prodi = Prodi::create(['nama_prodi' => 'Informatika', 'akreditasi' => 'Baik']);
        $mahasiswaPertama = Mahasiswa::create([
            'nim' => '1004',
            'nama_mahasiswa' => 'Dina',
            'jenis_kelamin' => 'P',
            'alamat' => 'Bandung',
            'prodi_id' => $prodi->id,
        ]);
        $prodiLain = Prodi::create(['nama_prodi' => 'Manajemen', 'akreditasi' => 'Baik']);
        $mahasiswaKedua = Mahasiswa::create([
            'nim' => '1005',
            'nama_mahasiswa' => 'Eko',
            'jenis_kelamin' => 'L',
            'alamat' => 'Bandung',
            'prodi_id' => $prodiLain->id,
        ]);

        $this->get(route('mata-kuliah.create'))
            ->assertOk()
            ->assertSee('type="checkbox"', false)
            ->assertSee('name="mahasiswa_ids[]"', false);

        $this->post(route('mata-kuliah.store'), [
            'nama_mata_kuliah' => 'Struktur Data',
            'sks' => 3,
            'mahasiswa_ids' => [$mahasiswaPertama->id, $mahasiswaKedua->id],
            'prodi_id' => $prodi->id,
        ])->assertRedirect(route('mata-kuliah.index'));

        $mataKuliah = MataKuliah::where('nama_mata_kuliah', 'Struktur Data')->firstOrFail();
        $this->assertCount(2, $mataKuliah->mahasiswas);
        $this->get(route('mata-kuliah.index'))
            ->assertOk()
            ->assertSee('Dina')
            ->assertSee('Eko');
    }
}
