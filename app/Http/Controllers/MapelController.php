<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Mapel;
use App\Models\Tingkat;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MapelController extends Controller
{
    private $keyword;

    public function __construct ()
    {
        $this->middleware('belum.login')->except(['select']);
    }

    public function index ()
    {
        return Inertia::render('Mapel/Index.vue');
    }

    public function lists (Request $request)
    {
        $this->keyword = $request->keyword;
        return Mapel::orderBy('nama', 'asc')
        ->with(['kategori'])
        ->where('nama', 'like', '%' . $this->keyword . '%')
        ->orWhere('klasifikasi', 'like', '%' . $this->keyword . '%')
        ->orWhere('rak', 'like', '%' . $this->keyword . '%')
        ->orWhereHas('kategori', function ($query) {
            $query->where('nama', 'like', '%' . $this->keyword . '%');
        })
        ->paginate(15);
    }

    public function form ()
    {
        $kategori = Kategori::orderBy('nama', 'asc')->get();
        $mapel_count = Mapel::count();
        return [
            'kategori' => $kategori,
            'mapel_count' => $mapel_count
        ];
    }

    public function select ($klasifikasi)
    {
        $mapel = Mapel::with(['kategori'])->where('klasifikasi', $klasifikasi)->first();
        if ($mapel == null) {
            return [
                'status' => 'tidak ada',
            ];
        }
        $peminjaman = $mapel->siswa->where('dikembalikan', false);
        if (count($peminjaman) > 0) {
            return [
                'status' => 'dipinjam',
            ];
        } else {
            return $mapel;
        }
    }

    public function store (Request $request)
    {
        if (Mapel::where('klasifikasi', $request->klasifikasi)->first()) {
            return [
                'status' => 'tersedia'
            ];
        } else {
            Mapel::create($request->all());
        }
    }

    public function update (Mapel $Mapel, Request $request)
    {
        $mapel_db = Mapel::where('id', '!=', $mapel->id)->where('klasifikasi', $request->klasifikasi)->first();
        if ($mapel_db) {
            return [
                'status' => 'tersedia'
            ];
        } else {
            $mapel->update($request->all());
            if (!$mapel->wasChanged()) {
                return [
                    'status' => 'tidak berubah'
                ];
            }
        }
    }

    public function destroy (Mapel $Mapel)
    {
        $siswa_count = $mapel->siswa->count();
        if ($siswa_count > 0) {
            return [
                'relasi' => $siswa_count,
            ];
        } else {
            $mapel->delete();
        }
    }

    public function import (Request $request)
    {
        $count_berhasil = 0;
        $count_gagal = 0;
        $failed_import = [];
        foreach ($request->rows as $key => $row) {
            if ($key > 0) {
                if (Mapel::where('klasifikasi', $row['klasifikasi'])->first()) {
                    $count_gagal ++;
                    $failed_import [] = $row;
                } else {
                    $kategori = Kategori::where('nama', $row['kategori'])->first();
                    if (!$kategori) {
                        $kategori = Kategori::create(['nama' => $row['kategori']]);
                    }
                    Mapel::create([
                        'klasifikasi' => $row['klasifikasi'],
                        'nama' => $row['nama'],
                        'rak' => $row['rak'],
                        'kategori_id' => $kategori->id,
                    ]);
                    $count_berhasil ++;
                }
            }
        }
        return [
            'count_berhasil' => $count_berhasil,
            'count_gagal' => $count_gagal,
            'failed_import' => $failed_import
        ];
    }

    public function export ()
    {
        $nomor = 1;
        $rows = [];
        $menu_1 = [
            'nomor' => 1,
            'menu' => 'Banyak Mapel',
            'kuantitas' => Mapel::count(),
        ];
        $menu_2 = [
            'nomor' => 2,
            'menu' => 'Sedang Dipinjam',
            'kuantitas' => DB::table('mapel_siswa')->where('dikembalikan', false)->count(),
        ];
        $menu_3 = [
            'nomor' => 3,
            'menu' => 'Sudah Dikembalikan',
            'kuantitas' => DB::table('mapel_siswa')->where('dikembalikan', true)->count(),
        ];
        $menu_4 = [
            'nomor' => 4,
            'menu' => 'Total Peminjaman',
            'kuantitas' => DB::table('mapel_siswa')->count(),
        ];
        return [$menu_1, $menu_2, $menu_3, $menu_4];
    }
}
