<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            
        </h2>
    </x-slot>

    <div class="max-w-xl mx-auto py-10 px-8">
        <div class="bg-white shadow rounded p-6">

            <form method="POST" action="{{ route('customer.reviews.store', $orderItem->id) }}">
                @csrf

                <label class="block font-semibold mb-1">Rating</label>
                <select name="rating" class="border rounded w-full p-2 mb-4" required>
                    <option value="">-- Pilih Rating --</option>
                    @for ($i = 5; $i >= 1; $i--)
                        <option value="{{ $i }}">{{ $i }} ⭐</option>
                    @endfor
                </select>

                <label class="block font-semibold mb-1">Komentar (opsional)</label>
                <textarea name="comment" rows="4" class="border rounded w-full p-2 mb-4"></textarea>

                <button class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">
                    Kirim Review
                </button>
            </form>

        </div>
    </div>
</x-app-layout>
