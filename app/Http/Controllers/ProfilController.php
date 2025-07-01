<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProfilController extends Controller
{
    public function index()
    {

        $breadcrumb = (object) [
            'title' => 'User Profile',
            'paragraph' => 'Selamat datang di halaman profil. Berikut informasi akun Anda yang terdaftar.',
            'list' => [
                ['label' => 'Profil', 'url' => route('profil.index')],
                ['label' => session('nama')],
            ]
        ];
        $activeMenu = 'profil';
        $user = session('user');
        return view('profil.index', compact(
            'breadcrumb',
            'activeMenu',
            'user',
        ));
    }
}
