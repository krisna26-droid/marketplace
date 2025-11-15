<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Manajemen Pengguna
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow sm:rounded-lg p-6">
                <h2 class="text-lg font-semibold mb-6">Tambah User Baru</h2>

                {{-- Tampilkan pesan error jika ada --}}
                @if ($errors->any())
                    <div class="mb-4 p-4 bg-red-100 text-red-700 rounded-lg">
                        <ul class="list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                {{-- Form tambah user --}}
                <form action="{{ route('admin.users.store') }}" method="POST" class="space-y-5">
                    @csrf

                    {{-- Nama --}}
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700">Nama</label>
                        <input type="text" name="name" id="name"
                            value="{{ old('name') }}"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                            required>
                    </div>

                    {{-- Email --}}
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                        <input type="email" name="email" id="email"
                            value="{{ old('email') }}"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                            required>
                    </div>

                    {{-- Password --}}
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                        <input type="password" name="password" id="password"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                            required>
                    </div>

                    {{-- Role --}}
                    <div>
                        <label for="role" class="block text-sm font-medium text-gray-700">Role</label>
                        <select name="role" id="role"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                            required>
                            <option value="">-- Pilih Role --</option>
                            <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                            <option value="vendor" {{ old('role') == 'vendor' ? 'selected' : '' }}>Vendor</option>
                            <option value="customer" {{ old('role') == 'customer' ? 'selected' : '' }}>Customer</option>
                        </select>
                    </div>

                    {{-- Form Khusus Customer --}}
                    <div id="customer-fields" class="hidden mt-6 bg-gray-50 p-4 rounded-lg border border-gray-200">
                        <h3 class="text-md font-medium mb-3">Data Customer</h3>

                        <div class="mb-3">
                            <label for="address" class="block text-sm font-medium text-gray-700">Alamat</label>
                            <input type="text" name="address" id="address"
                                value="{{ old('address') }}"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                        </div>

                        <div class="mb-3">
                            <label for="phone" class="block text-sm font-medium text-gray-700">Nomor Telepon</label>
                            <input type="text" name="phone" id="phone"
                                value="{{ old('phone') }}"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                        </div>

                        <div class="mb-3">
                            <label for="city" class="block text-sm font-medium text-gray-700">Kota</label>
                            <input type="text" name="city" id="city"
                                value="{{ old('city') }}"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                        </div>

                        <div class="mb-3">
                            <label for="province" class="block text-sm font-medium text-gray-700">Provinsi</label>
                            <input type="text" name="province" id="province"
                                value="{{ old('province') }}"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                        </div>

                        <div class="mb-3">
                            <label for="postal_code" class="block text-sm font-medium text-gray-700">Kode Pos</label>
                            <input type="text" name="postal_code" id="postal_code"
                                value="{{ old('postal_code') }}"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                        </div>
                    </div>

                    {{-- Tombol --}}
                    <div class="flex items-center justify-end space-x-3 pt-4">
                        <a href="{{ route('admin.users.index') }}"
                           class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300">
                           Batal
                        </a>
                        <button type="submit"
                                class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">
                            Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Script untuk toggle customer fields --}}
    <script>
        const roleSelect = document.getElementById('role');
        const customerFields = document.getElementById('customer-fields');

        function toggleCustomerFields() {
            if (roleSelect.value === 'customer') {
                customerFields.classList.remove('hidden');
            } else {
                customerFields.classList.add('hidden');
            }
        }

        // Jalankan saat page load untuk old value
        toggleCustomerFields();

        // Jalankan saat role diubah
        roleSelect.addEventListener('change', toggleCustomerFields);
    </script>
</x-app-layout>
