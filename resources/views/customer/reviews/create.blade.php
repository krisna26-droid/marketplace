<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl">Beri Review</h2>
    </x-slot>

    <div class="max-w-md mx-auto py-8">

        <div class="bg-white p-6 rounded shadow">
            <h3 class="text-lg font-semibold">
                Review untuk: {{ $orderItem->product->name }}
            </h3>

            <form method="POST" action="{{ route('customer.reviews.store', $orderItem->id) }}">
                @csrf

                <label class="block mt-4 font-medium">Rating</label>
                <select name="rating" class="w-full border rounded p-2" required>
                    <option value="">Pilih rating</option>
                    <option value="5">⭐⭐⭐⭐⭐ (5)</option>
                    <option value="4">⭐⭐⭐⭐ (4)</option>
                    <option value="3">⭐⭐⭐ (3)</option>
                    <option value="2">⭐⭐ (2)</option>
                    <option value="1">⭐ (1)</option>
                </select>

                <label class="block mt-4 font-medium">Komentar</label>
                <textarea name="comment" class="w-full border rounded p-2"
                          rows="4" placeholder="Tulis komentar..."></textarea>

                <button class="mt-6 w-full bg-indigo-600 text-white py-2 rounded">
                    Kirim Review
                </button>
            </form>
        </div>
    </div>
</x-app-layout>
