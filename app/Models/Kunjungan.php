<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kunjungan extends Model
{
    protected $table = 'kunjungan';
    protected $fillable = ['siswa_id'];

    public function siswa ()
    {
        return $this->belongsTo(Siswa::class);
    }
}
