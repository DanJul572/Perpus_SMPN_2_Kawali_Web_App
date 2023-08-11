<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use Inertia\Inertia;
use App\Models\Kelas;
use App\Models\Mapel;
use App\Models\Siswa;
use App\Models\Operasi;
use App\Models\Tingkat;
use App\Models\Kategori;
use App\Models\Kunjungan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OperasiController extends Controller
{
    public function __construct ()
    {
        $this->middleware('belum.login');
    }
    
    public function index ()
    {
        return Inertia::render('Operasi/Index.vue');
    }

    public function update (Request $request)
    {
        $operasi = Operasi::first();
        $operasi->update($request->all());
        if (!$operasi->wasChanged()) {
            return [
                'status' => 'tidak berubah'
            ];
        }
    }

    public function clean (Request $request)
    {
        $type = $request->type;
        if ($type == 'kategori') {
            $count = Kategori::doesntHave('buku')->doesntHave('mapel')->count();
            $data = Kategori::doesntHave('buku')->doesntHave('mapel')->delete();
        } else if ($type == 'buku') {
            $count = Buku::doesntHave('siswa')->count();
            $data = Buku::doesntHave('siswa')->delete();
        } else if ($type == 'mapel') {
            $count = Mapel::doesntHave('siswa')->count();
            $data = Mapel::doesntHave('siswa')->delete();
        } else if ($type == 'tingkat') {
            $count = Tingkat::doesntHave('siswa')->count();
            $data = Tingkat::doesntHave('siswa')->delete();
        } else if ($type == 'kelas') {
            $count = Kelas::doesntHave('siswa')->count();
            $data = Kelas::doesntHave('siswa')->delete();
        } else if ($type == 'siswa') {
            $count = Siswa::doesntHave('buku')->doesntHave('mapel')->doesntHave('kunjungan')->count();
            $data = Siswa::doesntHave('buku')->doesntHave('mapel')->doesntHave('kunjungan')->delete();
        } else if ($type == 'peminjaman') {
            $count = DB::table('buku_siswa')->count();
            $data = DB::table('buku_siswa')->truncate();
        } else if ($type == 'peminjaman terkonfirmasi') {
            $count = DB::table('buku_siswa')->where('dikembalikan', true)->count();
            $data = DB::table('buku_siswa')->where('dikembalikan', true)->delete();
        } else if ($type == 'peminjaman_mapel') {
            $count = DB::table('mapel_siswa')->count();
            $data = DB::table('mapel_siswa')->truncate();
        } else if ($type == 'peminjaman_mapel terkonfirmasi') {
            $count = DB::table('mapel_siswa')->where('dikembalikan', true)->count();
            $data = DB::table('mapel_siswa')->where('dikembalikan', true)->delete();
        } else if ($type == 'kunjungan') {
            $count = Kunjungan::count();
            $data = Kunjungan::truncate();
        } else if ($type == 'semua') {
            $data = DB::table('kategori')->truncate();
            $data = DB::table('buku')->truncate();
            $data = DB::table('mapel')->truncate();
            $data = DB::table('tingkat')->truncate();
            $data = DB::table('kelas')->truncate();
            $data = DB::table('siswa')->truncate();
            $data = DB::table('buku_siswa')->truncate();
            $data = DB::table('mapel_siswa')->truncate();
            $data = DB::table('kunjungan')->truncate();
            $count = 'Semua';
        }
        return [
            'terhapus' => $count
        ];
    }

    public function lists ()
    {
        return Operasi::first();
    }
}
