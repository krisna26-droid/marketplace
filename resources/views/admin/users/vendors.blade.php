<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Manajemen Vendor</h2>
    </x-slot>

    <div class="py-10 px-8">

        {{-- Header --}}
        <div class="flex justify-between items-center mb-6">
            <h3 class="text-lg font-semibold">Daftar Vendor</h3>

            <a href="{{ route('admin.users.create') }}"
               class="px-8 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700 transition">
                Tambah Vendor
            </a>
        </div>

        {{-- Tabel --}}
        <div class="overflow-x-auto bg-white shadow rounded-lg">
            <table class="w-full text-sm text-left text-gray-600">
                <thead class="bg-gray-100 text-gray-700 text-xs uppercase">
                    <tr>
                        <th class="px-6 py-3 w-1/4">Nama</th>
                        <th class="px-6 py-3 w-1/4">Email</th>
                        <th class="px-6 py-3 w-1/6 text-center">Status</th>
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
                                @php
                                    $badge_color;
                                    if($user->vendor_status === 'pending') {
                                        $badge_color = 'text-blue-700 bg-blue-100';
                                    } else if($user->vendor_status === 'approved') {
                                        $badge_color = 'text-green-700 bg-green-100';
                                    } else if($user->vendor_status === 'rejeted') {
                                        $badge_color = 'text-red-700 bg-red-100';
                                    }
                                @endphp
                                <span class="px-2 py-1 capitalize rounded text-xs font-semibold {{ $badge_color }}">
                                    {{ $user->vendor_status}}
                                </span>
                            </td>

                            <td class="px-6 py-3 text-center">
                                {{ $user->created_at->format('d M Y') }}
                            </td>

                            <td class="px-6 py-3 text-center">
                                <div class="flex justify-center items-center space-x-4">
                                    <a href="{{ route('admin.users.edit', $user->id) }}"
                                       class="text-indigo-600 hover:text-indigo-800 font-semibold">
                                        Edit
                                    </a>

                                    @if(auth()->id() !== $user->id)
                                        <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST"
                                              onsubmit="return confirm('Hapus vendor ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-800 font-semibold">
                                                Hapus
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-6 text-gray-500">
                                Tidak ada vendor ditemukan.
                            </td>
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
