<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mapel extends Model
{
    protected $table = 'mapel';
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
