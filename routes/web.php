<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'WelcomeController@index')->name('welcome');

Route::group([
    'prefix' => 'dashboard'
], function () {
    Route::get('', 'DashboardController@index')->name('dashboard.index');
    Route::get('user', 'DashboardController@user')->name('dashboard.user');
    Route::get('/lists', 'DashboardController@lists')->name('dashboard.lists');
});

Route::group([
    'prefix' => 'kategori'
], function () {
    Route::get('', 'KategoriController@index')->name('kategori.index');
    Route::get('/lists', 'KategoriController@lists')->name('kategori.lists');
    Route::post('/store', 'KategoriController@store')->name('kategori.store');
    Route::post('/update/{kategori}', 'KategoriController@update')->name('kategori.update');
    Route::get('/destroy/{kategori}', 'KategoriController@destroy')->name('kategori.destroy');
    Route::get('/export', 'KategoriController@export')->name('kategori.export');
});

Route::group([
    'prefix' => 'buku'
], function () {
    Route::get('', 'BukuController@index')->name('buku.index');
    Route::get('/lists', 'BukuController@lists')->name('buku.lists');
    Route::get('/form', 'BukuController@form')->name('buku.form');
    Route::get('/select/{klasifikasi}', 'BukuController@select')->name('buku.select');
    Route::post('/store', 'BukuController@store')->name('buku.store');
    Route::post('/update/{buku}', 'BukuController@update')->name('buku.update');
    Route::get('/destroy/{buku}', 'BukuController@destroy')->name('buku.destroy');
    Route::post('/import', 'BukuController@import')->name('buku.import');
    Route::get('/export', 'BukuController@export')->name('buku.export');
});

Route::group([
    'prefix' => 'mapel'
], function () {
    Route::get('', 'MapelController@index')->name('mapel.index');
    Route::get('/lists', 'MapelController@lists')->name('mapel.lists');
    Route::get('/form', 'MapelController@form')->name('mapel.form');
    Route::get('/select/{klasifikasi}', 'MapelController@select')->name('mapel.select');
    Route::post('/store', 'MapelController@store')->name('mapel.store');
    Route::post('/update/{mapel}', 'MapelController@update')->name('mapel.update');
    Route::get('/destroy/{mapel}', 'MapelController@destroy')->name('mapel.destroy');
    Route::post('/import', 'MapelController@import')->name('mapel.import');
    Route::get('/export', 'MapelController@export')->name('mapel.export');
});

Route::group([
    'prefix' => 'tingkat'
], function () {
    Route::get('', 'TingkatController@index')->name('tingkat.index');
    Route::get('/lists', 'TingkatController@lists')->name('tingkat.lists');
    Route::post('/store', 'TingkatController@store')->name('tingkat.store');
    Route::post('/update/{tingkat}', 'TingkatController@update')->name('tingkat.update');
    Route::get('/destroy/{tingkat}', 'TingkatController@destroy')->name('tingkat.destroy');
});

Route::group([
    'prefix' => 'kelas'
], function () {
    Route::get('', 'KelasController@index')->name('kelas.index');
    Route::get('/lists', 'KelasController@lists')->name('kelas.lists');
    Route::post('/store', 'KelasController@store')->name('kelas.store');
    Route::post('/update/{kelas}', 'KelasController@update')->name('kelas.update');
    Route::get('/destroy/{kelas}', 'KelasController@destroy')->name('kelas.destroy');
});

Route::group([
    'prefix' => 'siswa'
], function () {
    Route::get('', 'SiswaController@index')->name('siswa.index');
    Route::get('/user', 'SiswaController@user')->name('siswa.user');
    Route::get('/lists', 'SiswaController@lists')->name('siswa.lists');
    Route::get('/form', 'SiswaController@form')->name('siswa.form');
    Route::post('/store', 'SiswaController@store')->name('siswa.store');
    Route::post('/update/{siswa}', 'SiswaController@update')->name('siswa.update');
    Route::get('/destroy/{siswa}', 'SiswaController@destroy')->name('siswa.destroy');
    Route::post('/import', 'SiswaController@import')->name('siswa.import');
    Route::get('/buku/{nis}', 'SiswaController@buku')->name('siswa.buku');
    Route::get('/mapel/{nis}', 'SiswaController@mapel')->name('siswa.mapel');
});

Route::group([
    'prefix' => 'peminjaman'
], function () {
    Route::get('', 'PeminjamanController@index')->name('peminjaman.index');
    Route::get('/lists', 'PeminjamanController@lists')->name('peminjaman.lists');
    Route::get('/form', 'PeminjamanController@form')->name('peminjaman.form');
    Route::get('/show/{siswa}', 'PeminjamanController@show')->name('peminjaman.show');
    Route::get('/detail/{siswa}', 'PeminjamanController@detail')->name('peminjaman.detail');
    Route::get('/create/{nis?}', 'PeminjamanController@create')->name('peminjaman.create');
    Route::post('/store/{siswa?}', 'PeminjamanController@store')->name('peminjaman.store');
    Route::post('/destroy/{siswa}', 'PeminjamanController@destroy')->name('peminjaman.destroy');
    Route::get('/return/{nis?}', 'PeminjamanController@return')->name('peminjaman.return');
    Route::post('/returned/{siswa}', 'PeminjamanController@returned')->name('peminjaman.returned');
    Route::get('/export', 'PeminjamanController@export')->name('peminjaman.export');
});

Route::group([
    'prefix' => 'peminjaman_mapel'
], function () {
    Route::get('', 'PeminjamanMapelController@index')->name('peminjaman_mapel.index');
    Route::get('/lists', 'PeminjamanMapelController@lists')->name('peminjaman_mapel.lists');
    Route::get('/form', 'PeminjamanMapelController@form')->name('peminjaman_mapel.form');
    Route::get('/show/{siswa}', 'PeminjamanMapelController@show')->name('peminjaman_mapel.show');
    Route::get('/detail/{siswa}', 'PeminjamanMapelController@detail')->name('peminjaman_mapel.detail');
    Route::get('/create/{nis?}', 'PeminjamanMapelController@create')->name('peminjaman_mapel.create');
    Route::post('/store/{siswa?}', 'PeminjamanMapelController@store')->name('peminjaman_mapel.store');
    Route::post('/destroy/{siswa}', 'PeminjamanMapelController@destroy')->name('peminjaman_mapel.destroy');
    Route::get('/return//{nis?}', 'PeminjamanMapelController@return')->name('peminjaman_mapel.return');
    Route::post('/returned/{siswa}', 'PeminjamanMapelController@returned')->name('peminjaman_mapel.returned');
    Route::get('/export', 'PeminjamanMapelController@export')->name('peminjaman_mapel.export');
});

Route::group([
    'prefix' => 'kunjungan'
], function () {
    Route::get('', 'KunjunganController@index')->name('kunjungan.index');
    Route::get('/lists', 'KunjunganController@lists')->name('kunjungan.lists');
    Route::get('/create/{nis?}', 'KunjunganController@create')->name('kunjungan.create');
    Route::post('/store', 'KunjunganController@store')->name('kunjungan.store');
    Route::get('/destroy/{kunjungan}', 'KunjunganController@destroy')->name('kunjungan.destroy');
    Route::get('/export', 'KunjunganController@export')->name('kunjungan.export');
});

Route::group([
    'prefix' => 'operasi'
], function () {
    Route::get('', 'OperasiController@index')->name('operasi.index');
    Route::get('/lists', 'OperasiController@lists')->name('operasi.lists');
    Route::post('/clean', 'OperasiController@clean')->name('operasi.clean');
    Route::post('/update', 'OperasiController@update')->name('operasi.update');
});

Route::group([
    'prefix' => 'grafik'
], function () {
    Route::get('', 'GrafikController@index')->name('grafik.index');
    Route::get('/lists', 'GrafikController@lists')->name('grafik.lists');
});

Route::group([
    'prefix' => 'admin'
], function () {
    Route::get('/auth', 'AdminController@auth')->name('admin.auth');
    Route::get('/profile', 'AdminController@profile')->name('admin.profile');
    Route::post('/update', 'AdminController@update')->name('admin.update');
    Route::post('/login', 'AdminController@login')->name('admin.login');
    Route::get('/logout', 'AdminController@logout')->name('admin.logout');
});

Route::group([
    'prefix' => 'user'
], function () {
    Route::get('/select', 'UserController@select')->name('user.select');
});
