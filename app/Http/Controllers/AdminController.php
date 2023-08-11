<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Admin;
use Illuminate\Support\Str;
use App\Events\ImageProcess;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function __construct ()
    {
        $this->middleware('sudah.login')->except(['logout', 'profile', 'update']);
        $this->middleware('belum.login')->except(['auth', 'login']);
    }

    public function auth ()
    {
        return Inertia::render('Auth/Admin.vue');
    }

    public function profile ()
    {
        return Inertia::render('Admin/Profile.vue');
    }

    public function update (Request $request)
    {
        $admin = Admin::find(session('admin')['id']);
        if ($request->avatar != null) {
            $file_name = Str::random() . '.jpg';
            event(new ImageProcess('', 'app/main/image/profile/', $admin->avatar, 'destroy'));
            event(new ImageProcess($request->avatar, 'app/main/image/profile/', $file_name, 'put'));
        } else {
            $file_name = $admin->avatar;
        }
        $admin->update([
            'name' => $request->name,
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'avatar' => $file_name
        ]);
        session()->forget('admin');
        session()->put('admin', $admin);
    }

    public function login(Request $request)
    {
        $admin = Admin::first();
        if ((Hash::check($request->password, $admin->password)) && ($admin->username == $request->username)) {
            session()->put('admin', $admin);
            return redirect()->route('dashboard.index');
        } else {
            return redirect()->route('admin.auth')->with('message', [
                'class' => 'alert text-center shadow pl-0 alert-danger',
                'message' => 'Username atau Password salah',
            ]);
        }
    }

    public function logout()
    {
        session()->forget('admin');
        return redirect()->route('admin.auth')->with('message', [
            'class' => 'alert text-center shadow pl-0 alert-success',
            'message' => 'Anda berhasil logout',
        ]);
    }
}
