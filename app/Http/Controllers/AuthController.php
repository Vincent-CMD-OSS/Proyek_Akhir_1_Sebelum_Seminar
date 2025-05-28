<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log; // Untuk logging jika diperlukan

class AuthController extends Controller
{
    /**
     * Menerapkan middleware.
     * 'guest' untuk metode yang hanya boleh diakses tamu (belum login), kecuali logout.
     * 'auth' untuk metode yang hanya boleh diakses pengguna terotentikasi (untuk logout).
     */
    // public function __construct()
    // {
    //     $this->middleware('guest')->except('logout');
    //     $this->middleware('auth')->only('logout');
    // }

    /**
     * Menampilkan form login admin.
     *
     * @return \Illuminate\View\View
     */
    public function showLoginForm()
    {
        return view('auth.login'); // Kita akan buat view ini nanti
    }

    /**
     * Menangani permintaan login dari admin.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function login(Request $request)
    {
        // 1. Validasi input
        $credentials = $request->validate([
            'email' => ['required', 'string', 'email', 'max:255'],
            'password' => ['required', 'string'],
        ]);

        // 2. Coba untuk melakukan otentikasi
        // Parameter kedua 'remember' adalah opsional, true jika ingin ada fitur "remember me"
        $remember = $request->filled('remember'); // Cek apakah checkbox 'remember' dicentang

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate(); // Regenerasi session ID untuk keamanan

            // Log::info('User logged in: ' . Auth::user()->email); // Contoh logging

            // Redirect ke dashboard admin setelah login berhasil
            return redirect()->intended(route('admin.dashboard'));
        }

        // 3. Jika otentikasi gagal
        // withErrors akan membuat variabel $errors tersedia di view
        // onlyInput akan mengirim kembali input email saja (bukan password)
        return back()->withErrors([
            'email' => 'Kredensial yang diberikan tidak cocok dengan data kami.',
        ])->onlyInput('email');
    }

    /**
     * Menangani permintaan logout dari admin.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout(Request $request)
    {
        $userName = Auth::user()->nama; // Ambil nama sebelum logout
        Auth::logout(); // Logout pengguna

        $request->session()->invalidate(); // Batalkan session yang ada
        $request->session()->regenerateToken(); // Buat token CSRF baru

        // Log::info('User logged out: ' . $userName); // Contoh logging

        return redirect()->route('login')->with('status', 'Anda telah berhasil keluar.');
    }
}