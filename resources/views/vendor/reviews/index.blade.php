<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">
            Review Produk Saya
        </h2>
    </x-slot>

    <div class="max-w-5xl mx-auto py-10 px-8">
        <div class="bg-white p-6 rounded shadow">

            @forelse ($reviews as $review)
                <div class="border-b py-4">

                    <h3 class="font-semibold text-gray-800">
                        {{ $review->product->name }}
                    </h3>

                    <p class="text-yellow-500 text-sm">
                        {{ str_repeat('⭐', $review->rating) }}
                        <span class="text-gray-600 ml-1">
                            ({{ $review->rating }}/5)
                        </span>
                    </p>

                    <p class="text-gray-800 mt-1">
                        {{ $review->comment }}
                    </p>

                    <p class="text-xs text-gray-500 mt-1">
                        oleh: {{ $review->customer->name }} |
                        {{ $review->created_at->format('d M Y') }}
                    </p>
                </div>

            @empty
                <p class="text-gray-500">Belum ada review untuk produk Anda.</p>
            @endforelse

            <div class="mt-4">
                {{ $reviews->links() }}
            </div>

        </div>
    </div>

</x-app-layout>
