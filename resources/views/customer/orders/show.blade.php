<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Detail Pesanan</h2>
    </x-slot>

    <div class="py-10 px-8 max-w-4xl mx-auto">
        <div class="bg-white p-6 rounded shadow-sm border border-gray-200">
            <div class="mb-5">
                <h3 class="text-lg font-semibold text-gray-800 mb-1">Pesanan #{{ $order->id }}</h3>
                <p class="text-sm text-gray-500">Status: 
                    <span class="font-medium text-indigo-600">{{ ucfirst($order->status) }}</span>
                </p>
                <p class="text-sm text-gray-500">Pembayaran: 
                    <span class="{{ $order->payment_status === 'paid' ? 'text-green-600' : 'text-yellow-600' }}">
                        {{ ucfirst($order->payment_status ?? 'unpaid') }}
                    </span>
                </p>
                <p class="text-sm text-gray-500">Total Harga: 
                    <span class="font-semibold text-gray-800">Rp {{ number_format($order->total_price, 0, ',', '.') }}</span>
                </p>
                <p class="text-sm text-gray-500">Metode Pembayaran: {{ $order->payment_method ?? '-' }}</p>
                <p class="text-sm text-gray-500">Alamat Pengiriman: {{ $order->shipping_address ?? '-' }}</p>
            </div>

            <h4 class="font-semibold text-gray-800 mb-2">Item Pesanan</h4>
            <table class="w-full border-t border-b text-sm">
                <thead class="bg-gray-100 text-gray-700">
                    <tr>
                        <th class="p-2 text-left">Produk</th>
                        <th class="p-2 text-left">Jumlah</th>
                        <th class="p-2 text-left">Harga</th>
                        <th class="p-2 text-left">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($order->items as $item)
                        <tr class="border-t">
                            <td class="p-2 text-gray-700">{{ $item->product->name ?? '-' }}</td>
                            <td class="p-2 text-gray-700">{{ $item->quantity }}</td>
                            <td class="p-2 text-gray-700">Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                            <td class="p-2 text-sm">
                                @php
                                    $reviewed = \App\Models\Review::where('customer_id', auth()->id())
                                        ->where('product_id', $item->product_id)
                                        ->exists();
                                @endphp

                                @if ($order->status === 'completed')
                                    @if (!$reviewed)
                                        <a href="{{ route('customer.reviews.create', $item->product_id) }}"
                                            class="text-indigo-600 hover:underline">
                                            Tulis Review
                                        </a>
                                    @else
                                        <span class="text-green-600">Sudah direview</span>
                                    @endif
                                @else
                                    <span class="text-gray-400">Menunggu selesai</span>
                                @endif

                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="mt-6 flex justify-between items-center">
                <a href="{{ route('customer.orders.index') }}" class="text-sm text-indigo-600 hover:underline">
                    ← Kembali ke Daftar Pesanan
                </a>

                @if (strtolower($order->status) === 'pending')
                    <form method="POST" action="{{ route('customer.orders.cancel', $order->id) }}">
                        @csrf
                        @method('PATCH')
                        <button type="submit" onclick="return confirm('Batalkan pesanan ini?')" 
                            class="px-4 py-2 bg-red-600 text-white text-sm rounded hover:bg-red-700">
                            Batalkan Pesanan
                        </button>
                    </form>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
