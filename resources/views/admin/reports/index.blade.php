<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Laporan Penjualan</h2>
    </x-slot>

    <div class="py-10 px-8">
        <form method="GET" class="mb-6 flex gap-3 items-center">
            <input type="date" name="start_date" value="{{ $startDate }}" class="border rounded px-3 py-2">
            <span>-</span>
            <input type="date" name="end_date" value="{{ $endDate }}" class="border rounded px-3 py-2">
            <button class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">Terapkan</button>
        </form>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <div class="bg-white p-6 rounded shadow text-center">
                <h4 class="text-gray-600">Total Pengguna</h4>
                <p class="text-2xl font-bold text-indigo-600 mt-2">{{ $totalUsers }}</p>
            </div>
            <div class="bg-white p-6 rounded shadow text-center">
                <h4 class="text-gray-600">Total Vendor</h4>
                <p class="text-2xl font-bold text-blue-600 mt-2">{{ $totalVendors }}</p>
            </div>
            <div class="bg-white p-6 rounded shadow text-center">
                <h4 class="text-gray-600">Total Produk</h4>
                <p class="text-2xl font-bold text-green-600 mt-2">{{ $totalProducts }}</p>
            </div>
            <div class="bg-white p-6 rounded shadow text-center">
                <h4 class="text-gray-600">Total Pendapatan</h4>
                <p class="text-2xl font-bold text-green-600 mt-2">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</p>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <div class="bg-white p-6 rounded shadow text-center">
                <h4 class="text-gray-600">Total Pesanan</h4>
                <p class="text-2xl font-bold text-indigo-600 mt-2">{{ $totalOrders }}</p>
            </div>
            @foreach($statusSummary as $status => $count)
                <div class="bg-white p-6 rounded shadow text-center">
                    <h4 class="text-gray-600 capitalize">{{ $status }}</h4>
                    <p class="text-2xl font-bold text-gray-800 mt-2">{{ $count }}</p>
                </div>
            @endforeach
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <div class="bg-white p-6 rounded shadow">
                <h3 class="font-semibold mb-4">Produk Terlaris</h3>
                <table class="w-full text-sm">
                    <thead class="bg-gray-100 text-left">
                        <tr><th class="p-2">Produk</th><th class="p-2">Terjual</th></tr>
                    </thead>
                    <tbody>
                        @foreach($topProducts as $item)
                            <tr class="border-t">
                                <td class="p-2">{{ $item->product->name ?? '-' }}</td>
                                <td class="p-2">{{ $item->total_sold }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="bg-white p-6 rounded shadow">
                <h3 class="font-semibold mb-4">Vendor Teraktif</h3>
                <table class="w-full text-sm">
                    <thead class="bg-gray-100 text-left">
                        <tr><th class="p-2">Vendor</th><th class="p-2">Jumlah Produk</th></tr>
                    </thead>
                    <tbody>
                        @foreach($topVendors as $vendor)
                            <tr class="border-t">
                                <td class="p-2">{{ $vendor->name }}</td>
                                <td class="p-2">{{ $vendor->total_products }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
