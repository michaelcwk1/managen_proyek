<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function dashboard()
    {
        return view('user.dashboard'); // Pastikan kamu sudah membuat view untuk user
    }
}
