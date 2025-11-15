<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Produk Saya
        </h2>
    </x-slot>

    <div class="py-10 px-8">
        <div class="flex justify-between mb-6">
            <h3 class="text-lg font-semibold">Daftar Produk</h3>
            <a href="{{ route('vendor.products.create') }}" class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">+ Tambah Produk</a>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse ($products as $product)
                <a href="{{ route('vendor.products.show', $product->id) }}" 
                class="bg-white rounded-lg shadow hover:shadow-lg transition p-4 block hover:scale-[1.02] duration-150">
                
                    @if ($product->image)
                        <img src="{{ asset('storage/' . $product->image) }}" 
                            class="w-full h-48 object-cover rounded mb-3" 
                            alt="{{ $product->name }}">
                    @endif
                    
                    <h4 class="text-lg font-semibold text-gray-800">{{ $product->name }}</h4>
                    <p class="text-gray-600 text-sm mt-1">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                    <p class="text-xs text-gray-500 mt-1">{{ $product->category->name ?? '-' }}</p>
                </a>
            @empty
                <p class="text-gray-600">Belum ada produk.</p>
            @endforelse
        </div>
    </div>
</x-app-layout>
