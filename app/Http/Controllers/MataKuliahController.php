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
            'mataKuliahs' => MataKuliah::with(['mahasiswa', 'prodi'])->latest()->paginate(10),
        ]);
    }

    public function create(): View
    {
        return view('mata-kuliah.create', [
            'mahasiswas' => Mahasiswa::with('prodi')->orderBy('nama_mahasiswa')->get(),
            'prodis' => Prodi::orderBy('nama_prodi')->get(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        MataKuliah::create($request->validate($this->rules()));

        return to_route('mata-kuliah.index')->with('success', 'Mata kuliah berhasil ditambahkan.');
    }

    public function edit(MataKuliah $mataKuliah): View
    {
        return view('mata-kuliah.edit', [
            'mataKuliah' => $mataKuliah,
            'mahasiswas' => Mahasiswa::with('prodi')->orderBy('nama_mahasiswa')->get(),
            'prodis' => Prodi::orderBy('nama_prodi')->get(),
        ]);
    }

    public function update(Request $request, MataKuliah $mataKuliah): RedirectResponse
    {
        $mataKuliah->update($request->validate($this->rules()));

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
            'mahasiswa_id' => ['required', 'exists:mahasiswas,id'],
            'prodi_id' => [
                'required',
                Rule::exists('prodis', 'id'),
                function (string $attribute, mixed $value, \Closure $fail): void {
                    $mahasiswa = Mahasiswa::find(request('mahasiswa_id'));
                    if ($mahasiswa && (int) $mahasiswa->prodi_id !== (int) $value) {
                        $fail('Prodi harus sama dengan prodi mahasiswa yang dipilih.');
                    }
                },
            ],
        ];
    }
}