<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Models\Anggota; // Pastikan Anda mengimpor Model Anggota Anda
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

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
            $request->session()->regenerate();
            $user = Auth::user();

            session([
                'id' => $user->id,
                'nama' => $user->nama,
                'role' => $user->role,
            ]);

            return response()->json([
                'OUT_STAT' => true,
                'MESSAGE' => 'Login berhasil!',
                'USER' => [
                    'name' => session('nama'),
                    'role' => session('role'),
                ],
            ]);
        }

        return response()->json([
            'OUT_STAT' => false,
            'MESSAGE' => 'Email atau password salah!',
        ]);
    }

    public function logout()
    {
        Auth::logout();
        return response()->json([
            'OUT_STAT' => true,
            'MESSAGE' => 'Anda berhasil Log Out.',
        ]);
    }
}
