<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function select ()
    {
        return Inertia::render('User/Select.vue');
    }
}
