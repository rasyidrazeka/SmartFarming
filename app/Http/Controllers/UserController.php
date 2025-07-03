<?php

namespace App\Http\Controllers;

use App\Models\AccountModel;
use App\Models\RoleModel;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Str;

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
            'user.account.id as account_id',
            'user.account.username',
            'user.account.fullname',
            'user.account.email',
            'user.account.avatar',
            'user.account.is_ban',
            'user.account.urole_id',
            'user.account.created_at',
            'user.account.updated_at',
            'user.account.deleted_at',
            'user.role.name as role_name'
        ])->leftJoin('user.role', 'user.account.urole_id', '=', 'user.role.id')->get();

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

            // ✅ Kolom Aksi
            ->addColumn('aksi', function ($row) {
                $btn = '<div class="text-center d-flex gap-1 justify-content-center">';
                $btn .= '<a href="' . route('kelolaPengguna.show', $row->account_id) . '" class="btn btn-sm btn-info">Show</a>';
                $btn .= '<a href="' . route('kelolaPengguna.edit', $row->account_id) . '" class="btn btn-sm btn-warning">Edit</a>';
                $btn .= '<button class="btn btn-sm btn-danger" onclick="hapusPengguna(\'' . $row->id . '\')">Hapus</button>';
                $btn .= '</div>';
                return $btn;
            })

            ->rawColumns(['avatar', 'is_ban', 'aksi']) // biar HTML badge dan tombol ditampilkan
            ->make(true);
    }

    // public function edit()
    // {
    //     $breadcrumb = (object) [
    //         'title' => 'Kelola Pengguna',
    //         'paragraph' => 'Kelola semua akun pengguna dengan mudah dan efisien. Atur peran, ubah informasi, dan pastikan data tetap terkini.',
    //         'list' => [
    //             ['label' => 'Kelola Pengguna', 'url' => route('kelolaPengguna.index')],
    //             ['label' => 'List'],
    //         ]
    //     ];
    //     $activeMenu = 'kelolaPengguna';
    //     return view('kelola_pengguna.index', compact(
    //         'breadcrumb',
    //         'activeMenu',
    //     ));
    // }

    public function show($id)
    {
        if (!Str::isUuid($id)) {
            abort(404, 'ID tidak valid');
        }

        $breadcrumb = (object) [
            'title' => 'Detail Pengguna',
            'paragraph' => 'Lihat informasi lengkap akun pengguna.',
            'list' => [
                ['label' => 'Kelola Pengguna', 'url' => route('kelolaPengguna.index')],
                ['label' => 'Detail Pengguna'],
            ]
        ];

        $activeMenu = 'kelolaPengguna';

        $user = AccountModel::select([
            'user.account.id as account_id',
            'user.account.username',
            'user.account.fullname',
            'user.account.email',
            'user.account.avatar',
            'user.account.is_ban',
            'user.account.urole_id',
            'user.account.created_at',
            'user.account.updated_at',
            'user.account.deleted_at',
            'user.role.name as role_name'
        ])->leftJoin('user.role', 'user.account.urole_id', '=', 'user.role.id')
            ->where('user.account.id', $id)
            ->first();;

        if (!$user) {
            return abort(404, 'Pengguna tidak ditemukan');
        }

        return view('kelola_pengguna.show', compact(
            'breadcrumb',
            'activeMenu',
            'user',
        ));
    }
}
