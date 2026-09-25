@extends('layouts.app', ['title' => 'Edit Prodi | Data Kampus'])
@section('content')
    <section class="mx-auto max-w-3xl px-5 py-10 sm:px-8"><p class="mb-3 text-xs font-bold uppercase tracking-[0.2em] text-campus">Administrasi akademik</p><h1 class="font-display text-3xl font-bold text-navy">Edit Program Studi</h1><div class="mt-8 rounded-xl border border-slate-200 bg-white p-6 shadow-sm">@include('partials.form-errors')<form method="POST" action="{{ route('prodi.update', $prodi) }}">@method('PUT') @include('prodi.form')</form></div></section>
@endsection