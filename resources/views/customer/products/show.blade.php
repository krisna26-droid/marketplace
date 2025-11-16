<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $product->name }}
        </h2>
    </x-slot>

    <div class="max-w-5xl mx-auto py-10 px-8">
        <div class="bg-white rounded-lg shadow p-6 flex flex-col md:flex-row gap-6">

            <img src="{{ asset('storage/' . $product->image) }}"
                 class="w-full md:w-1/3 h-64 object-cover rounded">

            <div>

                <h3 class="text-2xl font-semibold">{{ $product->name }}</h3>

                {{-- ⭐ AVERAGE RATING --}}
                <p class="text-yellow-500 text-lg mt-1">
                    {{ str_repeat('⭐', round($averageRating)) }}
                    <span class="text-gray-600 text-sm">
                        ({{ number_format($averageRating, 1) }} / 5)
                    </span>
                </p>

                <p class="text-gray-600 mt-2">{{ $product->description }}</p>

                <div class="mt-8">
                    <h3 class="text-lg font-semibold mb-2">Review Terbaru</h3>

                    @if ($latestReview)
                        <div class="border-b py-3">
                            <p class="text-yellow-500 text-sm">
                                {{ str_repeat('⭐', $latestReview->rating) }}
                            </p>
                            <p class="text-gray-700 text-sm">{{ $latestReview->comment }}</p>
                            <p class="text-xs text-gray-500">
                                oleh: {{ $latestReview->customer->name }} |
                                {{ $latestReview->created_at->format('d M Y') }}
                            </p>
                        </div>

                        @if($totalReviews > 1)
                            <a href="{{ route('customer.reviews.index', $product->id) }}"
                               class="text-indigo-600 text-sm mt-3 inline-block hover:underline">
                                Lihat semua {{ $totalReviews }} review →
                            </a>
                        @endif
                    @else
                        <p class="text-gray-500 text-sm">Belum ada review.</p>
                    @endif
                </div>

                <p class="text-xl font-bold text-indigo-600 mt-4">
                    Rp {{ number_format($product->price, 0, ',', '.') }}
                </p>

                <p class="text-sm text-gray-500 mt-2">
                    Kategori: {{ $product->category->name ?? '-' }} <br>
                    Vendor: {{ $product->vendor->name ?? '-' }}
                </p>

                <form method="POST" action="{{ route('customer.cart.add', $product->id) }}" class="mt-6">
                    @csrf
                    <button type="submit"
                        class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">
                        Tambah ke Keranjang
                    </button>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>
