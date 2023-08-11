<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Kategori;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    public function __construct ()
    {
        $this->middleware('belum.login');
    }
    
    public function index ()
    {
        return Inertia::render('Kategori/Index.vue');
    }

    public function lists (Request $request)
    {
        return Kategori::orderBy('nama', 'asc')->where('nama', 'like', '%' . $request->keyword . '%')->paginate(15);
    }

    public function store (Request $request)
    {
        if (Kategori::where('nama', $request->nama)->first()) {
            return [
                'status' => 'tersedia'
            ];
        } else {
            $kategori = Kategori::create($request->all());
        }
    }

    public function update (Kategori $kategori, Request $request)
    {
        $kategori_db = Kategori::where('id', '!=', $kategori->id)->where('nama', $request->nama)->first();
        if ($kategori_db) {
            return [
                'status' => 'tersedia'
            ];
        } else {
            $kategori->update($request->all());
            if (!$kategori->wasChanged()) {
                return [
                    'status' => 'tidak berubah'
                ];
            }
        }
    }

    public function destroy (Kategori $kategori)
    {
        $buku_count = $kategori->buku->count();
        $mapel_count = $kategori->mapel->count();
        if (($buku_count > 0) || ($mapel_count)) {
            return [
                'relasi' => $buku_count + $mapel_count,
            ];
        } else {
            $kategori->delete();
        }
    }

    public function export ()
    {
        $kategori = Kategori::orderBy('nama', 'asc')->get();
        $nomor = 1;
        $rows = [];
        foreach ($kategori as $row) {
            $rows [] = [
                'nomor' => $nomor,
                'nama' => $row->nama,
                'buku_umum' => $row->buku->count(),
                'buku_mapel' => $row->mapel->count(),
            ];
            $nomor++;
        }
        return $rows;
    }
}
