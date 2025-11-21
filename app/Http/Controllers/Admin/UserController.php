<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;


class UserController extends Controller
{
    public function index(Request $request)
    {
        $users = User::where('role', 'customer')->paginate(10);

        return view('admin.users.index', compact('users'));
    }

    public function vendors()
    {
        $users = User::where('role', 'vendor')->paginate(10);
        return view('admin.users.vendors', compact('users'));
    }

    public function create()
    {
        return view('admin.users.create');
    }

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

    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name'  => 'required',
            'email' => "required|email|unique:users,email,$user->id",
        ]);

        // update data dasar user
        $user->update([
            'name'  => $request->name,
            'email' => $request->email,
        ]);

        if ($user->role === 'vendor') {
            $request->validate(['vendor_status' => 'required|in:pending,approved,rejected']);
            $user->update(['vendor_status' => $request->vendor_status]);
        }

        if ($user->role === 'customer') {
            if (!$user->customer) {
                $user->customer()->create([
                    'address'     => $request->address ?? '',

                    'phone'       => $request->phone ?? '',
                    'city'        => $request->city ?? '',
                    'province'    => $request->province ?? '',
                    'postal_code' => $request->postal_code ?? '',
                ]);
            } else {
                $user->customer->update([
                    'address'     => $request->address ?? $user->customer->address,
                    'phone'       => $request->phone ?? $user->customer->phone,
                    'city'        => $request->city ?? $user->customer->city,
                    'province'    => $request->province ?? $user->customer->province,
                    'postal_code' => $request->postal_code ?? $user->customer->postal_code,
                ]);
            }
        }

        if ($user->role !== 'customer' && $user->customer) {
            $user->customer->delete();
        }

        if($user->role === 'vendor') {
            return redirect()
                ->route('admin.users.vendors', ['role' => $user->role])
                ->with('success', 'Data user berhasil diperbarui.');
        } else {
            return redirect()
                ->route('admin.users.index', ['role' => $user->role])
                ->with('success', 'Data user berhasil diperbarui.');
        }
    }
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
