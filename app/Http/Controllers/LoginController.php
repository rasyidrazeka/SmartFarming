<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use RealRashid\SweetAlert\Facades\Alert;

class LoginController extends Controller
{
    public function index()
    {
        return view('login.index');
    }

    public function authenticate(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
        $remember = $request->has('remember_me');

        $response = Http::withBasicAuth($request->email, $request->password)
            ->post('http://labai.polinema.ac.id:3042/auth/login', [
                'remember_me' => $remember
            ]);

        if ($response->successful()) {
            $data = $response->json();

            // Ambil token dari struktur response
            $token = $data['data']['token'] ?? null;

            if ($token) {
                session(['token' => $token]);
                Alert::toast('Selamat Datang', 'success');
                return redirect('/dashboard');
            } else {
                // Kalau tidak ada token di response
                Alert::toast('Respon login tidak valid', 'error');
                return back();
            }
        } else {
            // Tangani error dari API
            $message = $response->json()['message'] ?? 'Login gagal';
            Alert::toast($message, 'error');
            return back();
        }
    }
}
