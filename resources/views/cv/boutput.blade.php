<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Curriculum Vitae - {{ $data['nama_lengkap'] }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: #e2e8f0; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        .cv-container { max-width: 800px; margin: 40px auto; background: #fff; padding: 50px; border-radius: 8px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); }
        .header-title { border-bottom: 2px solid #0d6efd; padding-bottom: 20px; }
        .section-title { color: #0d6efd; border-bottom: 1px solid #dee2e6; padding-bottom: 5px; margin-top: 30px; margin-bottom: 15px; font-weight: bold; }
        @media print {
            body { background: #fff; }
            .cv-container { box-shadow: none; margin: 0; padding: 20px; width: 100%; max-width: 100%; }
            .no-print { display: none; }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="cv-container">
            <!-- Header CV -->
            <div class="row align-items-center header-title">
                @if(!empty($foto))
                    <div class="col-md-3 text-center">
                        <img src="{{ asset('storage/' . $foto) }}" class="img-fluid rounded-circle shadow-sm" style="width: 130px; height: 130px; object-fit: cover;" alt="Foto Profil">
                    </div>
                    <div class="col-md-9">
                @else
                    <div class="col-md-12">
                @endif
                    <h1 class="fw-bold text-dark mb-1">{{ $data['nama_lengkap'] }}</h1>
                    <h4 class="text-primary mb-2">{{ $data['posisi'] }}</h4>
                    <p class="text-muted mb-0 small">
                        📧 {{ $data['email'] }} | 📱 {{ $data['telepon'] }} | 📍 {{ $data['alamat'] }}
                    </p>
                </div>
            </div>

            <!-- Ringkasan Profil -->
            <div class="mb-4">
                <h5 class="section-title">Profil Singkat</h5>
                <p class="text-secondary">{{ $data['ringkasan'] }}</p>
            </div>

            <!-- Keahlian -->
            <div class="mb-4">
                <h5 class="section-title">Keahlian</h5>
                <div>
                    @foreach(explode(',', $data['keahlian']) as $skill)
                        <span class="badge bg-primary me-1 mb-1 p-2">{{ trim($skill) }}</span>
                    @endforeach
                </div>
            </div>

            <!-- Riwayat Pendidikan -->
            <div class="mb-4">
                <h5 class="section-title">Pendidikan</h5>
                <p class="mb-0 text-secondary fw-semibold">{{ $data['pendidikan'] }}</p>
            </div>

            <!-- Bagian Portofolio (Data dari Tabel Portofolio_1104) -->
            <div class="mb-4">
                <h5 class="section-title">Portofolio Projek</h5>
                @if(isset($portofolios) && count($portofolios) > 0)
                    <div class="row">
                        @foreach($portofolios as $porto)
                            <div class="col-md-6 mb-3">
                                <div class="card h-100 border-0 bg-light p-3">
                                    <h6 class="fw-bold text-dark">{{ $porto->judul_projek }}</h6>
                                    <span class="badge bg-secondary mb-2" style="width: fit-content;">{{ $porto->kategori->nama_kategori ?? 'Umum' }}</span>
                                    <p class="small text-muted mb-2">{{ $porto->deskripsi }}</p>
                                    <p class="small fw-bold text-primary mb-0">Tech: {{ $porto->teknologi_digunakan }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-muted small fst-italic">Belum ada data portofolio tersimpan di database.</p>
                @endif
            </div>

            <!-- Tombol Aksi Print -->
            <div class="text-center mt-5 no-print">
                <button onclick="window.print()" class="btn btn-primary px-4">🖨️ Cetak CV (PDF)</button>
                <a href="{{ route('cv.form') }}" class="btn btn-outline-secondary px-4 ms-2">Kembali Input</a>
            </div>
        </div>
    </div>
</body>
</html>

