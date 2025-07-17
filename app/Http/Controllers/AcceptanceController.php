<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;

class AcceptanceController extends Controller
{
    public function index(Request $request)
    {
        $token = $request->query('token');

        if (!$token) {
            return redirect('/')->withErrors(['Token tidak ditemukan.']);
        }

        return view('accept_invitation.index');
    }

    public function process(Request $request)
    {
        // Validasi form input
        $request->validate([
            'password' => 'required|min:8',
            'password_confirmation' => 'required|same:password',
        ]);

        // Ambil token dari query string URL
        $token = $request->query('token');

        if (!$token) {
            return back()->withErrors(['Token tidak ditemukan.'])->withInput();
        }

        // Kirim password dan konfirmasi ke API, token tetap berada di URL
        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ])->post("http://labai.polinema.ac.id:3042/users/accept-invitation?token={$token}", [
            'password' => $request->password,
            'password_confirmation' => $request->password_confirmation
        ]);

        // Jika berhasil
        if ($response->successful()) {
            Alert::toast('Password Berhasil Ditambahkan', 'success');
            return redirect()->route('login.index');
        }

        // Tangani error dari API
        $validator = Validator::make([], []);
        $body = $response->json();

        if (isset($body['errors']['errors'])) {
            foreach ($body['errors']['errors'] as $error) {
                $validator->errors()->add($error['field'], $error['message']);
            }
        } else {
            $validator->errors()->add('api', $body['message'] ?? 'Gagal mengaktifkan akun.');
        }

        return back()->withErrors($validator)->withInput();
    }
}
