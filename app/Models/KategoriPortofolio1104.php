<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class KategoriPortofolio1104 extends Model
{
    protected $table = 'kategori_portofolio_1104';

    protected $fillable = ['nama_kategori'];

    public function portofolio(): HasMany
    {
        return $this->hasMany(Portofolio1104::class, 'kategori_id');
    }
}
