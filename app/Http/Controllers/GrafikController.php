<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class GrafikController extends Controller
{
    public $tipe;

    public function __construct ()
    {
        $this->middleware('belum.login');
    }
    
    public function index ()
    {
        return Inertia::render('Grafik/Index.vue');
    }

    public function getTipe ($date)
    {
        if ($this->tipe == 'minggu') {
            return Carbon::parse($date)->startOfWeek()->format('d M y');
        } else if ($this->tipe == 'bulan') {
            return Carbon::parse($date)->startOfMonth()->format('d M y');
        } else {
            return Carbon::parse($date)->startOfYear()->format('d M y');
        }
    }

    public function lists (Request $request)
    {
        $this->tipe = $request->tipe;
        $mulai_tanggal = Carbon::createFromFormat('Y-m-d', $request->mulai_tanggal)->startOfDay();
        $sampai_tanggal = Carbon::createFromFormat('Y-m-d', $request->sampai_tanggal)->endOfDay();

        $peminjaman_umum_db = DB::table('buku_siswa')
        ->whereBetween('created_at', [$mulai_tanggal, $sampai_tanggal])
        ->get()
        ->groupBy(function ($value) {
            return $this->getTipe($value->created_at);
        })->toArray();

        $peminjaman_mapel_db = DB::table('mapel_siswa')
        ->whereBetween('created_at', [$mulai_tanggal, $sampai_tanggal])
        ->get()
        ->groupBy(function ($value) {
            return $this->getTipe($value->created_at);
        })->toArray();

        $kunjungan_db = DB::table('kunjungan')
        ->whereBetween('created_at', [$mulai_tanggal, $sampai_tanggal])
        ->get()
        ->groupBy(function ($value) {
            return $this->getTipe($value->created_at);
        })->toArray();

        $peminjaman_umum = [
            'waktu' => [],
            'count' => []
        ];
        $peminjaman_mapel = [
            'waktu' => [],
            'count' => []
        ];
        $kunjungan = [
            'waktu' => [],
            'count' => []
        ];

        foreach ($peminjaman_umum_db as $key => $row) {
            $peminjaman_umum['waktu'][] = $key;
            $peminjaman_umum['count'][] = count($row);
        }
        foreach ($peminjaman_mapel_db as $key => $row) {
            $peminjaman_mapel['waktu'][] = $key;
            $peminjaman_mapel['count'][] = count($row);
        }
        foreach ($kunjungan_db as $key => $row) {
            $kunjungan['waktu'][] = $key;
            $kunjungan['count'][] = count($row);
        }

        return [
            'peminjaman_umum' => $peminjaman_umum,
            'peminjaman_mapel' => $peminjaman_mapel,
            'kunjungan' => $kunjungan,
        ];
    }
}
