<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AkunController extends Controller
{
    public function index()
    {
        $users = User::select('id', 'nama_lengkap', 'username', 'role', 'created_at')
                    ->orderBy('created_at', 'desc')
                    ->get();

        return view('Dashboardstlhlogin.Admin.Akun.Akun', compact('users'));
    }
} 