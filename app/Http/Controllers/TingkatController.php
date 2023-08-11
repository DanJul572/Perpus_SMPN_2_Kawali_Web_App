<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Tingkat;
use Illuminate\Http\Request;

class TingkatController extends Controller
{
    public function __construct ()
    {
        $this->middleware('belum.login');
    }
    
    public function index ()
    {
        return Inertia::render('Tingkat/Index.vue');
    }

    public function lists (Request $request)
    {
        return Tingkat::orderBy('nama', 'asc')->where('nama', 'like', '%' . $request->keyword . '%')->paginate(15);
    }

    public function store (Request $request)
    {
        if (Tingkat::where('nama', $request->nama)->first()) {
            return [
                'status' => 'tersedia'
            ];
        } else {
            Tingkat::create($request->all());
        }
    }

    public function update (Tingkat $tingkat, Request $request)
    {
        $tingkat_db = Tingkat::where('id', '!=', $tingkat->id)->where('nama', $request->nama)->first();
        if ($tingkat_db) {
            return [
                'status' => 'tersedia'
            ];
        } else {
            $tingkat->update($request->all());
            if (!$tingkat->wasChanged()) {
                return [
                    'status' => 'tidak berubah'
                ];
            }
        }
    }

    public function destroy (Tingkat $tingkat)
    {
        $siswa_count = $tingkat->siswa->count();
        if ($siswa_count > 0) {
            return [
                'relasi' => $siswa_count,
            ];
        } else {
            $tingkat->delete();
        }
    }
}
