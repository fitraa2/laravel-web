<?php

namespace Database\Seeders;

use App\Models\Biodata1104;
use App\Models\KategoriPortofolio1104;
use Illuminate\Database\Seeder;

/** Data contoh sesuai referensi CV (opsional): php artisan db:seed --class=CvContohSeeder */
class CvContohSeeder extends Seeder
{
    public function run(): void
    {
        $magang = KategoriPortofolio1104::where('nama_kategori', 'Magang')->value('id');
        $kerja  = KategoriPortofolio1104::where('nama_kategori', 'Pekerjaan')->value('id');

        $cv = Biodata1104::create([
            'nama_lengkap'   => 'Samira Hadid',
            'posisi'         => 'Akuntan',
            'email'          => 'hello@reallygreatsite.com',
            'telepon'        => '+123-456-7890',
            'alamat'         => '123 Anywhere St., Any City',
            'tentang_saya'   => 'Lulusan Sarjana Ekonomi jurusan Akuntansi Universitas Borcelle yang teliti, terorganisir, dan memiliki pemahaman mendalam dalam bidang keuangan, akuntansi, dan perpajakan. Berpengalaman dalam menyusun laporan keuangan, melakukan analisis data, serta memastikan kepatuhan terhadap peraturan pajak. Memiliki kemampuan multitasking yang baik, perhatian terhadap detail, dan keahlian dalam penggunaan software akuntansi untuk mendukung efisiensi kerja.',
            'tampilkan_foto' => true,
        ]);

        $cv->pendidikan()->createMany([
            ['institusi' => 'Universitas Borcelle', 'jurusan' => 'S1 Akuntansi',      'tahun_mulai' => '2019', 'tahun_selesai' => '2023'],
            ['institusi' => 'SMK Borcelle',         'jurusan' => 'Jurusan Akuntansi', 'tahun_mulai' => '2016', 'tahun_selesai' => '2019'],
        ]);

        $cv->portofolio()->createMany([
            ['kategori_id' => $magang, 'judul' => 'Magang', 'instansi' => 'Borcelle',
             'periode_mulai' => '2022-07-01', 'periode_selesai' => '2022-12-01',
             'deskripsi' => 'Selama magang, saya membantu dalam penyusunan laporan keuangan bulanan dan tahunan, memastikan transaksi keuangan tercatat dengan benar, serta mendukung proses audit internal. Berhasil meningkatkan efisiensi pencatatan transaksi harian dengan mengimplementasikan sistem digitalisasi data keuangan.'],
            ['kategori_id' => $kerja, 'judul' => 'Asisten Administrasi Keuangan', 'instansi' => 'Universitas Borcelle',
             'periode_mulai' => '2021-01-01', 'periode_selesai' => '2021-06-01',
             'deskripsi' => 'Bertanggung jawab atas pengelolaan data keuangan mahasiswa, termasuk tagihan dan pelunasan biaya kuliah. Membantu dalam pembuatan laporan keuangan internal universitas serta melakukan analisis sederhana untuk alokasi dana operasional.'],
        ]);

        foreach (['Penyusunan laporan keuangan', 'Analisis data keuangan', 'Pemahaman perpajakan'] as $k) {
            $cv->kemampuan()->create(['nama_kemampuan' => $k, 'jenis' => 'teknis']);
        }
        foreach (['Komunikasi efektif', 'Manajemen waktu', 'Perhatian terhadap detail'] as $k) {
            $cv->kemampuan()->create(['nama_kemampuan' => $k, 'jenis' => 'non_teknis']);
        }
    }
}
