<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Biodata1104 extends Model
{
    protected $table = 'biodata_1104';

    protected $fillable = [
        'nama_lengkap', 'posisi', 'email', 'telepon', 'alamat',
        'tentang_saya', 'foto', 'tampilkan_foto',
    ];

    protected function casts(): array
    {
        return ['tampilkan_foto' => 'boolean'];
    }

    public function pendidikan(): HasMany
    {
        return $this->hasMany(Pendidikan1104::class, 'biodata_id')->orderByDesc('tahun_mulai');
    }

    public function portofolio(): HasMany
    {
        return $this->hasMany(Portofolio1104::class, 'biodata_id')->orderByDesc('periode_mulai');
    }

    public function kemampuan(): HasMany
    {
        return $this->hasMany(Kemampuan1104::class, 'biodata_id')->orderBy('id');
    }

    public function getFotoUrlAttribute(): ?string
    {
        return $this->foto ? asset('uploads/cv/' . $this->foto) : null;
    }
}
