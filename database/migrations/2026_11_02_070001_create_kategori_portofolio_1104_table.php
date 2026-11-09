<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kategori_portofolio_1104', function (Blueprint $table) {
            $table->id();
            $table->string('nama_kategori', 50)->unique();
            $table->timestamps();
        });

        // Data awal kategori supaya dropdown di form langsung terisi
        $sekarang = now();
        foreach (['Magang', 'Pekerjaan', 'Proyek', 'Organisasi', 'Pelatihan'] as $nama) {
            DB::table('kategori_portofolio_1104')->insert([
                'nama_kategori' => $nama,
                'created_at'    => $sekarang,
                'updated_at'    => $sekarang,
            ]);
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('kategori_portofolio_1104');
    }
};
