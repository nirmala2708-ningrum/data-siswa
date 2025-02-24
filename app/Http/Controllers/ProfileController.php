<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function index()
    {
        // Pastikan file view profile.blade.php ada
        return view('siswa.profile');
    }
}
