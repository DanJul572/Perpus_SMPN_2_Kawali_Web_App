<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    protected $table = 'kategori';
    protected $fillable = ['nama'];

    public function buku ()
    {
        return $this->hasMany(Buku::class);
    }

    public function mapel ()
    {
        return $this->hasMany(Mapel::class);
    }
}
