<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use Inertia\Inertia;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class PeminjamanController extends Controller
{
    public function __construct ()
    {
        $this->middleware('belum.login')->except(['store', 'create', 'return', 'returned']);
    }
    
    public function index ()
    {
        return Inertia::render('Peminjaman/Index.vue');
    }

    public function lists (Request $request)
    {
        return Siswa::orderBy('nama', 'asc')
        ->with(['tingkat', 'kelas'])
        ->withCount([
            'buku as total',
            'buku as terlambat' => function ($query) {
                $query->whereDate('buku_siswa.tenggat', '<', Carbon::now()->endOfDay()->format('Y-m-d'))->where('dikembalikan', false);
            },
            'buku as hari_ini' => function ($query) {
                $query->whereDate('buku_siswa.tenggat', Carbon::now()->endOfDay()->format('Y-m-d'))->where('dikembalikan', false);
            },
            'buku as selesai' => function ($query) {
                $query->where('dikembalikan', true);
            },
        ])
        ->where('nama', 'like', '%' . $request->keyword . '%')
        ->where('tingkat_id', $request->tingkat_id)
        ->where('kelas_id', $request->kelas_id)
        ->paginate(15);
    }

    public function form ()
    {
        $tingkat = DB::table('tingkat')->orderBy('nama', 'asc')->get();
        $kelas = DB::table('kelas')->orderBy('nama', 'asc')->get();
        return [
            'tingkat' => $tingkat,
            'kelas' => $kelas
        ];
    }

    public function show (Siswa $siswa)
    {
        return Inertia::render('Peminjaman/Detail.vue', [
            'id' => $siswa->id
        ]);
    }

    public function detail (Siswa $siswa)
    {
        return [
            'siswa' => $siswa->toArray(),
            'tingkat' => $siswa->tingkat->toArray(),
            'kelas' => $siswa->kelas->toArray(),
            'buku' => $siswa->buku()->with(['kategori'])->get(),
            'keterangan' => $siswa->keterangan,
            'denda' => DB::table('operasi')->select('denda_per_hari')->first()
        ];
    }

    public function create (Request $request)
    {
        return Inertia::render('Peminjaman/Create.vue', [
            'nis' => $request->nis
        ]);
    }

    public function store (Request $request, Siswa $siswa)
    {
        if ($request->nis) {
            $siswa = Siswa::where('nis', $request->nis)->first();
            if (!$siswa) {
                return [
                    'status' => 'siswa tidak ada'
                ];
            } else {
                $dipinjam = [];
                $tenggat = Carbon::createFromFormat('Y-m-d', $request->tenggat);
                foreach ($request->buku as $buku) {
                    $dipinjam [$buku['id']] = [
                        'tenggat' => $tenggat,
                        'dikembalikan' => false,
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now(),
                    ];
                }
                $siswa->buku()->attach($dipinjam);
            }
        } else {
            $buku = Buku::where('klasifikasi', $request->klasifikasi)->first();
            if (!$buku) {
                return [
                    'status' => 'buku tidak ada'
                ];
            }
            $peminjaman = $buku->siswa->where('dikembalikan', false);
            if (count($peminjaman) > 0) {
                return [
                    'status' => 'terpinjam'
                ];
            }
            $tenggat = Carbon::createFromFormat('Y-m-d', $request->tenggat);
            $siswa->buku()->attach($buku->id, [
                'tenggat' => $tenggat,
                'dikembalikan' => false,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
    }

    public function return (Request $request)
    {
        return Inertia::render('Peminjaman/Return.vue', [
            'nis' => $request->nis
        ]);
    }

    public function destroy (Request $request, Siswa $siswa)
    {
        $siswa->buku()->wherePivot('id', $request->peminjaman_id)->detach();
    }

    public function returned (Request $request, Siswa $siswa)
    {
        $siswa->buku()->wherePivot('id', $request->peminjaman_id)->update(['dikembalikan' => true]);
    }

    public function export ()
    {
        $siswa = Siswa::whereHas('buku')->get();
        $nomor = 1;
        $rows = [];
        foreach ($siswa as $row_1) {
            $peminjaman = $row_1->buku;
            foreach ($peminjaman as $row_2) {
                $string_status = '';
                if ($row_2->pivot->dikembalikan == true) {
                    $string_status = 'Sudah Dikembalikan';
                } else {
                    $string_status = 'Belum Dikembalikan';
                }
                $rows [] = [
                    'nomor' => $nomor,
                    'nis' => $row_1->nis,
                    'nama' => $row_1->nama,
                    'kelas' =>  $row_1->tingkat->nama . ' - ' . $row_1->kelas->nama,
                    'nama_buku' => $row_2->nama,
                    'klasifikasi' => $row_2->klasifikasi,
                    'tenggat' => $row_2->pivot->tenggat,
                    'status' => $string_status
                ];
                $nomor++;
            }
        }
        return $rows;
    }
}
