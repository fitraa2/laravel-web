<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Portofolio1104 extends Model
{
    protected $table = 'Portofolio_1104';

    protected $fillable = [
        'biodata_id', 'kategori_id', 'judul', 'instansi',
        'periode_mulai', 'periode_selesai', 'deskripsi', 'tampilkan',
    ];

    public const BULAN = [
        1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
        5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
        9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember',
    ];

    protected function casts(): array
    {
        return [
            'periode_mulai'   => 'date',
            'periode_selesai' => 'date',
            'tampilkan'       => 'boolean',
        ];
    }

    public function biodata(): BelongsTo
    {
        return $this->belongsTo(Biodata1104::class, 'biodata_id');
    }

    public function kategori(): BelongsTo
    {
        return $this->belongsTo(KategoriPortofolio1104::class, 'kategori_id');
    }

    private static function bulanTahun(?Carbon $tanggal): string
    {
        return $tanggal ? self::BULAN[$tanggal->month] . ' ' . $tanggal->year : '';
    }

    /** Contoh hasil: "Juli 2022 – Desember 2022" */
    public function getPeriodeAttribute(): string
    {
        $selesai = $this->periode_selesai ? self::bulanTahun($this->periode_selesai) : 'Sekarang';

        return self::bulanTahun($this->periode_mulai) . ' – ' . $selesai;
    }
}
