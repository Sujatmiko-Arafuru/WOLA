<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    /**
     * Tampilkan halaman login pegawai
     */
    public function showEmployeeLogin()
    {
        return view('auth.login-employee');
    }

    /**
     * Tampilkan halaman login admin
     */
    public function showAdminLogin()
    {
        return view('auth.login-admin');
    }

    /**
     * Proses login pegawai
     */
    public function employeeLogin(Request $request)
    {
        $request->validate([
            'nip' => 'required|string',
            'password' => 'required|string',
        ], [
            'nip.required' => 'NIP wajib diisi',
            'password.required' => 'Password wajib diisi',
        ]);

        $user = User::where('nip', $request->nip)
                   ->where('role', 'employee')
                   ->first();

        // Verifikasi password tanpa enkripsi (plain text)
        if (!$user || $request->password !== $user->password) {
            throw ValidationException::withMessages([
                'nip' => ['NIP atau password salah.'],
            ]);
        }

        Auth::login($user);

        return redirect()->route('pegawai.dashboard')->with('success', 'Selamat datang kembali, ' . $user->name . '!');
    }

    /**
     * Proses login admin
     */
    public function adminLogin(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ], [
            'email.required' => 'Email wajib diisi',
            'email.email' => 'Format email tidak valid',
            'password.required' => 'Password wajib diisi',
        ]);

        $user = User::where('email', $request->email)
                   ->where('role', 'admin')
                   ->first();

        // Verifikasi password tanpa enkripsi (plain text)
        if (!$user || $request->password !== $user->password) {
            throw ValidationException::withMessages([
                'email' => ['Email atau password salah.'],
            ]);
        }

        Auth::login($user);

        return redirect()->route('admin.dashboard')->with('success', 'Selamat datang kembali, Admin!');
    }

    /**
     * Logout pengguna
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login.pegawai')->with('success', 'Anda telah berhasil logout.');
    }
}