<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Manajemen Pesanan Vendor
        </h2>
    </x-slot>

    <div class="py-10 px-8 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto">
            <h3 class="text-lg font-semibold mb-6">Daftar Pesanan Anda</h3>

            @if ($orders->isEmpty())
                <div class="bg-white p-6 rounded shadow text-center text-gray-600">
                    Belum ada pesanan untuk produk Anda.
                </div>
            @else
                <div class="bg-white rounded-lg shadow overflow-hidden">
                    <table class="min-w-full text-sm">
                        <table class="min-w-full text-sm text-gray-700 border border-gray-200 rounded-lg overflow-hidden">
                            <thead class="bg-gray-100 text-left">
                                <tr>
                                    <th class="px-6 py-3 font-semibold">ID Pesanan</th>
                                    <th class="px-6 py-3 font-semibold">Pelanggan</th>
                                    <th class="px-6 py-3 font-semibold">Tanggal</th>
                                    <th class="px-6 py-3 font-semibold">Total</th>
                                    <th class="px-6 py-3 font-semibold">Metode Pembayaran</th>
                                    <th class="px-6 py-3 font-semibold">Status Pembayaran</th>
                                    <th class="px-6 py-3 font-semibold">Status</th>
                                    <th class="px-6 py-3 font-semibold text-right">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-100">
                                @foreach ($orders as $order)
                                    <tr>
                                        <td class="px-6 py-4">#{{ $order->id }}</td>
                                        <td class="px-6 py-4">{{ $order->customer->name ?? '-' }}</td>
                                        <td class="px-6 py-4">{{ $order->created_at->format('d M Y') }}</td>
                                        <td class="px-6 py-4">Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
                                        <td class="px-6 py-4">{{ ucfirst($order->payment_method) }}</td>
                                        <td class="px-6 py-4">
                                            <span class="px-2 py-1 text-xs font-medium rounded 
                                                {{ $order->payment_status == 'paid' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">
                                                {{ ucfirst($order->payment_status) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4">
                                            <span class="px-2 py-1 text-xs font-medium rounded
                                                @if($order->status == 'completed') bg-green-100 text-green-700
                                                @elseif($order->status == 'cancelled') bg-red-100 text-red-700
                                                @elseif($order->status == 'processing') bg-blue-100 text-blue-700
                                                @else bg-gray-100 text-gray-700 @endif">
                                                {{ ucfirst($order->status) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 text-right">
                                            <a href="{{ route('vendor.orders.show', $order->id) }}" class="text-indigo-600 hover:underline">Detail</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </table>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
