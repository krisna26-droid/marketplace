<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $role = $request->get('role');
        $query = User::query();

        if ($role) {
            $query->where('role', $role);
        }

        $users = $query->paginate(10);
        return view('admin.users.index', compact('users', 'role'));
    }

    public function create()
    {
        return view('admin.users.create'); 
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8',
            'role' => 'required',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => $request->role,
        ]);

        if ($user->role === 'customer') {
            $request->validate([
                'address' => 'required',
                'phone' => 'required',

            ]); 
            
            // session(['new_customer_id' => $user->id]);
            $user->customer()->create([
                'address' => $request->address,
                'phone' => $request->phone,
                'city' => $request->city,
                'province' => $request->province,
                'postal_code' => $request->postal_code
            ]);
        }

        return redirect()->route('admin.users.index')->with('success', 'User berhasil ditambahkan.');
    }

    public function destroy(User $user)
    {
        if (auth()->id() === $user->id) {
            return redirect()->back()->with('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
        }

        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'User berhasil dihapus.');
    }
}
