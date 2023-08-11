<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Buku extends Model
{
    protected $table = 'buku';
    protected $fillable = ['nama', 'klasifikasi', 'rak', 'kategori_id'];

    public function kategori ()
    {
        return $this->belongsTo(Kategori::class);
    }

    public function siswa ()
    {
        return $this->belongsToMany(Siswa::class)->withPivot(['dikembalikan', 'tenggat']);
    }
}
