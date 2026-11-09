<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pendidikan1104 extends Model
{
    protected $table = 'pendidikan_1104';

    protected $fillable = ['biodata_id', 'institusi', 'jurusan', 'tahun_mulai', 'tahun_selesai'];

    public function getRentangAttribute(): string
    {
        return $this->tahun_mulai . ($this->tahun_selesai ? ' – ' . $this->tahun_selesai : ' – Sekarang');
    }
}
