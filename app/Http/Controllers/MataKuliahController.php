<?php

namespace App\Http\Controllers;

use App\Models\MataKuliah;
use App\Models\Mahasiswa;
use App\Models\Prodi;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class MataKuliahController extends Controller
{
    public function index(): View
    {
        return view('mata-kuliah.index', [
            'mataKuliahs' => MataKuliah::with(['mahasiswas', 'prodi'])->latest()->paginate(10),
        ]);
    }

    public function create(): View
    {
        return view('mata-kuliah.create', [
            'mahasiswas' => Mahasiswa::with('prodi')->orderBy('nama_mahasiswa')->get(),
            'prodis' => Prodi::orderBy('nama_prodi')->get(),
        ]);
    }

    public function show(MataKuliah $mataKuliah): View
    {
        $mataKuliah->load(['mahasiswas.prodi', 'prodi']);

        return view('mata-kuliah.show', compact('mataKuliah'));
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate($this->rules());
        $mahasiswaIds = $data['mahasiswa_ids'];
        unset($data['mahasiswa_ids']);

        $mataKuliah = MataKuliah::create($data);
        $mataKuliah->mahasiswas()->sync($mahasiswaIds);

        return to_route('mata-kuliah.index')->with('success', 'Mata kuliah berhasil ditambahkan.');
    }

    public function edit(MataKuliah $mataKuliah): View
    {
        return view('mata-kuliah.edit', [
            'mataKuliah' => $mataKuliah->load('mahasiswas'),
            'mahasiswas' => Mahasiswa::with('prodi')->orderBy('nama_mahasiswa')->get(),
            'prodis' => Prodi::orderBy('nama_prodi')->get(),
        ]);
    }

    public function update(Request $request, MataKuliah $mataKuliah): RedirectResponse
    {
        $data = $request->validate($this->rules());
        $mahasiswaIds = $data['mahasiswa_ids'];
        unset($data['mahasiswa_ids']);

        $mataKuliah->update($data);
        $mataKuliah->mahasiswas()->sync($mahasiswaIds);

        return to_route('mata-kuliah.index')->with('success', 'Mata kuliah berhasil diperbarui.');
    }

    public function destroy(MataKuliah $mataKuliah): RedirectResponse
    {
        $mataKuliah->delete();

        return to_route('mata-kuliah.index')->with('success', 'Mata kuliah berhasil dihapus.');
    }

    private function rules(): array
    {
        return [
            'nama_mata_kuliah' => ['required', 'string', 'max:255'],
            'sks' => ['required', 'integer', 'min:1', 'max:8'],
            'mahasiswa_ids' => ['required', 'array', 'min:1'],
            'mahasiswa_ids.*' => ['required', 'integer', 'distinct', 'exists:mahasiswas,id'],
            'prodi_id' => ['nullable', Rule::exists('prodis', 'id')],
        ];
    }
}
