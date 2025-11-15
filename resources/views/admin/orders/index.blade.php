<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Manajemen Pesanan
        </h2>
    </x-slot>

    <div class="py-10 px-8">
        <h3 class="text-lg font-semibold mb-6">Daftar Pesanan</h3>
        <table class="w-full bg-white shadow rounded-lg overflow-hidden">
            <thead class="bg-gray-100">
                <tr class="text-left">
                    <th class="px-4 py-2">ID</th>
                    <th class="px-4 py-2">Pelanggan</th>
                    <th class="px-4 py-2">Total</th>
                    <th class="px-4 py-2">Metode Pembayaran</th>
                    <th class="px-4 py-2">Status Pembayaran</th>
                    <th class="px-4 py-2">Status</th>
                    <th class="px-4 py-2">Tanggal</th>
                    <th class="px-4 py-2 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($orders as $order)
                    <tr class="border-t">
                        <td class="px-4 py-2">#{{ $order->id }}</td>
                        <td class="px-4 py-2">{{ $order->customer->name ?? '-' }}</td>
                        <td class="px-4 py-2">Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
                        <td class="px-4 py-2">{{ $order->payment_method ?? '-' }}</td>
                        <td class="px-4 py-2">
                            <span class="px-2 py-1 rounded text-xs font-semibold
                                {{ $order->payment_status == 'paid' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">
                                {{ ucfirst($order->payment_status) }}
                            </span>
                        </td>
                        <td class="px-4 py-2">
                            <span class="px-2 py-1 rounded text-xs font-semibold
                                {{ $order->status == 'completed' ? 'bg-green-100 text-green-700' :
                                   ($order->status == 'processing' ? 'bg-blue-100 text-blue-700' :
                                   ($order->status == 'cancelled' ? 'bg-red-100 text-red-700' : 'bg-yellow-100 text-yellow-700')) }}">
                                {{ ucfirst($order->status) }}
                            </span>
                        </td>
                        <td class="px-4 py-2">{{ $order->created_at->format('d M Y') }}</td>
                        <td class="px-4 py-2 text-center">
                            <a href="{{ route('admin.orders.show', $order->id) }}" class="text-indigo-600 hover:underline">Detail</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center py-4 text-gray-600">Belum ada pesanan.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="mt-6">
            {{ $orders->links() }}
        </div>
    </div>
</x-app-layout>
