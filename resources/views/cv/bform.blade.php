<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Input Biodata & Data Portofolio</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://jsdelivr.net"></script>
    <link rel="stylesheet" href="https://cloudflare.com">
</head>
<body class="bg-gray-100 font-sans text-gray-800 antialiased">

    <div class="flex min-h-screen">
        <!-- 1. SIDEBAR (Konsisten dengan Sisi Kiri Output) -->
        <aside class="w-64 bg-slate-900 text-slate-300 flex flex-col justify-between p-4 hidden md:flex shrink-0">
            <div>
                <!-- Brand / Logo -->
                <div class="flex items-center gap-3 px-2 py-3 border-b border-slate-800 mb-6">
                    <span class="p-2 bg-indigo-600 text-white rounded-lg text-xs font-bold"><i class="fa-solid fa-bolt text-sm"></i></span>
                    <span class="text-lg font-semibold text-white tracking-wide">CV Builder</span>
                </div>
                <!-- Navigasi -->
                <nav class="space-y-1">
                    <a href="#" class="flex items-center gap-3 px-3 py-2.5 rounded-lg bg-slate-800 text-white font-medium text-sm transition">
                        <i class="fa-solid fa-pen-to-square text-indigo-400"></i> Form Input CV
                    </a>
                    <a href="#" class="flex items-center justify-between px-3 py-2.5 rounded-lg text-slate-400 hover:bg-slate-800 hover:text-white text-sm transition">
                        <span class="flex items-center gap-3"><i class="fa-solid fa-table"></i> Preview Hasil</span>
                        <i class="fa-solid fa-chevron-right text-xs"></i>
                    </a>
                </nav>
            </div>
            <button class="w-full bg-amber-500 hover:bg-amber-600 text-slate-900 font-semibold py-2.5 px-4 rounded-lg flex items-center justify-center gap-2 text-sm transition">
                <i class="fa-solid fa-crown text-xs"></i> Upgrade to Pro
            </button>
        </aside>

        <!-- MAIN CONTENT AREA -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Top Navbar Minimalis -->
            <header class="h-16 bg-white border-b border-gray-200 flex items-center justify-between px-6 shrink-0">
                <div class="text-sm font-semibold text-gray-500">Workspace / <span class="text-gray-800 font-bold">Lengkapi Profil</span></div>
                <div class="flex items-center gap-3">
                    <img src="https://unsplash.com" alt="Admin Profile" class="w-8 h-8 rounded-full object-cover">
                    <span class="text-xs font-semibold text-gray-700 hidden sm:inline">User Admin</span>
                </div>
            </header>

            <!-- FORM CONTAINER -->
            <main class="flex-1 p-6 overflow-y-auto space-y-6">
                <div class="flex justify-between items-center">
                    <h1 class="text-xl font-bold text-gray-900 tracking-tight">Formulir Pembuatan CV</h1>
                </div>

                <!-- Tampilkan Error Validasi Jika Ada -->
                @if ($errors->any())
                    <div class="bg-red-50 border-l-4 border-red-500 p-4 rounded-r-lg text-xs text-red-700">
                        <p class="font-bold mb-1">Mohon perbaiki kesalahan berikut:</p>
                        <ul class="list-disc pl-4 space-y-0.5">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Form Utama Mengarah ke Endpoint Route Generate -->
                <form action="{{ url('/cv/generate') }}" method="POST" enctype="multipart/form-data" class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-start">
                    @csrf

                    <!-- KOLOM UTAMA (Biodata Diri - Mengambil Sisi Kiri) -->
                    <div class="lg:col-span-2 space-y-6">
                        <div class="bg-white rounded-xl shadow-xs border border-gray-200 p-6">
                            <div class="border-b border-gray-100 pb-3 mb-5">
                                <h2 class="text-sm font-bold text-gray-800 flex items-center gap-2">
                                    <i class="fa-solid fa-user text-indigo-600"></i> Informasi Personal Utama
                                </h2>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div class="space-y-1">
                                    <label class="text-xs font-bold text-gray-700">Nama Lengkap</label>
                                    <input type="text" name="nama_lengkap" placeholder="Contoh: Neil Sims" value="{{ old('nama_lengkap') }}" required
                                        class="w-full text-xs p-2.5 bg-gray-50 border border-gray-300 rounded-lg focus:ring-1 focus:ring-indigo-500 focus:bg-white outline-none transition">
                                </div>

                                <div class="space-y-1">
                                    <label class="text-xs font-bold text-gray-700">Posisi / Pekerjaan</label>
                                    <input type="text" name="posisi" placeholder="Contoh: Senior Software Engineer" value="{{ old('posisi') }}" required
                                        class="w-full text-xs p-2.5 bg-gray-50 border border-gray-300 rounded-lg focus:ring-1 focus:ring-indigo-500 focus:bg-white outline-none transition">
                                </div>

                                <div class="space-y-1">
                                    <label class="text-xs font-bold text-gray-700">Alamat Email</label>
                                    <input type="email" name="email" placeholder="name@company.com" value="{{ old('email') }}" required
                                        class="w-full text-xs p-2.5 bg-gray-50 border border-gray-300 rounded-lg focus:ring-1 focus:ring-indigo-500 focus:bg-white outline-none transition">
                                </div>

                                <div class="space-y-1">
                                    <label class="text-xs font-bold text-gray-700">Nomor Telepon</label>
                                    <input type="text" name="telepon" placeholder="Contoh: 08123456789" value="{{ old('telepon') }}" required
                                        class="w-full text-xs p-2.5 bg-gray-50 border border-gray-300 rounded-lg focus:ring-1 focus:ring-indigo-500 focus:bg-white outline-none transition">
                                </div>
                            </div>
                        </div>

                        <!-- Card Pelengkap: Pengaturan Kustom -->
                        <div class="bg-white rounded-xl shadow-xs border border-gray-200 p-6">
                            <div class="border-b border-gray-100 pb-3 mb-4">
                                <h3 class="text-sm font-bold text-gray-800 flex items-center gap-2">
                                    <i class="fa-solid fa-sliders text-indigo-600"></i> Opsi Tampilan Tambahan
                                </h3>
                            </div>
                            <div class="flex items-center gap-3 bg-gray-50 p-3 rounded-lg border border-gray-200">
                                <input type="checkbox" name="tampilkan_foto" id="tampilkan_foto" value="1" checked class="w-4 h-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                                <label for="tampilkan_foto" class="text-xs font-medium text-gray-700 selection:bg-transparent">
                                    Sertakan foto profil ke dalam hasil dokumen CV akhir
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- KOLOM KANAN (Upload Pas Foto & Submit Aksi) -->
                    <div class="space-y-6">
                        <div class="bg-white rounded-xl shadow-xs border border-gray-200 p-6 text-center">
                            <div class="border-b border-gray-100 pb-3 mb-5 text-left">
                                <h2 class="text-sm font-bold text-gray-800 flex items-center gap-2">
                                    <i class="fa-solid fa-image text-indigo-600"></i> Pas Foto Profil
                                </h2>
                            </div>

                            <!-- Area File Input Box -->
                            <div class="border-2 border-dashed border-gray-300 rounded-xl p-6 bg-gray-50/50 hover:bg-gray-50 transition relative group">
                                <i class="fa-solid fa-cloud-arrow-up text-3xl text-gray-400 group-hover:text-indigo-500 transition mb-3 block"></i>
                                <label class="block text-xs font-semibold text-gray-600 cursor-pointer">
                                    <span class="text-indigo-600 underline">Pilih berkas foto</span> atau seret kemari
                                    <input type="file" name="foto" class="hidden" accept="image/png, image/jpeg, image/jpg">
                                </label>
                                <p class="text-[10px] text-gray-400 mt-2">Format: JPG, JPEG, atau PNG (Maksimal 2 MB)</p>
                            </div>
                        </div>

                        <!-- Tombol Submit Utama -->
                        <div class="bg-white rounded-xl shadow-xs border border-gray-200 p-4">
