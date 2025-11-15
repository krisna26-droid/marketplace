<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Checkout Produk</h2>
    </x-slot>

    <div class="py-10 px-8 max-w-4xl mx-auto">

        <div class="bg-white rounded shadow p-6 mb-6">
            <h3 class="text-lg font-semibold mb-4">Ringkasan Pesanan</h3>

            <div class="py-2 flex justify-between">
                <span>{{ $item['name'] }} x {{ $item['quantity'] }}</span>
                <span>Rp {{ number_format($total, 0, ',', '.') }}</span>
            </div>

            <div class="mt-4 text-right font-bold text-lg">
                Total: Rp {{ number_format($total, 0, ',', '.') }}
            </div>
        </div>

        <form method="POST" action="{{ route('customer.cart.checkout') }}" class="bg-white rounded shadow p-6">
            @csrf
            <input type="hidden" name="checkout_type" value="single">
            <input type="hidden" name="product_id" value="{{ $item['id'] ?? $item['product_id'] ?? $itemId }}">


            <div class="mb-4">
                <label class="block text-gray-700">Alamat Pengiriman</label>
                <textarea name="shipping_address" class="w-full border rounded p-2" rows="3" required></textarea>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700">Metode Pembayaran</label>
                <select name="payment_method" class="w-full border rounded p-2" required>
                    <option value="cod">COD</option>
                    <option value="transfer">Transfer Bank</option>
                    <option value="ewallet">E-Wallet</option>
                </select>
            </div>

            <div class="flex justify-end">
                <button type="submit" class="px-5 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">
                    Buat Pesanan
                </button>
            </div>
        </form>
    </div>
</x-app-layout>
