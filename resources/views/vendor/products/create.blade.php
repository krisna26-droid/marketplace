<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Tambah Produk
        </h2>
    </x-slot>

    <div class="py-10 px-8 max-w-3xl mx-auto">
        <form method="POST" action="{{ route('vendor.products.store') }}" enctype="multipart/form-data" class="bg-white p-6 rounded shadow">
            @csrf

            <div class="mb-4">
                <label class="block text-gray-700">Nama Produk</label>
                <input type="text" name="name" class="w-full border rounded p-2" required>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700">Deskripsi</label>
                <textarea name="description" class="w-full border rounded p-2" required></textarea>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700">Harga</label>
                <input type="number" name="price" class="w-full border rounded p-2" required>
            </div>
            <!-- Input stok -->
            <div class="mt-4">
                <x-input-label for="stock" :value="__('Stok')" />
                <x-text-input id="stock" class="block mt-1 w-full"
                    type="number" name="stock" value="{{ old('stock', $product->stock ?? 0) }}" min="0" required />
                <x-input-error :messages="$errors->get('stock')" class="mt-2" />
            </div>


            <div class="mb-4">
                <label class="block text-gray-700">Kategori</label>
                <select name="category_id" class="w-full border rounded p-2" required>
                    <option value="">Pilih Kategori</option>
                    @foreach ($categories as $cat)
                        <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700">Gambar (opsional)</label>
                <input type="file" name="image" class="w-full border rounded p-2">
            </div>

            <div class="flex justify-end">
                <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">Simpan</button>
            </div>
        </form>
    </div>
</x-app-layout>
