<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Pesanan Saya</h2>
    </x-slot>

    <div class="py-10 px-8">
        @forelse ($orders as $order)
            <div class="bg-white w-full p-5 rounded shadow-sm mb-4 flex justify-between items-center border border-gray-200">
                <div>
                    <p class="font-semibold text-gray-700">#{{ $order->id }}</p>
                    <p class="text-sm text-gray-500">Pembayaran: 
                        <span class="{{ $order->payment_status === 'paid' ? 'text-green-600' : 'text-yellow-600' }}">
                            {{ ucfirst($order->payment_status ?? 'unpaid') }}
                        </span>
                    </p>
                    <p class="text-sm text-gray-500">Total: 
                        <span class="font-semibold text-gray-800">
                            Rp {{ number_format($order->total_price, 0, ',', '.') }}
                        </span>
                    </p>
                </div>
                <div class="flex items-center gap-2">
                    <a href="{{ route('customer.orders.show', $order->id) }}" class="text-sm text-indigo-600 hover:underline">Lihat Detail</a>

                    @if($order->payment_status !== 'paid' && strtolower($order->status) === 'pending')
                        <a href="{{ route('customer.orders.pay.show', $order->id) }}" 
                           class="px-3 py-1 bg-green-600 text-white text-sm rounded hover:bg-green-700">
                           Bayar Sekarang
                        </a>
                    @endif

                    @if(strtolower($order->status) === 'pending')
                        <form action="{{ route('customer.orders.cancel', $order->id) }}" method="POST" class="inline">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="px-3 py-1 bg-red-600 text-white text-sm rounded hover:bg-red-700">Batalkan</button>
                        </form>
                    @endif
                </div>
            </div>
        @empty
            <p class="text-gray-600 text-center mt-10">Belum ada pesanan.</p>
        @endforelse
    </div>
</x-app-layout>
