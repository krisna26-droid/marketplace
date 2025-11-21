<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    // Tampilkan form
    public function showRegistrationForm()
    {
        return view('vendor.register');
    }

    // Proses daftar vendor
    public function register(Request $request)
    {
        $request->validate([
            'name'     => 'required',
            'email'    => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed',
        ]);

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => 'vendor',  // BELUM ACTIVE, butuh ACC ADMIN
            'is_vendor'=> true
        ]);

        return redirect()->route('login')
            ->with('success', 'Pendaftaran vendor berhasil! Tunggu verifikasi admin.');
    }
}
