<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function __construct ()
    {
        $this->middleware('belum.login')->except(['user']);
    }

    public function index ()
    {
        return Inertia::render('Dashboard/Index.vue');
    }
    
    public function user ()
    {
        return Inertia::render('Dashboard/User.vue');
    }

    public function lists () {
        return [
            'kategori' => DB::table('kategori')->count(),
            'buku' => DB::table('buku')->count(),
            'mapel' => DB::table('mapel')->count(),
            'tingkat' => DB::table('tingkat')->count(),
            'kelas' => DB::table('kelas')->count(),
            'siswa' => DB::table('siswa')->count(),
        ];
    }
}
