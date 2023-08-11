<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Kunjungan;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class KunjunganController extends Controller
{
    public function __construct ()
    {
        $this->middleware('belum.login')->except(['create', 'store']);
    }

    public function index ()
    {
        return Inertia::render('Kunjungan/Index.vue');
    }

    public function lists (Request $request)
    {
        $start = Carbon::createFromFormat('Y-m-d', $request->start)->startOfDay();
        $end = Carbon::createFromFormat('Y-m-d', $request->end)->endOfDay();
        return Kunjungan::with(['siswa' => function ($query) {
            $query->with(['tingkat', 'kelas']);
        }])
        ->whereDate('created_at', '>=', $start)
        ->whereDate('created_at', '<=', $end)
        ->paginate(15);
    }
    
    public function create (Request $request)
    {
        return Inertia::render('Kunjungan/Create.vue', [
            'nis' => $request->nis
        ]);
    }

    public function store (Request $request)
    {
        $siswa = DB::table('siswa')->where('nis', $request->nis)->first();
        if (!$siswa) {
            return [
                'status' => 'tidak terdaftar',
            ];
        } else {
            Kunjungan::create([
                'siswa_id' => $siswa->id
            ]);
        }
    }

    public function destroy (Kunjungan $kunjungan)
    {
        $kunjungan->delete();
    }

    public function export ()
    {
        $kunjungan = Kunjungan::all();
        $rows = [];
        $nomor = 1;
        foreach ($kunjungan as $row) {
            $rows [] = [
                'nomor' => $nomor,
                'nis'   => $row->siswa->nis,
                'nama'  => $row->siswa->nama,
                'kelas' => $row->siswa->tingkat->nama . ' - ' . $row->siswa->kelas->nama,
                'waktu' => $row->created_at->format('d F Y - H:i')
            ];
            $nomor++;
        }
        return $rows;
    }
}