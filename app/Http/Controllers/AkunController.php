<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AkunController extends Controller
{
    public function index(Request $request)
    {
        $sortBy = $request->input('sortBy', 'newest');
        $users = User::select('id', 'nama_lengkap', 'username', 'role', 'created_at');

        switch ($sortBy) {
            case 'oldest':
                $users = $users->orderBy('created_at', 'asc');
                break;
            case 'name_asc':
                $users = $users->orderBy('nama_lengkap', 'asc');
                break;
            case 'name_desc':
                $users = $users->orderBy('nama_lengkap', 'desc');
                break;
            case 'username_asc':
                $users = $users->orderBy('username', 'asc');
                break;
            case 'username_desc':
                $users = $users->orderBy('username', 'desc');
                break;
            default:
                $users = $users->orderBy('created_at', 'desc');
        }

        $users = $users->get();

        return view('Dashboardstlhlogin.Admin.Akun.Akun', compact('users', 'sortBy'));
    }
} 