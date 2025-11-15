<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Tambah Produk Baru
        </h2>
    </x-slot>

    <div class="py-10 px-8 max-w-3xl mx-auto">
        <form method="POST" action="{{ route('admin.products.store') }}" enctype="multipart/form-data"
              class="bg-white p-6 rounded shadow">
            @csrf

            <div class="mb-4">
                <label class="block text-gray-700">Nama Produk</label>
                <input type="text" name="name" class="w-full border rounded p-2"
                       value="{{ old('name') }}" required>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700">Deskripsi</label>
                <textarea name="description" class="w-full border rounded p-2" required>{{ old('description') }}</textarea>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700">Harga</label>
                <input type="number" name="price" class="w-full border rounded p-2"
                       value="{{ old('price') }}" min="0" required>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700">Stok</label>
                <input type="number" name="stock" class="w-full border rounded p-2"
                       value="{{ old('stock') }}" min="0" required>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700">Kategori</label>
                <select name="category_id" class="w-full border rounded p-2" required>
                    <option value="">-- Pilih Kategori --</option>
                    @foreach ($categories as $cat)
                        <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>
                            {{ $cat->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700">Vendor</label>
                <select name="vendor_id" class="w-full border rounded p-2" required>
                    <option value="">-- Pilih Vendor --</option>
                    @foreach ($vendors as $vendor)
                        <option value="{{ $vendor->id }}" {{ old('vendor_id') == $vendor->id ? 'selected' : '' }}>
                            {{ $vendor->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700">Gambar Produk</label>
                <input type="file" name="image" class="w-full border rounded p-2">
            </div>

            <div class="flex justify-end">
                <a href="{{ route('admin.products.index') }}"
                   class="px-4 py-2 bg-gray-300 text-gray-800 rounded hover:bg-gray-400 mr-2">
                    Batal
                </a>
                <button type="submit"
                        class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">
                    Simpan Produk
                </button>
            </div>
        </form>
    </div>
</x-app-layout>
