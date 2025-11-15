<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Edit Produk (Admin)
        </h2>
    </x-slot>

    <div class="py-10 px-8 max-w-3xl mx-auto">
        <form method="POST" action="{{ route('admin.products.update', $product->id) }}" enctype="multipart/form-data" class="bg-white p-6 rounded shadow">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label class="block text-gray-700">Nama Produk</label>
                <input type="text" name="name" class="w-full border rounded p-2" value="{{ $product->name }}" required>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700">Deskripsi</label>
                <textarea name="description" class="w-full border rounded p-2" required>{{ $product->description }}</textarea>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700">Harga</label>
                <input type="number" name="price" class="w-full border rounded p-2" value="{{ $product->price }}" required>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 font-medium mb-1">Stok Produk</label>
                <input type="number" name="stock" value="{{ old('stock', $product->stock) }}" min="0"
                    class="w-full border rounded px-3 py-2 focus:ring focus:ring-indigo-200">
            </div>

            <div class="mb-4">
                <label class="block text-gray-700">Kategori</label>
                <select name="category_id" class="w-full border rounded p-2" required>
                    @foreach ($categories as $cat)
                        <option value="{{ $cat->id }}" {{ $cat->id == $product->category_id ? 'selected' : '' }}>{{ $cat->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700">Gambar</label>
                @if ($product->image)
                    <img src="{{ asset('storage/' . $product->image) }}" class="h-24 mb-2 rounded">
                @endif
                <input type="file" name="image" class="w-full border rounded p-2">
            </div>

            <div class="flex justify-end">
                <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">Update</button>
            </div>
        </form>
    </div>
</x-app-layout>
