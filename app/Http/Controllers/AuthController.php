<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }

    public function auth(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate(); // Bagus, ini sudah benar untuk mencegah session fixation saat login.
            $user = Auth::user();

            // CATATAN: Menyimpan data ini secara manual ke session sebenarnya redundan 
            // karena Anda bisa mengaksesnya langsung via Auth::user()->nama atau Auth::user()->role.
            session([
                'id' => $user->id,
                'nama' => $user->nama,
                'role' => $user->role,
                'jabatan' => $user->jabatan,
                'nip' => $user->nip,
            ]);

            return response()->json([
                'OUT_STAT' => true,
                'MESSAGE' => 'Login berhasil!',
                'USER' => [
                    'name' => $user->nama,
                    'role' => $user->role,
                ],
            ]);
        }

        return response()->json([
            'OUT_STAT' => false,
            'MESSAGE' => 'Email atau password salah!',
        ], 401); // Direkomendasikan menambahkan HTTP status code 401 Unauthorized
    }

    public function logout(Request $request)
    {
        Auth::logout();

        // WAJIB: Hancurkan sesi dan hapus semua data session (termasuk id, nama, role manual Anda)
        $request->session()->invalidate();

        // WAJIB: Buat ulang token CSRF baru agar token lama tidak bisa disalahgunakan
        $request->session()->regenerateToken();

        return response()->json([
            'OUT_STAT' => true,
            'MESSAGE' => 'Anda berhasil Log Out.',
        ]);
    }
}