@extends('cv.layout')
@section('judul', 'Daftar CV')

@section('isi')
<div class="bar">
    <h1>Daftar CV</h1>
    <a class="btn" href="{{ route('cv.create') }}">+ Buat CV Baru</a>
</div>

<div class="kartu">
    @if ($daftarCv->isEmpty())
        <p>Belum ada CV. Klik <strong>Buat CV Baru</strong> untuk mengisi biodata.</p>
    @else
        <table>
            <thead>
                <tr><th>Nama</th><th>Posisi</th><th>Portofolio</th><th>Foto</th><th>Aksi</th></tr>
            </thead>
            <tbody>
            @foreach ($daftarCv as $cv)
                <tr>
                    <td>{{ $cv->nama_lengkap }}</td>
                    <td>{{ $cv->posisi ?: '–' }}</td>
                    <td>{{ $cv->portofolio_count }} item</td>
                    <td>{{ $cv->foto ? ($cv->tampilkan_foto ? 'Ditampilkan' : 'Disembunyikan') : 'Tidak ada' }}</td>
                    <td>
                        <div class="aksi">
                            <a class="btn kecil" href="{{ route('cv.show', $cv) }}">Lihat / Cetak</a>
                            <a class="btn kecil garis" href="{{ route('cv.edit', $cv) }}">Ubah</a>
                            <form method="POST" action="{{ route('cv.destroy', $cv) }}"
                                  onsubmit="return confirm('Yakin hapus CV ini?')">
                                @csrf @method('DELETE')
                                <button class="btn kecil bahaya" type="submit">Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
