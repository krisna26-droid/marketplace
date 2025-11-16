<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;


class UserController extends Controller
{
    /**
     * List pengguna (admin, vendor, customer) dengan filter role.
     */
    public function index(Request $request)
    {
        $role = $request->get('role');

        // Query awal tanpa user yang sedang login
        $query = User::where('id', '!=', auth()->id());

        // Filter role jika dipilih dari dropdown atau URL (?role=vendor)
        if ($role) {
            $query->where('role', $role);
        }

        // Pisahkan paginasi agar tidak warning
        $users = $query->paginate(10);
        $users->withQueryString(); // mempertahankan parameter role saat pindah halaman

        return view('admin.users.index', compact('users', 'role'));
    }

    /**
     * Form Tambah user
     */
    public function create()
    {
        return view('admin.users.create'); 
    }

    /**
     * Store user baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required',
            'email'    => 'required|email|unique:users',
            'password' => 'required|min:8',
            'role'     => 'required',
        ]);

        // buat user baru
        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => bcrypt($request->password),
            'role'     => $request->role,
        ]);

        // Jika role customer → buat profile customer
        if ($user->role === 'customer') {
            $request->validate([
                'address' => 'required',
                'phone'   => 'required',
            ]);

            $user->customer()->create([
                'address'     => $request->address,
                'phone'       => $request->phone,
                'city'        => $request->city,
                'province'    => $request->province,
                'postal_code' => $request->postal_code
            ]);
        }

        return redirect()
            ->route('admin.users.index', ['role' => $user->role])
            ->with('success', 'User berhasil ditambahkan.');
    }

    /**
     * Form edit user
     */
    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    /**
     * Update user
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name'  => 'required',
            'email' => "required|email|unique:users,email,$user->id",
            'role'  => 'required',
        ]);

        // update data dasar user
        $user->update([
            'name'  => $request->name,
            'email' => $request->email,
            'role'  => $request->role,
        ]);

        /**
         * UPDATE / PERPINDAHAN ROLE CUSTOMER
         */
        if ($user->role === 'customer') {

            // Jika belum punya tabel customer → buat
            if (!$user->customer) {
                $user->customer()->create([
                    'address'     => $request->address ?? '',
                    'phone'       => $request->phone ?? '',
                    'city'        => $request->city ?? '',
                    'province'    => $request->province ?? '',
                    'postal_code' => $request->postal_code ?? '',
                ]);
            } else {
                // Jika sudah ada → update
                $user->customer->update([
                    'address'     => $request->address ?? $user->customer->address,
                    'phone'       => $request->phone ?? $user->customer->phone,
                    'city'        => $request->city ?? $user->customer->city,
                    'province'    => $request->province ?? $user->customer->province,
                    'postal_code' => $request->postal_code ?? $user->customer->postal_code,
                ]);
            }
        }

        /**
         * Jika role berubah dari customer → vendor/admin → hapus relasi customer
         */
        if ($user->role !== 'customer' && $user->customer) {
            $user->customer->delete();
        }

        return redirect()
            ->route('admin.users.index', ['role' => $user->role])
            ->with('success', 'Data user berhasil diperbarui.');
    }

    /**
     * Hapus user
     */
    public function destroy(User $user)
    {
        // Admin tidak boleh menghapus dirinya sendiri
        if (auth()->id() === $user->id) {
            return back()->with('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
        }

        // jika customer → hapus profile customer
        if ($user->customer) {
            $user->customer->delete();
        }

        $user->delete();

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'User berhasil dihapus.');
    }
}
