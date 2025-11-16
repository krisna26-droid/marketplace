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

                {{-- Total Vendor --}}
                <a href="{{ route('admin.users.index', ['role' => 'vendor']) }}"
                    class="bg-white p-6 rounded-lg shadow hover:shadow-lg transition block">
                    <h4 class="text-gray-600 text-sm">Total Vendor</h4>
                    <p class="text-3xl font-bold text-blue-600 mt-2">
                        {{ \App\Models\User::where('role', 'vendor')->count() }}
                    </p>
                    <span class="text-sm text-blue-500 mt-3 inline-block">Lihat →</span>
                </a>

                {{-- Total Customer --}}
                <a href="{{ route('admin.users.index', ['role' => 'customer']) }}"
                    class="bg-white p-6 rounded-lg shadow hover:shadow-lg transition block">
                    <h4 class="text-gray-600 text-sm">Total Customer</h4>
                    <p class="text-3xl font-bold text-green-600 mt-2">
                        {{ \App\Models\User::where('role', 'customer')->count() }}
                    </p>
                    <span class="text-sm text-green-500 mt-3 inline-block">Lihat →</span>
                </a>

                {{-- Total Produk --}}
                <a href="{{ route('admin.products.index') }}"
                    class="bg-white p-6 rounded-lg shadow hover:shadow-lg transition block">
                    <h4 class="text-gray-600 text-sm">Total Produk</h4>
                    <p class="text-3xl font-bold text-indigo-600 mt-2">
                        {{ \App\Models\Product::count() }}
                    </p>
                    <span class="text-sm text-indigo-500 mt-3 inline-block">Kelola →</span>
                </a>

                {{-- Total Pesanan --}}
                <a href="{{ route('admin.orders.index') }}"
                    class="bg-white p-6 rounded-lg shadow hover:shadow-lg transition block">
                    <h4 class="text-gray-600 text-sm">Total Pesanan</h4>
                    <p class="text-3xl font-bold text-orange-600 mt-2">
                        {{ \App\Models\Order::count() }}
                    </p>
                    <span class="text-sm text-orange-500 mt-3 inline-block">Lihat →</span>
                </a>
            </div>

            {{-- Shortcut --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">

                <a href="{{ route('admin.products.index') }}" 
                   class="p-6 bg-white rounded-lg shadow hover:shadow-lg transition block">
                    <h4 class="text-lg font-semibold text-gray-800">Manajemen Produk</h4>
                    <p class="text-sm text-gray-600 mt-2">
                        Kelola semua produk marketplace.
                    </p>
                </a>

                <a href="{{ route('admin.users.index') }}"
                   class="p-6 bg-white rounded-lg shadow hover:shadow-lg transition block">
                    <h4 class="text-lg font-semibold text-gray-800">Data Pengguna</h4>
                    <p class="text-sm text-gray-600 mt-2">
                        Lihat dan kelola vendor & customer.
                    </p>
                </a>

                <a href="{{ route('admin.orders.index') }}"
                   class="p-6 bg-white rounded-lg shadow hover:shadow-lg transition block">
                    <h4 class="text-lg font-semibold text-gray-800">Manajemen Pesanan</h4>
                    <p class="text-sm text-gray-600 mt-2">
                        Pantau dan proses pesanan pelanggan.
                    </p>
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
