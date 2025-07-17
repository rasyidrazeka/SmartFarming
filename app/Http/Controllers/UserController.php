<?php

namespace App\Http\Controllers;

use App\Models\AccountModel;
use App\Models\RoleModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Validation\Rule;


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
            'user.role.code as role_code',
            'user.role.name as role_name'
        ])->leftJoin('user.role', 'user.account.urole_id', '=', 'user.role.id');

        if ($request->role) {
            $user->whereHas('role', function ($query) use ($request) {
                $query->where('code', $request->role); // sesuaikan jika role disimpan di kolom lain seperti 'name'
            });
        }

        if ($request->filled('is_ban') && in_array($request->is_ban, ['0', '1'])) {
            $user->where('user.account.is_ban', $request->is_ban);
        }


        return DataTables::of($user)
            ->addIndexColumn()

            // ->editColumn('username', fn($row) => $row->username ?? '-')
            ->editColumn('email', fn($row) => $row->email ?? '-')
            ->editColumn('fullname', fn($row) => $row->fullname ?? '-')

            // ->editColumn(
            //     'avatar',
            //     fn($row) =>
            //     $row->avatar
            //         ? '<span class="badge bg-success">Tersedia</span>'
            //         : '<span class="badge bg-secondary">Tidak Ada</span>'
            // )

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
                $btn .= '<a href="' . route('kelolaPengguna.show', $row->username) . '" class="btn btn-sm btn-info">Detail</a>';
                $btn .= '<a href="' . route('kelolaPengguna.edit', $row->username) . '" class="btn btn-sm btn-warning">Ubah</a>';

                if ($row->is_ban) {
                    $btn .= '<button class="btn btn-sm btn-success" onclick="ubahStatusBlokir(\'' . $row->username . '\', false)">Buka Blokir</button>';
                } else {
                    $btn .= '<button class="btn btn-sm btn-danger" onclick="ubahStatusBlokir(\'' . $row->username . '\', true)">Blokir</button>';
                }

                $btn .= '</div>';
                return $btn;
            })

            ->rawColumns(['avatar', 'is_ban', 'aksi']) // biar HTML badge dan tombol ditampilkan
            ->make(true);
    }

    public function create()
    {
        $breadcrumb = (object) [
            'title' => 'Tambah Pengguna',
            'paragraph' => 'Masukkan data pengguna baru dengan lengkap untuk proses registrasi akun.',
            'list' => [
                ['label' => 'Kelola Pengguna', 'url' => route('kelolaPengguna.index')],
                ['label' => 'Tambah Pengguna'],
            ]
        ];

        $roles = RoleModel::select([
            'user.role.id as role_id',
            'user.role.code as role_code',
            'user.role.name as role_name',
            'user.role.created_at as role_createdAt',
            'user.role.updated_at as role_updatedAt',
        ])->get();

        $activeMenu = 'kelolaPengguna';
        return view('kelola_pengguna.create', compact(
            'breadcrumb',
            'activeMenu',
            'roles',
        ));
    }

    public function store(Request $request)
    {
        $token = session('token');
        if (!$token) {
            return back()->withErrors(['message' => 'Token tidak ditemukan. Silakan login ulang.']);
        }

        $validator = Validator::make($request->all(), [
            'username' => ['required', 'string'],
            'fullname' => ['required', 'string'],
            'email' => ['required', 'email'],
        ]);

        if (DB::table('user.account')->where('username', $request->username)->exists()) {
            $validator->errors()->add('username', 'Username sudah digunakan.');
        }

        if (DB::table('user.account')->where('fullname', $request->fullname)->exists()) {
            $validator->errors()->add('fullname', 'Fullname sudah digunakan.');
        }

        if (DB::table('user.account')->where('email', $request->email)->exists()) {
            $validator->errors()->add('email', 'Email sudah digunakan.');
        }

        // Ambil semua data request dan tambahkan frontend_url
        $data = $request->all();
        $data = $request->except('_token');
        $data['frontend_url'] = url('http://labai.polinema.ac.id:5020');

        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token, // ⬅️ pastikan format benar!
                'Accept' => 'application/json',
            ])->asJson()->post('http://labai.polinema.ac.id:3042/api/admin/users', $data);

            if ($response->successful()) {
                Alert::toast('Data pengguna berhasil ditambah', 'success');
                return redirect()->route('kelolaPengguna.index');
            } else {
                Alert::toast('Email, nama, atau username sudah digunakan', 'error');
                return back()->withInput();
            }
        } catch (\Exception $e) {
            return back()->withErrors([
                'message' => 'Terjadi kesalahan saat menghubungi API.',
                'error' => $e->getMessage(),
            ])->withInput();
        }
    }

    public function show($username)
    {
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
            ->where('user.account.username', $username)
            ->first();

        return view('kelola_pengguna.show', compact(
            'breadcrumb',
            'activeMenu',
            'user',
        ));
    }

    public function edit($username)
    {
        $breadcrumb = (object) [
            'title' => 'Edit Pengguna',
            'paragraph' => 'Perbarui informasi akun pengguna untuk memastikan data tetap akurat dan terkini.',
            'list' => [
                ['label' => 'Kelola Pengguna', 'url' => route('kelolaPengguna.index')],
                ['label' => 'List'],
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
            ->where('user.account.username', $username)
            ->first();

        $roles = RoleModel::select([
            'user.role.id as role_id',
            'user.role.code as role_code',
            'user.role.name as role_name',
            'user.role.created_at as role_createdAt',
            'user.role.updated_at as role_updatedAt',
        ])->get();

        return view('kelola_pengguna.edit', compact(
            'breadcrumb',
            'activeMenu',
            'user',
            'roles'
        ));
    }

    public function update(Request $request, $username)
    {
        // Ambil token dari session
        $token = session('token');

        if (!$token) {
            return back()->withErrors(['message' => 'Token tidak ditemukan. Silakan login ulang.']);
        }

        // Validasi input
        $validatedData = $request->validate([
            'email' => 'required|email',
            'fullname' => 'required|string|max:255',
            'username' => 'required|string|max:255',
            'urole_id' => 'required|uuid', // validasi UUID
        ]);

        $user = AccountModel::where('username', $username)->first();

        if ($request->email != $user->email) {
            $response = Http::withToken($token)->put("http://labai.polinema.ac.id:3042/api/admin/users/{$username}", [
                'email' => $request->email,
            ]);
        }

        if ($request->username != $user->username) {
            $response = Http::withToken($token)->put("http://labai.polinema.ac.id:3042/api/admin/users/{$username}", [
                'username' => $request->username,
            ]);
        }

        $response = Http::withToken($token)->put("http://labai.polinema.ac.id:3042/api/admin/users/{$username}", [
            'fullname' => $request->fullname,
            'urole_id' => $request->urole_id,
        ]);

        if ($response->successful()) {
            Alert::toast('Data pengguna berhasil diubah', 'success');
            return redirect()->route('kelolaPengguna.index');
        } else {
            Alert::toast('Data pengguna gagal diubah', 'error');
            return back()->withInput();
        }
    }

    // public function destroy($username)
    // {
    //     $token = session('token');

    //     if (!$token) {
    //         return back()->withErrors(['message' => 'Token tidak ditemukan. Silakan login ulang.']);
    //     }

    //     try {
    //         $apiUrl = "http://labai.polinema.ac.id:3042/api/admin/users/{$username}";

    //         $response = Http::withToken($token)
    //             ->withHeaders([
    //                 'Accept' => 'application/json',
    //             ])
    //             ->delete($apiUrl);

    //         if ($response->successful()) {
    //             Alert::toast('Akun berhasil dihapus.', 'success');
    //             return redirect()->route('kelolaPengguna.index');
    //         } else {
    //             Alert::toast('Akun tidak berhasil dihapus.', 'error');
    //             return back();
    //         }
    //     } catch (\Exception $e) {
    //         return back()->withErrors([
    //             'message' => 'Terjadi kesalahan saat menghubungi API.',
    //             'error' => $e->getMessage()
    //         ]);
    //     }
    // }
}
