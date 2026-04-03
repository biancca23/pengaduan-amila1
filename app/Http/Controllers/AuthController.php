<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLogin() {
        return view('login');
    }

    public function login(Request $request) {
        $credentials = $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);

        // Karena kita menggunakan tabel 'admins' custom (bukan 'users' bawaan Laravel), 
        // untuk level UKK kita bisa gunakan logika session sederhana ini:
        $admin = \App\Models\Admin::where('username', $request->username)->first();

        if ($admin && Hash::check($request->password, $admin->password)) {
            session(['admin_logged_in' => true]);
            return redirect()->route('admin.index');
        }

        return back()->with('error', 'Username atau Password salah!');
    }

    public function logout() {
        session()->forget('admin_logged_in');
        return redirect()->route('login');
    }
}