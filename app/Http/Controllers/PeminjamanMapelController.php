<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Mapel;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class PeminjamanMapelController extends Controller
{
    public function __construct ()
    {
        $this->middleware('belum.login')->except(['store', 'create', 'return', 'returned']);
    }
    
    public function index ()
    {
        return Inertia::render('PeminjamanMapel/Index.vue');
    }

    public function lists (Request $request)
    {
        return Siswa::orderBy('nama', 'asc')
        ->with(['tingkat', 'kelas'])
        ->withCount([
            'mapel as total',
            'mapel as terlambat' => function ($query) {
                $query->whereDate('mapel_siswa.tenggat', '<', Carbon::now()->endOfDay()->format('Y-m-d'))->where('dikembalikan', false);
            },
            'mapel as hari_ini' => function ($query) {
                $query->whereDate('mapel_siswa.tenggat', Carbon::now()->endOfDay()->format('Y-m-d'))->where('dikembalikan', false);
            },
            'mapel as selesai' => function ($query) {
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
        return Inertia::render('PeminjamanMapel/Detail.vue', [
            'id' => $siswa->id
        ]);
    }

    public function detail (Siswa $siswa)
    {
        return [
            'siswa' => $siswa->toArray(),
            'tingkat' => $siswa->tingkat->toArray(),
            'kelas' => $siswa->kelas->toArray(),
            'mapel' => $siswa->mapel()->with(['kategori'])->get(),
            'keterangan' => $siswa->keterangan,
            'denda' => DB::table('operasi')->select('denda_per_hari')->first()
        ];
    }

    public function create (Request $request)
    {
        return Inertia::render('PeminjamanMapel/Create.vue', [
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
                foreach ($request->mapel as $mapel) {
                    $dipinjam [$mapel['id']] = [
                        'tenggat' => $tenggat,
                        'dikembalikan' => false,
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now(),
                    ];
                }
                $siswa->mapel()->attach($dipinjam);
            }
        } else {
            $mapel = Mapel::where('klasifikasi', $request->klasifikasi)->first();
            if (!$mapel) {
                return [
                    'status' => 'mapel tidak ada'
                ];
            }
            $peminjaman = $mapel->siswa->where('dikembalikan', false);
            if (count($peminjaman) > 0) {
                return [
                    'status' => 'terpinjam'
                ];
            }
            $tenggat = Carbon::createFromFormat('Y-m-d', $request->tenggat);
            $siswa->mapel()->attach($mapel->id, [
                'tenggat' => $tenggat,
                'dikembalikan' => false,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
    }

    public function return (Request $request)
    {
        return Inertia::render('PeminjamanMapel/Return.vue', [
            'nis' => $request->nis
        ]);
    }

    public function destroy (Request $request, Siswa $siswa)
    {
        $siswa->mapel()->wherePivot('id', $request->peminjaman_id)->detach();
    }

    public function returned (Request $request, Siswa $siswa)
    {
        $siswa->mapel()->wherePivot('id', $request->peminjaman_id)->update(['dikembalikan' => true]);
    }

    public function export ()
    {
        $siswa = Siswa::whereHas('mapel')->get();
        $nomor = 1;
        $rows = [];
        foreach ($siswa as $row_1) {
            $peminjaman = $row_1->mapel;
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
                    'nama_mapel' => $row_2->nama,
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
