<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class RoleController extends Controller
{
    public function switchRole()
    {
        $user = Auth::user();

        // Memeriksa peran saat ini dari session atau default ke 'dosen'
        $currentRole = session('current_role', 'dosen');

        if ($currentRole === 'dosen') {
            if ($user->ketua_program_studi) {
                session(['current_role' => 'kaprodi']);
                return redirect()->route('dashboard-kaprodi');
            } elseif ($user->dekan) {
                session(['current_role' => 'dekan']);
                return redirect()->route('dashboard-dekan');
            }
        } else {
            // Kembali ke peran dosen
            session(['current_role' => 'dosen']);
            return redirect()->route('dashboard-doswal');
        }

        // Jika tidak ada peran lain, kembali ke dashboard saat ini
        return redirect()->back();
    }
}
