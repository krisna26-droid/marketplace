<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Detail Pesanan #{{ $order->id }}
        </h2>
    </x-slot>

    <div class="py-10 px-8">
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold mb-4">Informasi Pesanan</h3>
            <p><strong>Tanggal:</strong> {{ $order->created_at->format('d M Y H:i') }}</p>
            <p><strong>Status:</strong> {{ ucfirst($order->status) }}</p>
            <p><strong>Total Harga:</strong> Rp {{ number_format($order->total_price, 0, ',', '.') }}</p>

            <h4 class="mt-6 font-semibold text-gray-700">Item Pesanan:</h4>
            <ul class="mt-2 space-y-2">
                @foreach ($order->items as $item)
                    <li class="border-b pb-2">
                        {{ $item->product->name }} (x{{ $item->quantity }}) — 
                        Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}
                    </li>
                @endforeach
            </ul>

            <a href="{{ route('vendor.orders.index') }}" class="mt-6 inline-block text-indigo-600 hover:underline">
                ← Kembali ke daftar
            </a>
        </div>
    </div>
</x-app-layout>
