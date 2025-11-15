<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Marketplace</h2>
    </x-slot>

    <div class="py-10 px-8">
        {{-- Filter dan Search --}}
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
                    class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">Filter</button>
            </form>
        </div>

        {{-- Daftar Produk --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse ($products as $product)
                <div class="bg-white rounded-lg shadow hover:shadow-lg transition p-4">
                    <a href="{{ route('customer.products.show', $product->id) }}">
                        @if ($product->image)
                            <img src="{{ asset('storage/' . $product->image) }}"
                                class="w-full h-48 object-cover rounded mb-3" alt="{{ $product->name }}">
                        @endif
                        <h4 class="text-lg font-semibold text-gray-800">{{ $product->name }}</h4>
                        <p class="text-gray-600 text-sm mt-1">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                        <p class="text-xs text-gray-500 mt-1">{{ $product->category->name ?? '-' }}</p>
                        <p class="text-xs text-gray-400 mt-1">Vendor: {{ $product->vendor->name ?? '-' }}</p>
                    </a>
                </div>
            @empty
                <p class="text-gray-600 col-span-3">Tidak ada produk ditemukan.</p>
            @endforelse
        </div>

        <div class="mt-8">
            {{ $products->links() }}
        </div>
    </div>
</x-app-layout>
