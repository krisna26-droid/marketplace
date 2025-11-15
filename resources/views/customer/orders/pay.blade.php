<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Pembayaran Pesanan</h2>
    </x-slot>

    <div class="py-10 px-8 max-w-3xl mx-auto">
        <div class="bg-white shadow rounded-lg p-6 border border-gray-200">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Detail Pesanan #{{ $order->id }}</h3>

            <div class="space-y-2 text-gray-700 mb-6">
                <p><strong>Total:</strong> Rp {{ number_format($order->total_price, 0, ',', '.') }}</p>
                <p><strong>Status Pembayaran:</strong> <span class="text-yellow-600">{{ ucfirst($order->payment_status) }}</span></p>
                <p><strong>Alamat Pengiriman:</strong> {{ $order->shipping_address ?? '-' }}</p>
            </div>

            <form action="{{ route('customer.orders.pay', $order->id) }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm mb-2">Metode Pembayaran</label>
                    <select name="payment_method" class="w-full border-gray-300 rounded-md">
                        <option value="manual">Transfer Bank (Manual)</option>
                        <option value="cod">Bayar di Tempat (COD)</option>
                    </select>
                </div>

                <button type="submit" class="w-full py-2 bg-green-600 text-white rounded hover:bg-green-700 transition">
                    Konfirmasi Pembayaran
                </button>
            </form>
        </div>
    </div>
</x-app-layout>
