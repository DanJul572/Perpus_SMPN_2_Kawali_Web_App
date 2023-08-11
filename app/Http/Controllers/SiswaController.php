<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Kelas;
use App\Models\Siswa;
use App\Models\Tingkat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SiswaController extends Controller
{
    public function __construct ()
    {
        $this->middleware('belum.login')->except(['lists', 'user', 'form', 'buku', 'mapel']);
    }
    
    public function index ()
    {
        return Inertia::render('Siswa/Index.vue');
    }

    public function user ()
    {
        return Inertia::render('Siswa/User.vue');
    }

    public function lists (Request $request)
    {
        return Siswa::orderBy('nama', 'asc')
        ->with(['tingkat', 'kelas'])
        ->where('nama', 'like', '%' . $request->keyword . '%')
        ->where('tingkat_id', $request->tingkat_id)
        ->where('kelas_id', $request->kelas_id)
        ->paginate(15);
    }

    public function form ()
    {
        $tingkat = Tingkat::orderBy('nama', 'asc')->get();
        $kelas = Kelas::orderBy('nama', 'asc')->get();
        $siswa_count = Siswa::count();
        return [
            'tingkat' => $tingkat,
            'kelas' => $kelas,
            'siswa_count' => $siswa_count
        ];
    }

    public function store (Request $request)
    {
        if (Siswa::where('nis', $request->nis)->first()) {
            return [
                'status' => 'tersedia'
            ];
        } else {
            Siswa::create($request->all());
        }
    }

    public function update (Siswa $siswa, Request $request)
    {
        $siswa_db = Siswa::where('id', '!=', $siswa->id)->where('nis', $request->nis)->first();
        if ($siswa_db) {
            return [
                'status' => 'tersedia'
            ];
        } else {
            $siswa->update($request->all());
            if (!$siswa->wasChanged()) {
                return [
                    'status' => 'tidak berubah'
                ];
            }
        }
    }

    public function destroy (Siswa $siswa)
    {
        $buku_count = $siswa->buku->count();
        $kunjungan_count = $siswa->kunjungan->count();
        if ($buku_count > 0) {
            return [
                'nama_relasi' => 'buku',
                'banyak_relasi' => $buku_count,
            ];
        } else if ($kunjungan_count > 0) {
            return [
                'nama_relasi' => 'kunjungan',
                'banyak_relasi' => $kunjungan_count,
            ];
        } else {
            $siswa->delete();
        }
    }

    public function import (Request $request)
    {
        $count_berhasil = 0;
        $count_gagal = 0;
        $failed_import  = [];
        foreach ($request->rows as $key => $row) {
            if ($key > 0) {
                if (Siswa::where('nis', $row['nis'])->first()) {
                    $count_gagal ++;
                    $failed_import [] = $row;
                } else {
                    $tingkat = Tingkat::where('nama', $row['tingkat'])->first();
                    if (!$tingkat) {
                        $tingkat = Tingkat::create(['nama' => $row['tingkat']]);
                    }
                    $kelas = Kelas::where('nama', $row['kelas'])->first();
                    if (!$kelas) {
                        $kelas = Kelas::create(['nama' => $row['kelas']]);
                    }
                    Siswa::create([
                        'nis' => $row['nis'],
                        'nama' => $row['nama'],
                        'password' => $row['password'],
                        'tingkat_id' => $tingkat->id,
                        'kelas_id' => $kelas->id,
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

    public function buku ($nis)
    {
        $siswa = Siswa::where('nis', $nis)->first();
        if (!$siswa) {
            return [
                'status' => 'tidak ada'
            ];
        } else {
            return [
                'buku' => $siswa->buku()->with(['kategori'])->where('dikembalikan', false)->get(),
                'siswa' => $siswa
            ];
        }
    }

    public function mapel ($nis)
    {
        $siswa = Siswa::where('nis', $nis)->first();
        if (!$siswa) {
            return [
                'status' => 'tidak ada'
            ];
        } else {
            return [
                'mapel' => $siswa->mapel()->with(['kategori'])->where('dikembalikan', false)->get(),
                'siswa' => $siswa
            ];
        }
    }
}
