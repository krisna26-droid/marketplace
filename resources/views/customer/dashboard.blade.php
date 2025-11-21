<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Marketplace</h2>
    </x-slot>

    <div class="py-10 px-8">
        {{-- Filter & Search --}}
        <div class="flex flex-col md:flex-row justify-between items-center mb-8 gap-4">
            <form method="GET" class="flex gap-3 w-full md:w-auto">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari produk..."
                    class="border-gray-300 rounded w-full md:w-64 px-3 py-2 focus:ring focus:ring-indigo-200">
                
                <select name="category_id" class="border-gray-300 rounded px-3 py-2">
                    <option value="">Semua Kategori</option>
                    @foreach ($categories as $cat)
                        @include('customer.partials.category-option', ['category' => $cat, 'prefix' => ''])
                    @endforeach
                </select>

                <button type="submit"
                    class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700 transition">
                    Filter
                </button>
            </form>
        </div>

        {{-- Daftar Produk --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse ($products as $product)
                <div class="bg-white rounded-lg shadow hover:shadow-lg transition p-4">
                    <a href="{{ route('customer.products.show', $product->id) }}">
                        @if ($product->image)
                            <img src="{{ $product->image_url }}"
                                class="w-full h-48 object-cover rounded mb-3"
                                alt="{{ $product->name }}">
                        @else
                            <div class="w-full h-48 flex items-center justify-center text-gray-400 border rounded mb-3">
                                Tidak ada gambar
                            </div>
                        @endif

                        <h4 class="text-lg font-semibold text-gray-800">{{ $product->name }}</h4>
                        <p class="text-gray-600 text-sm mt-1">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                        <p class="text-xs text-gray-500 mt-1">{{ $product->category->name ?? '-' }}</p>
                        <p class="text-xs text-gray-400 mt-1">Vendor: {{ $product->vendor->name ?? '-' }}</p>
                    </a>

                    {{-- Tombol Wishlist --}}
                    @auth
                        <form action="{{ route('customer.wishlist.toggle', $product->id) }}" method="POST" class="mt-3">
                            @csrf
                            <button type="submit" 
                                class="text-sm px-3 py-1 rounded transition 
                                       {{ auth()->user()->isFavorite($product->id) 
                                          ? 'bg-red-500 text-white hover:bg-red-600' 
                                          : 'bg-gray-200 text-gray-600 hover:bg-gray-300' }}">
                                {{ auth()->user()->isFavorite($product->id) ? '♥ Hapus Wishlist' : '♡ Tambah Wishlist' }}
                            </button>
                        </form>
                    @endauth
                </div>
            @empty
                <p class="text-gray-600 col-span-3">Tidak ada produk ditemukan.</p>
            @endforelse
        </div>

        {{-- Pagination --}}
        <div class="mt-8">
            {{ $products->links() }}
        </div>
    </div>
</x-app-layout>
