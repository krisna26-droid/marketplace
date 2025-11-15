<x-app-layout> 
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Dashboard Admin
        </h2>
    </x-slot>

    <div class="py-12 px-8 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto">
            {{-- Ringkasan data utama --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
                <div class="bg-white p-6 rounded-lg shadow hover:shadow-lg transition">
                    <h4 class="text-gray-600 text-sm">Total Kategori</h4>
                    <p class="text-3xl font-bold text-indigo-600 mt-2">
                        {{ \App\Models\Category::count() }}
                    </p>
                    <a href="{{ route('admin.categories.index') }}" class="text-sm text-indigo-500 mt-3 inline-block">Kelola →</a>
                </div>

                <div class="bg-white p-6 rounded-lg shadow hover:shadow-lg transition">
                    <h4 class="text-gray-600 text-sm">Total Produk</h4>
                    <p class="text-3xl font-bold text-green-600 mt-2">
                        {{ \App\Models\Product::count() }}
                    </p>
                    <a href="{{ route('admin.products.index') }}" class="text-sm text-green-500 mt-3 inline-block">Kelola →</a>
                </div>

                <div class="bg-white p-6 rounded-lg shadow hover:shadow-lg transition">
                    <h4 class="text-gray-600 text-sm">Total Vendor</h4>
                    <p class="text-3xl font-bold text-blue-600 mt-2">
                        {{ \App\Models\User::where('role', 'vendor')->count() }}
                    </p>
                    <a href="{{ route('admin.users.index') }}" class="text-sm text-blue-500 mt-3 inline-block">Lihat →</a>
                </div>

                <div class="bg-white p-6 rounded-lg shadow hover:shadow-lg transition">
                    <h4 class="text-gray-600 text-sm">Total Pesanan</h4>
                    <p class="text-3xl font-bold text-orange-600 mt-2">
                        {{ \App\Models\Order::count() }}
                    </p>
                    <a href="{{ route('admin.orders.index') }}" class="text-sm text-orange-500 mt-3 inline-block">Lihat →</a>
                </div>
            </div>

            {{-- Shortcut aksi cepat --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                <a href="{{ route('admin.categories.index') }}" class="p-6 bg-white rounded-lg shadow hover:shadow-lg transition">
                    <h4 class="text-lg font-semibold text-gray-800">Manajemen Kategori</h4>
                    <p class="text-sm text-gray-600 mt-2">Tambah, ubah, atau hapus kategori produk.</p>
                </a>

                <a href="{{ route('admin.products.index') }}" class="p-6 bg-white rounded-lg shadow hover:shadow-lg transition">
                    <h4 class="text-lg font-semibold text-gray-800">Manajemen Produk</h4>
                    <p class="text-sm text-gray-600 mt-2">Kelola daftar produk dari vendor.</p>
                </a>

                <a href="{{ route('admin.users.index') }}" class="p-6 bg-white rounded-lg shadow hover:shadow-lg transition">
                    <h4 class="text-lg font-semibold text-gray-800">Data Pengguna</h4>
                    <p class="text-sm text-gray-600 mt-2">Lihat dan kelola akun vendor & customer.</p>
                </a>

                <a href="{{ route('admin.orders.index') }}" class="p-6 bg-white rounded-lg shadow hover:shadow-lg transition">
                    <h4 class="text-lg font-semibold text-gray-800">Manajemen Pesanan</h4>
                    <p class="text-sm text-gray-600 mt-2">Pantau dan proses pesanan pelanggan.</p>
                </a>

                <a href="{{ route('admin.reports.index') ?? '#' }}" class="p-6 bg-white rounded-lg shadow hover:shadow-lg transition">
                    <h4 class="text-lg font-semibold text-gray-800">Laporan Penjualan</h4>
                    <p class="text-sm text-gray-600 mt-2">Lihat data statistik dan performa penjualan.</p>
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
