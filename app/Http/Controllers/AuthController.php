<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Account;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $account = Account::where('email', $request->email)->first();

        if ($account && Hash::check($request->password, $account->password)) {
            Auth::login($account);
    
            // Redirect berdasarkan role
            if ($account->mahasiswa) {
                $nim = $account->related_id;
                session(['nim' => $nim]);
                return redirect()->route('dashboard-mhs', ['nim' => $nim]);
            } elseif ($account->pembimbing_akademik) {
                $nidn = $account->related_id;
                session(['nidn' => $nidn]);
                return redirect()->route('dashboard-doswal', ['nidn' => $nidn]);
            } elseif ($account->ketua_program_studi) {
                $nidn = $account->related_id;
                session(['nidn' => $nidn]);
                return redirect()->route('dashboard-kaprodi', ['nidn' => $nidn]);
            } elseif ($account->dekan) {
                $nidn = $account->related_id;
                session(['nidn' => $nidn]);
                return redirect()->route('dashboard-dekan', ['nidn' => $nidn]);
            } elseif ($account->bagian_akademik) {
                return redirect()->route('dashboard-ba');
            }
        } else {
            // Mengirimkan pesan error ke session jika login gagal
            return back()->withErrors(['login_error' => 'Email atau password salah.']);
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }


}

