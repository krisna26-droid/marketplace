<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Kelola Produk Vendor
        </h2>
    </x-slot>

    <div class="py-10 px-8">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6 gap-4">
            <h3 class="text-lg font-semibold">Daftar Produk</h3>

            <form method="GET" class="flex flex-wrap items-center gap-2">
                {{-- Filter Status --}}
                <select name="status" class="border rounded px-3 py-2">
                    <option value="">Produk Aktif</option>
                    <option value="trashed" {{ request('status') == 'trashed' ? 'selected' : '' }}>Produk Terhapus</option>
                    <option value="all" {{ request('status') == 'all' ? 'selected' : '' }}>Semua Produk</option>
                </select>

                {{-- Filter Kategori --}}
                <select name="category_id" class="border rounded px-3 py-2">
                    <option value="">Semua Kategori</option>
                    @foreach ($categories as $cat)
                        <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>
                            {{ $cat->name }}
                        </option>
                    @endforeach
                </select>

                {{-- Filter Vendor --}}
                <select name="vendor_id" class="border rounded px-3 py-2">
                    <option value="">Semua Vendor</option>
                    @foreach ($vendors as $vendor)
                        <option value="{{ $vendor->id }}" {{ request('vendor_id') == $vendor->id ? 'selected' : '' }}>
                            {{ $vendor->name }}
                        </option>
                    @endforeach
                </select>

                {{-- Rentang Harga --}}
                <input type="number" name="min_price" value="{{ request('min_price') }}" placeholder="Harga min"
                    class="border rounded px-3 py-2 w-28">
                <input type="number" name="max_price" value="{{ request('max_price') }}" placeholder="Harga max"
                    class="border rounded px-3 py-2 w-28">

                {{-- Tombol Filter & Reset --}}
                <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">
                    Filter
                </button>
                <a href="{{ route('admin.products.index') }}" class="px-4 py-2 bg-gray-300 text-gray-700 rounded hover:bg-gray-400">
                    Reset
                </a>
                <a href="{{ route('admin.products.create') }}" 
                class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">
                    + Tambah Produk
                </a>
            </form>
        </div>
        {{-- Tabel Produk --}}
        <table class="w-full bg-white shadow rounded-lg overflow-hidden">
            <thead class="bg-gray-100">
                <tr class="text-left">
                    <th class="px-4 py-2">Gambar</th>
                    <th class="px-4 py-2">Nama</th>
                    <th class="px-4 py-2">Vendor</th>
                    <th class="px-4 py-2">Stock</th>
                    <th class="px-4 py-2">Kategori</th>
                    <th class="px-4 py-2">Harga</th>
                    <th class="px-4 py-2 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($products as $product)
                    <tr class="border-t">
                        <td class="px-4 py-2">
                            @if ($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}" class="h-16 w-16 object-cover rounded">
                            @else
                                <span class="text-gray-400 text-sm">Tidak ada</span>
                            @endif
                        </td>
                        <td class="px-4 py-2">{{ $product->name }}</td>
                        <td class="px-4 py-2">{{ $product->vendor->name ?? '-' }}</td>
                        <td class="px-4 py-2">{{ $product->stock }}</td>
                        <td class="px-4 py-2">{{ $product->category->name ?? '-' }}</td>
                        <td class="px-4 py-2">Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                        <td class="px-4 py-2 text-center space-x-2">
                            @if (request('status') === 'trashed')
                                <form action="{{ route('admin.products.restore', $product->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="text-green-600 hover:underline">Pulihkan</button>
                                </form>
                                <form action="{{ route('admin.products.forceDelete', $product->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:underline"
                                        onclick="return confirm('Hapus permanen produk ini?')">Hapus Permanen</button>
                                </form>
                            @else
                                <a href="{{ route('admin.products.edit', $product->id) }}" class="text-blue-500 hover:underline">Edit</a>
                                <form method="POST" action="{{ route('admin.products.destroy', $product->id) }}" class="inline-block ml-2">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:underline"
                                        onclick="return confirm('Hapus produk ini?')">Hapus</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center py-4 text-gray-600">Belum ada produk.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="mt-6">
            {{ $products->links() }}
        </div>
    </div>
</x-app-layout>
