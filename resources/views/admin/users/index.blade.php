<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Manajemen Pengguna</h2>
    </x-slot>

    <div class="py-10 px-8">
        {{-- Filter --}}
        <div class="flex justify-between items-center mb-6">
            <h3 class="text-lg font-semibold">Daftar Pengguna</h3>
            <form method="GET" class="flex items-center space-x-2">
                <select name="role" class="border-gray-300 rounded-lg px-3 py-2 focus:ring-indigo-300 focus:border-indigo-400">
                    <option value="">Semua Role</option>
                    <option value="vendor" {{ request('role') == 'vendor' ? 'selected' : '' }}>Vendor</option>
                    <option value="customer" {{ request('role') == 'customer' ? 'selected' : '' }}>Customer</option>
                    <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                </select>
                <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700 transition">
                    Filter
                </button>
                <button type="submit" class="px-8 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700 transition">
                    <a href="{{ route('admin.users.create') }}" class="text-white">Tambah User</a>
                </button>
            </form>
        </div>
        {{-- Tabel --}}
        <div class="overflow-x-auto bg-white shadow rounded-lg">
            <table class="w-full text-sm text-left text-gray-600">
                <thead class="bg-gray-100 text-gray-700 text-xs uppercase">
                    <tr>
                        <th class="px-6 py-3 w-1/4">Nama</th>
                        <th class="px-6 py-3 w-1/4">Email</th>
                        <th class="px-6 py-3 w-1/6 text-center">Role</th>
                        <th class="px-6 py-3 w-1/6 text-center">Tanggal Bergabung</th>
                        <th class="px-6 py-3 w-1/6 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($users as $user)
                        <tr class="border-t hover:bg-gray-50 transition">
                            <td class="px-6 py-3 font-medium text-gray-800">{{ $user->name }}</td>
                            <td class="px-6 py-3">{{ $user->email }}</td>
                            <td class="px-6 py-3 text-center">
                                <span class="px-2 py-1 rounded text-xs font-semibold 
                                    {{ $user->role === 'admin' ? 'bg-purple-100 text-purple-700' : 
                                       ($user->role === 'vendor' ? 'bg-blue-100 text-blue-700' : 
                                       'bg-green-100 text-green-700') }}">
                                    {{ ucfirst($user->role) }}
                                </span>
                            </td>
                            <td class="px-6 py-3 text-center">
                                {{ $user->created_at->format('d M Y') }}
                            </td>
                            <td class="px-6 py-3 text-center">
                                <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Hapus user ini?')" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-800 font-semibold">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-6 text-gray-500">Tidak ada pengguna ditemukan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div class="mt-6">
            {{ $users->links() }}
        </div>
    </div>
</x-app-layout>
