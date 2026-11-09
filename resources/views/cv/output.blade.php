@php
    // "Samira Hadid" -> baris 1 "Samira", baris 2 "Hadid."
    $kata      = preg_split('/\s+/', trim($biodata->nama_lengkap));
    $namaDepan = array_shift($kata);
    $namaSisa  = count($kata) ? implode(' ', $kata) . '.' : '';
    if ($namaSisa === '') { $namaDepan .= '.'; }
@endphp
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>CV – {{ $biodata->nama_lengkap }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Sora:wght@700;800&display=swap" rel="stylesheet">
    <style>
        :root { --kertas:#f2f2f2; --tinta:#000; }
        * { box-sizing: border-box; }
        body { margin:0; background:#d1d5db; font-family: Arial, Helvetica, sans-serif; color:var(--tinta); }
        .judul-besar, h2 { font-family: 'Sora', 'Arial Black', Arial, sans-serif; font-weight:800; }

        .toolbar { max-width:210mm; margin:16px auto 0; padding:0 8px; display:flex; gap:8px; flex-wrap:wrap; align-items:center; }
        .toolbar a, .toolbar button { font:inherit; font-size:13px; padding:8px 14px; border-radius:6px; border:1px solid #111827; background:#111827; color:#fff; text-decoration:none; cursor:pointer; }
        .toolbar a.garis { background:#fff; color:#111827; }
        .toolbar .info { font-size:13px; color:#374151; margin-left:auto; }

        .kertas { width:210mm; min-height:297mm; margin:12px auto 32px; background:var(--kertas); padding:20mm 22mm 18mm; box-shadow:0 4px 18px rgba(0,0,0,.2); }

        .kepala { display:flex; align-items:flex-end; gap:16mm; margin-bottom:16mm; }
        .foto { width:42mm; height:58mm; object-fit:cover; flex:none; display:block; }
        .nama { margin:0; font-size:54pt; line-height:1.02; letter-spacing:-1px; }
        .posisi { margin:8px 0 0; font-size:12pt; letter-spacing:.5px; }

        h2 { margin:0 0 6mm; font-size:21pt; line-height:1.1; }
        .bagian { padding:6mm 0; }
        .garis-atas { border-top:2px solid var(--tinta); }
        p { margin:0; font-size:10.5pt; line-height:1.55; text-align:justify; }
        .item { margin-bottom:6mm; }
        .item:last-child { margin-bottom:0; }
        .item h3 { margin:0 0 1mm; font-size:12.5pt; font-weight:bold; }

        .dua-kolom { display:grid; grid-template-columns: 1fr 1fr; }
        .dua-kolom > div { padding-top:6mm; }
        .kolom-kanan { border-left:2px solid var(--tinta); padding-left:7mm; }
        .kolom-kiri { padding-right:7mm; }
        .baris-info { font-size:10.5pt; line-height:1.55; }
        .pendidikan-item { margin-bottom:5mm; }
        .subjudul { font-size:10.5pt; margin:0 0 3mm; }
        ul { margin:0 0 7mm; padding-left:5mm; }
        li { font-size:10.5pt; line-height:1.55; }
        .kontak { margin-top:14mm; }
        .kontak .baris-info { margin-bottom:2mm; word-break:break-word; }

        @page { size: A4; margin: 0; }
        @media print {
            body { background:var(--kertas); -webkit-print-color-adjust:exact; print-color-adjust:exact; }
            .toolbar { display:none; }
            .kertas { margin:0; box-shadow:none; width:210mm; min-height:297mm; }
        }
        @media (max-width: 800px) {
            .kertas { width:100%; padding:20px; min-height:0; }
            .nama { font-size:34pt; }
            .foto { width:28mm; height:38mm; }
            .kepala { gap:5mm; }
        }
    </style>
</head>
<body>

<div class="toolbar">
    <a class="garis" href="{{ route('cv.index') }}">← Daftar CV</a>
    <a class="garis" href="{{ route('cv.edit', $biodata) }}">Ubah data</a>
    @if ($biodata->foto)
        @if ($tampilkanFoto)
            <a class="garis" href="{{ route('cv.show', [$biodata, 'foto' => 0]) }}">Sembunyikan foto</a>
        @else
            <a class="garis" href="{{ route('cv.show', [$biodata, 'foto' => 1]) }}">Tampilkan foto</a>
        @endif
    @endif
    <button type="button" onclick="window.print()">Cetak / Simpan PDF</button>
    <span class="info">Tip: pada dialog cetak, matikan “Headers and footers”.</span>
</div>

<div class="kertas">
    <header class="kepala">
        @if ($tampilkanFoto)
            <img class="foto" src="{{ $biodata->foto_url }}" alt="Foto {{ $biodata->nama_lengkap }}">
        @endif
        <div>
            <h1 class="nama judul-besar">{{ $namaDepan }}@if ($namaSisa !== '')<br>{{ $namaSisa }}@endif</h1>
            @if ($biodata->posisi)
                <div class="posisi">{{ $biodata->posisi }}</div>
            @endif
        </div>
    </header>

    <section class="bagian">
        <h2>Tentang Saya</h2>
        <p>{!! nl2br(e($biodata->tentang_saya)) !!}</p>
    </section>

    @if ($portofolio->isNotEmpty())
        <section class="bagian garis-atas">
            <h2>Pengalaman</h2>
            @foreach ($portofolio as $item)
                <div class="item">
                    <h3>{{ $item->judul }}{{ $item->instansi ? ' – ' . $item->instansi : '' }} ({{ $item->periode }})</h3>
                    @if ($item->deskripsi)
                        <p>{!! nl2br(e($item->deskripsi)) !!}</p>
                    @endif
                </div>
            @endforeach
        </section>
    @endif

    <section class="garis-atas dua-kolom">
        <div class="kolom-kiri">
            <h2>Pendidikan</h2>
            @forelse ($biodata->pendidikan as $pend)
                <div class="pendidikan-item baris-info">
                    {{ $pend->institusi }} ({{ $pend->rentang }})
                    @if ($pend->jurusan)<br>{{ $pend->jurusan }}@endif
                </div>
            @empty
                <div class="baris-info">–</div>
            @endforelse

            <div class="kontak">
                <h2>Kontak</h2>
                <div class="baris-info">{{ $biodata->telepon }}</div>
                <div class="baris-info">{{ $biodata->email }}</div>
                <div class="baris-info">{{ $biodata->alamat }}</div>
            </div>
        </div>

        <div class="kolom-kanan">
            <h2>Kemampuan</h2>
            @if ($teknis->isNotEmpty())
                <div class="subjudul">Kemampuan Teknis :</div>
                <ul>@foreach ($teknis as $k)<li>{{ $k->nama_kemampuan }}</li>@endforeach</ul>
            @endif
            @if ($nonTeknis->isNotEmpty())
                <div class="subjudul">Kemampuan Non Teknis :</div>
                <ul>@foreach ($nonTeknis as $k)<li>{{ $k->nama_kemampuan }}</li>@endforeach</ul>
            @endif
            @if ($teknis->isEmpty() && $nonTeknis->isEmpty())
                <div class="baris-info">–</div>
            @endif
        </div>
    </section>
</div>

</body>
</html>
