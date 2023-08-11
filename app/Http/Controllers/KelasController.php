<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Kelas;
use Illuminate\Http\Request;

class KelasController extends Controller
{
    public function __construct ()
    {
        $this->middleware('belum.login');
    }
    
    public function index ()
    {
        return Inertia::render('Kelas/Index.vue');
    }

    public function lists (Request $request)
    {
        return Kelas::orderBy('nama', 'asc')->where('nama', 'like', '%' . $request->keyword . '%')->paginate(15);
    }

    public function store (Request $request)
    {
        if (Kelas::where('nama', $request->nama)->first()) {
            return [
                'status' => 'tersedia'
            ];
        } else {
            $kelas = Kelas::create($request->all());
        }
    }

    public function update (Kelas $kelas, Request $request)
    {
        $kelas_db = Kelas::where('id', '!=', $kelas->id)->where('nama', $request->nama)->first();
        if ($kelas_db) {
            return [
                'status' => 'tersedia'
            ];
        } else {
            $kelas->update($request->all());
            if (!$kelas->wasChanged()) {
                return [
                    'status' => 'tidak berubah'
                ];
            }
        }
    }

    public function destroy (Kelas $kelas)
    {
        $siswa_count = $kelas->siswa->count();
        if ($siswa_count > 0) {
            return [
                'relasi' => $siswa_count,
            ];
        } else {
            $kelas->delete();
        }
    }
}
