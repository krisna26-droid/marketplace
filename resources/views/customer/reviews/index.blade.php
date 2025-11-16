<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">
            Semua Review untuk {{ $product->name }}
        </h2>
    </x-slot>

    <div class="max-w-4xl mx-auto py-10 px-8">

        <div class="bg-white p-6 rounded shadow">

            @forelse ($reviews as $review)
                <div class="border-b py-4">
                    <p class="text-yellow-500 text-sm">
                        {{ str_repeat('⭐', $review->rating) }}
                    </p>
                    <p class="text-gray-800">{{ $review->comment }}</p>

                    <p class="text-xs text-gray-500">
                        oleh: {{ $review->customer->name }} |
                        {{ $review->created_at->format('d M Y') }}
                    </p>
                </div>
            @empty
                <p class="text-gray-500">Belum ada review.</p>
            @endforelse

            <div class="mt-4">
                {{ $reviews->links() }}
            </div>

            <a href="{{ route('customer.products.show', $product->id) }}"
                class="text-indigo-600 text-sm mt-6 inline-block hover:underline">
                ← Kembali ke Produk
            </a>

        </div>

    </div>

</x-app-layout>
