<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl">Wishlist Saya</h2>
    </x-slot>

    <div class="p-6">
        @forelse ($favorites as $product)
            <div class="flex items-center gap-4 border-b py-2">
                <img src="{{ image_url($product->image) }}" class="w-16 h-16 rounded object-cover">
                <span class="font-semibold">{{ $product->name }}</span>
                <span>Rp {{ number_format($product->price, 0, ',', '.') }}</span>

                <form action="{{ route('customer.wishlist.toggle', $product->id) }}" method="POST">
                    @csrf
                    <button class="text-red-500">Hapus</button>
                </form>
            </div>
        @empty
            <p>Tidak ada wishlist</p>
        @endforelse

        {{ $favorites->links() }}
    </div>
</x-app-layout>
