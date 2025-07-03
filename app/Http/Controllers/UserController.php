<?php

namespace App\Http\Controllers;

use App\Models\AccountModel;
use App\Models\RoleModel;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Kelola Pengguna',
            'paragraph' => 'Kelola semua akun pengguna dengan mudah dan efisien. Atur peran, ubah informasi, dan pastikan data tetap terkini.',
            'list' => [
                ['label' => 'Kelola Pengguna', 'url' => route('kelolaPengguna.index')],
                ['label' => 'List'],
            ]
        ];

        $roles = RoleModel::select([
            'user.role.*'
        ])->get();

        $activeMenu = 'kelolaPengguna';
        return view('kelola_pengguna.index', compact(
            'breadcrumb',
            'activeMenu',
            'roles',
        ));
    }

    public function list(Request $request)
    {
        $user = AccountModel::select([
            'user.account.*',
            'user.role.name as role_name'
        ])->leftJoin('user.role', 'user.account.urole_id', '=', 'user.role.id');

        if ($request->role) {
            $user->whereHas('role', function ($query) use ($request) {
                $query->where('code', $request->role); // sesuaikan jika role disimpan di kolom lain seperti 'name'
            });
        }

        return DataTables::of($user)
            ->addIndexColumn()

            // ->editColumn('username', fn($row) => $row->username ?? '-')
            // ->editColumn('email', fn($row) => $row->email ?? '-')
            ->editColumn('fullname', fn($row) => $row->fullname ?? '-')

            ->editColumn(
                'avatar',
                fn($row) =>
                $row->avatar
                    ? '<span class="badge bg-success">Tersedia</span>'
                    : '<span class="badge bg-secondary">Tidak Ada</span>'
            )

            ->editColumn(
                'is_ban',
                fn($row) =>
                $row->is_ban
                    ? '<span class="badge bg-danger">Banned</span>'
                    : '<span class="badge bg-success">Aktif</span>'
            )

            ->addColumn('role_name', fn($row) => optional($row->role)->name ?? '-')

            // ->editColumn(
            //     'created_at',
            //     fn($row) =>
            //     $row->created_at ? $row->created_at->format('d-m-Y H:i:s') : '-'
            // )

            // ✅ Kolom Aksi
            ->addColumn('aksi', function ($row) {
                return '
                <div class="text-center d-flex gap-1 justify-content-center">
                    <a href="' . route('kelolaPengguna.show', $row->id) . '" class="btn btn-sm btn-info">Show</a>
                    <a href="' . route('kelolaPengguna.edit', $row->id) . '" class="btn btn-sm btn-warning">Edit</a>
                    <button class="btn btn-sm btn-danger" onclick="hapusPengguna(\'' . $row->id . '\')">Hapus</button>
                </div>';
            })

            ->rawColumns(['avatar', 'is_ban', 'aksi']) // biar HTML badge dan tombol ditampilkan
            ->make(true);
    }

    public function edit()
    {
        $breadcrumb = (object) [
            'title' => 'Kelola Pengguna',
            'paragraph' => 'Kelola semua akun pengguna dengan mudah dan efisien. Atur peran, ubah informasi, dan pastikan data tetap terkini.',
            'list' => [
                ['label' => 'Kelola Pengguna', 'url' => route('kelolaPengguna.index')],
                ['label' => 'List'],
            ]
        ];
        $activeMenu = 'kelolaPengguna';
        return view('kelola_pengguna.index', compact(
            'breadcrumb',
            'activeMenu',
        ));
    }
}
