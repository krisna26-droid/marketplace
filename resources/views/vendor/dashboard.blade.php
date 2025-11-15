<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Dashboard Vendor
        </h2>
    </x-slot>

    <div class="py-10 px-8 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto">
            {{-- Statistik Produk & Pesanan --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-10">
                {{-- Total Produk --}}
                <div class="bg-white p-6 rounded-lg shadow hover:shadow-lg transition">
                    <h4 class="text-gray-600 text-sm">Total Produk</h4>
                    <p class="text-3xl font-bold text-indigo-600 mt-2">
                        {{ $totalProducts }}
                    </p>
                    <a href="{{ route('vendor.products.index') }}" class="text-sm text-indigo-500 mt-3 inline-block">Kelola →</a>
                </div>

                {{-- Total Pesanan --}}
                <div class="bg-white p-6 rounded-lg shadow hover:shadow-lg transition">
                    <h4 class="text-gray-600 text-sm">Total Pesanan</h4>
                    <p class="text-3xl font-bold text-green-600 mt-2">
                        {{ $totalOrders }}
                    </p>
                    <a href="{{ route('vendor.orders.index') }}" class="text-sm text-green-500 mt-3 inline-block">Lihat →</a>
                </div>

                {{-- Total Pendapatan --}}
                <div class="bg-white p-6 rounded-lg shadow hover:shadow-lg transition">
                    <h4 class="text-gray-600 text-sm">Total Pendapatan</h4>
                    <p class="text-3xl font-bold text-orange-600 mt-2">
                        Rp {{ number_format($totalRevenue, 0, ',', '.') }}
                    </p>
                    <a href="{{ route('vendor.orders.index') }}" class="text-sm text-orange-500 mt-3 inline-block">Detail →</a>
                </div>
            </div>

            {{-- Aksi cepat --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                <a href="{{ route('vendor.products.index') }}" class="p-6 bg-white rounded-lg shadow hover:shadow-lg transition">
                    <h4 class="text-lg font-semibold text-gray-800">Produk Saya</h4>
                    <p class="text-sm text-gray-600 mt-2">Kelola produk yang Anda jual di marketplace.</p>
                </a>

                <a href="{{ route('vendor.products.create') }}" class="p-6 bg-white rounded-lg shadow hover:shadow-lg transition">
                    <h4 class="text-lg font-semibold text-gray-800">Tambah Produk Baru</h4>
                    <p class="text-sm text-gray-600 mt-2">Tambahkan produk baru ke toko Anda.</p>
                </a>

                <a href="{{ route('vendor.orders.index') }}" class="p-6 bg-white rounded-lg shadow hover:shadow-lg transition">
                    <h4 class="text-lg font-semibold text-gray-800">Pesanan Masuk</h4>
                    <p class="text-sm text-gray-600 mt-2">Lihat dan kelola pesanan dari pelanggan.</p>
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
