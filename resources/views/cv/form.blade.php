@extends('cv.layout')
@section('judul', $biodata->exists ? 'Ubah CV' : 'Buat CV')

@section('isi')
@php
    $pendidikanRows = old('pendidikan', $biodata->exists
        ? $biodata->pendidikan->map(fn ($p) => $p->only(['institusi', 'jurusan', 'tahun_mulai', 'tahun_selesai']))->all()
        : []);

    $portofolioRows = old('portofolio', $biodata->exists
        ? $biodata->portofolio->map(fn ($p) => [
            'kategori_id'     => $p->kategori_id,
            'judul'           => $p->judul,
            'instansi'        => $p->instansi,
            'periode_mulai'   => optional($p->periode_mulai)->format('Y-m'),
            'periode_selesai' => optional($p->periode_selesai)->format('Y-m'),
            'deskripsi'       => $p->deskripsi,
            'tampilkan'       => $p->tampilkan,
        ])->all()
        : []);

    if (count($pendidikanRows) === 0) { $pendidikanRows = [[]]; }
    if (count($portofolioRows) === 0) { $portofolioRows = [[]]; }

    $teknis    = old('kemampuan_teknis', $biodata->exists ? $biodata->kemampuan->where('jenis', 'teknis')->pluck('nama_kemampuan')->implode("\n") : '');
    $nonTeknis = old('kemampuan_non_teknis', $biodata->exists ? $biodata->kemampuan->where('jenis', 'non_teknis')->pluck('nama_kemampuan')->implode("\n") : '');
    $tampilkanFoto = old('_token') ? (bool) old('tampilkan_foto') : $biodata->tampilkan_foto;
@endphp

<div class="bar">
    <h1>{{ $biodata->exists ? 'Ubah CV' : 'Buat CV Baru' }}</h1>
    <a class="btn garis" href="{{ route('cv.index') }}">← Daftar CV</a>
</div>

@if ($errors->any())
    <div class="galat">
        <strong>Data belum lengkap / belum valid:</strong>
        <ul>@foreach ($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
    </div>
@endif

<form method="POST" enctype="multipart/form-data"
      action="{{ $biodata->exists ? route('cv.update', $biodata) : route('cv.store') }}">
    @csrf
    @if ($biodata->exists) @method('PUT') @endif

    <div class="kartu">
        <h2>1. Biodata</h2>
        <div class="kisi">
            <div>
                <label for="nama_lengkap">Nama Lengkap *</label>
                <input type="text" id="nama_lengkap" name="nama_lengkap" value="{{ old('nama_lengkap', $biodata->nama_lengkap) }}" placeholder="Samira Hadid">
            </div>
            <div>
                <label for="posisi">Posisi / Profesi</label>
                <input type="text" id="posisi" name="posisi" value="{{ old('posisi', $biodata->posisi) }}" placeholder="Akuntan">
            </div>
            <div>
                <label for="email">Email *</label>
                <input type="email" id="email" name="email" value="{{ old('email', $biodata->email) }}" placeholder="nama@email.com">
            </div>
            <div>
                <label for="telepon">Telepon *</label>
                <input type="text" id="telepon" name="telepon" value="{{ old('telepon', $biodata->telepon) }}" placeholder="+62 812-3456-7890">
            </div>
            <div class="penuh">
                <label for="alamat">Alamat *</label>
                <input type="text" id="alamat" name="alamat" value="{{ old('alamat', $biodata->alamat) }}" placeholder="Jl. Contoh No. 1, Pekanbaru">
            </div>
            <div class="penuh">
                <label for="tentang_saya">Tentang Saya *</label>
                <textarea id="tentang_saya" name="tentang_saya" placeholder="Ringkasan profil singkat Anda">{{ old('tentang_saya', $biodata->tentang_saya) }}</textarea>
            </div>
        </div>
    </div>

    <div class="kartu">
        <h2>2. Foto</h2>
        @if ($biodata->foto_url)
            <img class="pratinjau" src="{{ $biodata->foto_url }}" alt="Foto saat ini">
        @endif
        <label for="foto">{{ $biodata->foto ? 'Ganti foto (opsional)' : 'Unggah foto (JPG/PNG, maks 2 MB)' }}</label>
        <input type="file" id="foto" name="foto" accept="image/png,image/jpeg">
        <div class="bantuan">Foto berukuran potret (3:4) paling cocok dengan template.</div>
        <input type="hidden" name="tampilkan_foto" value="0">
        <label class="cek" style="margin-top:12px">
            <input type="checkbox" name="tampilkan_foto" value="1" @checked($tampilkanFoto)>
            Sertakan (include) foto di CV – hilangkan centang untuk exclude
        </label>
    </div>

    <div class="kartu">
        <h2>3. Pendidikan</h2>
        <div id="wadah-pendidikan">
            @foreach ($pendidikanRows as $i => $row)
                @include('cv._baris_pendidikan', ['i' => $i, 'row' => $row])
            @endforeach
        </div>
        <button type="button" class="btn garis kecil js-tambah" data-templat="tpl-pendidikan" data-wadah="wadah-pendidikan">+ Tambah pendidikan</button>
    </div>

    <div class="kartu">
        <h2>4. Pengalaman / Portofolio</h2>
        <div id="wadah-portofolio">
            @foreach ($portofolioRows as $i => $row)
                @include('cv._baris_portofolio', ['i' => $i, 'row' => $row, 'kategori' => $kategori])
            @endforeach
        </div>
        <button type="button" class="btn garis kecil js-tambah" data-templat="tpl-portofolio" data-wadah="wadah-portofolio">+ Tambah portofolio</button>
    </div>

    <div class="kartu">
        <h2>5. Kemampuan</h2>
        <div class="kisi">
            <div>
                <label for="kemampuan_teknis">Kemampuan Teknis</label>
                <textarea id="kemampuan_teknis" name="kemampuan_teknis" placeholder="Satu kemampuan per baris">{{ $teknis }}</textarea>
                <div class="bantuan">Satu baris = satu poin.</div>
            </div>
            <div>
                <label for="kemampuan_non_teknis">Kemampuan Non Teknis</label>
                <textarea id="kemampuan_non_teknis" name="kemampuan_non_teknis" placeholder="Satu kemampuan per baris">{{ $nonTeknis }}</textarea>
                <div class="bantuan">Satu baris = satu poin.</div>
            </div>
        </div>
    </div>

    <button type="submit" class="btn">{{ $biodata->exists ? 'Simpan Perubahan & Lihat CV' : 'Simpan & Cetak CV' }}</button>
</form>

<template id="tpl-pendidikan">@include('cv._baris_pendidikan', ['i' => '__INDEX__', 'row' => []])</template>
<template id="tpl-portofolio">@include('cv._baris_portofolio', ['i' => '__INDEX__', 'row' => [], 'kategori' => $kategori])</template>
@endsection

@push('skrip')
<script>
    // Tambah baris dinamis dari <template>
    document.querySelectorAll('.js-tambah').forEach(function (tombol) {
        tombol.addEventListener('click', function () {
            var html = document.getElementById(tombol.dataset.templat).innerHTML;
            var indeks = 'n' + Date.now() + Math.floor(Math.random() * 1000);
            document.getElementById(tombol.dataset.wadah)
                .insertAdjacentHTML('beforeend', html.split('__INDEX__').join(indeks));
        });
    });
    // Hapus baris
    document.addEventListener('click', function (e) {
        if (e.target.classList.contains('js-hapus')) {
            e.target.closest('.baris').remove();
        }
    });
</script>
@endpush
