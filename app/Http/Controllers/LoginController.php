<?php

namespace App\Http\Controllers;

use App\Models\UserModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use RealRashid\SweetAlert\Facades\Alert;

class LoginController extends Controller
{
    public function index()
    {
        if (auth()->check()) {
            return redirect()->route('dashboard.index');
        }
        return response()
            ->view('login.index');
    }

    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email:dns',
            'password' => 'required'
        ]);

        $user = UserModel::where('email', $request->email)->first();

        if (!$user) {
            return back()->withErrors(['email' => 'Email tidak ditemukan.'])->onlyInput('email');
        }

        // 1. Coba verifikasi password lama (argon2id dari eksternal)
        if (password_verify($request->password, $user->password)) {
            dd('email dan pass sudah sesuai');
            // 2. Upgrade password hash ke Laravel format
            // $user->password = Hash::make($request->password);
            // $user->save();

            // 3. Login user secara manual
            // Auth::login($user);
            // $request->session()->regenerate();

            // return redirect()->intended('/dashboard');
        }

        return back()->withErrors(['email' => 'Email atau password salah.'])->onlyInput('email');
    }
}
