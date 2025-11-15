<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Detail Pesanan #{{ $order->id }}</h2>
    </x-slot>

    <div class="py-10 px-8 space-y-6">
        {{-- Informasi utama --}}
        <div class="bg-white rounded shadow p-6">
            <h3 class="text-lg font-semibold mb-4">Informasi Pesanan</h3>
            <p><strong>Pelanggan:</strong> {{ $order->customer->name ?? '-' }}</p>
            <p><strong>Alamat Pengiriman:</strong> {{ $order->shipping_address ?? '-' }}</p>
            <p><strong>Metode Pembayaran:</strong> {{ ucfirst($order->payment_method) }}</p>
            <p><strong>Status Pembayaran:</strong>
                <span class="px-2 py-1 rounded text-xs font-semibold 
                    {{ $order->payment_status === 'paid' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">
                    {{ ucfirst($order->payment_status) }}
                </span>
            </p>
            <p><strong>Status Pesanan:</strong>
                <span class="px-2 py-1 rounded text-xs font-semibold 
                    {{ $order->status === 'completed' ? 'bg-green-100 text-green-700' :
                       ($order->status === 'processing' ? 'bg-blue-100 text-blue-700' :
                       ($order->status === 'cancelled' ? 'bg-red-100 text-red-700' : 'bg-yellow-100 text-yellow-700')) }}">
                    {{ ucfirst($order->status) }}
                </span>
            </p>
        </div>

        {{-- Daftar item --}}
        <div class="bg-white rounded shadow p-6">
            <h3 class="text-lg font-semibold mb-4">Daftar Produk</h3>
            <table class="w-full text-sm border">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="p-2 text-left">Produk</th>
                        <th class="p-2 text-right">Harga</th>
                        <th class="p-2 text-center">Jumlah</th>
                        <th class="p-2 text-right">Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($order->items as $item)
                        <tr class="border-t">
                            <td class="p-2">{{ $item->product->name ?? '-' }}</td>
                            <td class="p-2 text-right">Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                            <td class="p-2 text-center">{{ $item->quantity }}</td>
                            <td class="p-2 text-right">
                                Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot class="font-semibold bg-gray-50">
                    <tr>
                        <td colspan="3" class="p-2 text-right">Total</td>
                        <td class="p-2 text-right">Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
                    </tr>
                </tfoot>
            </table>
        </div>

        {{-- Form update status --}}
        <div class="bg-white rounded shadow p-6">
            <h3 class="text-lg font-semibold mb-4">Perbarui Status</h3>
            <form action="{{ route('admin.orders.update', $order->id) }}" method="POST" class="flex flex-col md:flex-row gap-4">
                @csrf
                @method('PUT')
                <div>
                    <label class="block mb-1 text-sm font-medium">Status Pesanan</label>
                    <select name="status" class="border rounded px-3 py-2">
                        <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>Processing</option>
                        <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }}>Completed</option>
                        <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                    </select>
                </div>

                <div>
                    <label class="block mb-1 text-sm font-medium">Status Pembayaran</label>
                    <select name="payment_status" class="border rounded px-3 py-2">
                        <option value="unpaid" {{ $order->payment_status == 'unpaid' ? 'selected' : '' }}>Unpaid</option>
                        <option value="paid" {{ $order->payment_status == 'paid' ? 'selected' : '' }}>Paid</option>
                    </select>
                </div>

                <button type="submit" class="self-end px-5 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">
                    Simpan Perubahan
                </button>
            </form>
        </div>
    </div>
</x-app-layout>
