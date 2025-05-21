<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Dashboard',
            'paragraph' => 'Pusat informasi kondisi greenhouse Anda secara menyeluruh',
            'list' => [
                ['label' => 'Dashboard'],
            ]
        ];
        $activeMenu = 'dashboard';
        return view('dashboard.index', compact(
            'breadcrumb',
            'activeMenu',
        ));
    }
}
