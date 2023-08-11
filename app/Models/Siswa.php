<?php

namespace App\Models;

use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    protected $table = 'siswa';
    protected $fillable = ['nis', 'nama', 'tingkat_id', 'kelas_id', 'password'];

    public function buku ()
    {
        return $this->belongsToMany(Buku::class)->withPivot(['id', 'tenggat', 'dikembalikan', 'created_at']);
    }

    public function mapel ()
    {
        return $this->belongsToMany(Mapel::class)->withPivot(['id', 'tenggat', 'dikembalikan', 'created_at']);
    }

    public function kunjungan ()
    {
        return $this->hasMany(Kunjungan::class);
    }

    public function tingkat ()
    {
        return $this->belongsTo(Tingkat::class);
    }

    public function kelas ()
    {
        return $this->belongsTo(Kelas::class);
    }

    public function getKeteranganAttribute ()
    {
        $now = Carbon::now()->endOfDay()->format('Y-m-d');
        return [
            'terlambat' => $this->buku()->whereDate('buku_siswa.tenggat', '<', $now)->where('dikembalikan', false)->count(),
            'hari_ini' => $this->buku()->whereDate('buku_siswa.tenggat', $now)->where('dikembalikan', false)->count(),
            'selesai' => $this->buku()->where('dikembalikan', true)->count(),
            'total' => $this->buku()->count()
        ];
    }

    public function getKeteranganMapelAttribute ()
    {
        $now = Carbon::now()->endOfDay()->format('Y-m-d');
        return [
            'terlambat' => $this->mapel()->whereDate('mapel_siswa.tenggat', '<', $now)->where('dikembalikan', false)->count(),
            'hari_ini' => $this->mapel()->whereDate('mapel_siswa.tenggat', $now)->where('dikembalikan', false)->count(),
            'selesai' => $this->mapel()->where('dikembalikan', true)->count(),
            'total' => $this->mapel()->count()
        ];
    }
}
