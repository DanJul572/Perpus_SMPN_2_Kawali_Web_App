<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tingkat extends Model
{
    protected $table = 'tingkat';
    protected $fillable = ['nama'];

    public function siswa ()
    {
        return $this->hasMany(Siswa::class);
    }
}
