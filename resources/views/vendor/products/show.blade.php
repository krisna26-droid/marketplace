<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Detail Produk
        </h2>
    </x-slot>

    <div class="py-10 px-8 max-w-4xl mx-auto">
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex flex-col md:flex-row gap-6">
                {{-- Gambar Produk --}}
                <div class="md:w-1/2">
                    @if ($product->image)
                        <img src="{{ asset('storage/' . $product->image) }}" 
                             class="rounded-lg w-full h-72 object-cover" 
                             alt="{{ $product->name }}">
                    @else
                        <div class="w-full h-72 bg-gray-100 rounded flex items-center justify-center text-gray-500">
                            Tidak ada gambar
                        </div>
                    @endif
                </div>

                {{-- Detail Produk --}}
                <div class="md:w-1/2">
                    <h3 class="text-2xl font-bold text-gray-800 mb-2">{{ $product->name }}</h3>
                    <p class="text-gray-600 mb-4">{{ $product->description }}</p>

                    <p class="text-lg font-semibold text-indigo-600 mb-2">
                        Rp {{ number_format($product->price, 0, ',', '.') }}
                    </p>

                    <p class="text-sm text-gray-500 mb-6">
                        Kategori: {{ $product->category->name ?? '-' }}
                    </p>

                    <div class="flex gap-3">
                        <a href="{{ route('vendor.products.edit', $product->id) }}" 
                           class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Edit</a>

                        <form method="POST" action="{{ route('vendor.products.destroy', $product->id) }}">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700"
                                    onclick="return confirm('Yakin ingin menghapus produk ini?')">Hapus</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
