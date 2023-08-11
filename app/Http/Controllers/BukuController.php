<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use Inertia\Inertia;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BukuController extends Controller
{
    private $keyword;

    public function __construct ()
    {
        $this->middleware('belum.login')->except(['select']);
    }

    public function index ()
    {
        return Inertia::render('Buku/Index.vue');
    }

    public function lists (Request $request)
    {
        $this->keyword = $request->keyword;
        return Buku::orderBy('nama', 'asc')
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
        $buku_count = Buku::count();
        return [
            'kategori' => $kategori,
            'buku_count' => $buku_count
        ];
    }

    public function select ($klasifikasi)
    {
        $buku = Buku::with(['kategori'])->where('klasifikasi', $klasifikasi)->first();
        if ($buku == null) {
            return [
                'status' => 'tidak ada',
            ];
        }
        $peminjaman = $buku->siswa->where('dikembalikan', false);
        if (count($peminjaman) > 0) {
            return [
                'status' => 'dipinjam',
            ];
        } else {
            return $buku;
        }
    }

    public function store (Request $request)
    {
        if (Buku::where('klasifikasi', $request->klasifikasi)->first()) {
            return [
                'status' => 'tersedia'
            ];
        } else {
            Buku::create($request->all());
        }
    }

    public function update (Buku $buku, Request $request)
    {
        $buku_db = Buku::where('id', '!=', $buku->id)->where('klasifikasi', $request->klasifikasi)->first();
        if ($buku_db) {
            return [
                'status' => 'tersedia'
            ];
        } else {
            $buku->update($request->all());
            if (!$buku->wasChanged()) {
                return [
                    'status' => 'tidak berubah'
                ];
            }
        }
    }

    public function destroy (Buku $buku)
    {
        $siswa_count = $buku->siswa->count();
        if ($siswa_count > 0) {
            return [
                'relasi' => $siswa_count,
            ];
        } else {
            $buku->delete();
        }
    }

    public function import (Request $request)
    {
        $count_berhasil = 0;
        $count_gagal = 0;
        $failed_import = [];
        foreach ($request->rows as $key => $row) {
            if ($key > 0) {
                if (Buku::where('klasifikasi', $row['klasifikasi'])->first()) {
                    $count_gagal ++;
                    $failed_import [] = $row;
                } else {
                    $kategori = Kategori::where('nama', $row['kategori'])->first();
                    if (!$kategori) {
                        $kategori = Kategori::create(['nama' => $row['kategori']]);
                    }
                    Buku::create([
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
            'menu' => 'Banyak Buku',
            'kuantitas' => Buku::count(),
        ];
        $menu_2 = [
            'nomor' => 2,
            'menu' => 'Sedang Dipinjam',
            'kuantitas' => DB::table('buku_siswa')->where('dikembalikan', false)->count(),
        ];
        $menu_3 = [
            'nomor' => 3,
            'menu' => 'Sudah Dikembalikan',
            'kuantitas' => DB::table('buku_siswa')->where('dikembalikan', true)->count(),
        ];
        $menu_4 = [
            'nomor' => 4,
            'menu' => 'Total Peminjaman',
            'kuantitas' => DB::table('buku_siswa')->count(),
        ];
        return [$menu_1, $menu_2, $menu_3, $menu_4];
    }
}
