<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Edit User
        </h2>
    </x-slot>

    <div class="py-10 px-8 max-w-3xl mx-auto">

        <form method="POST" action="{{ route('admin.users.update', $user->id) }}" class="bg-white p-6 rounded-lg shadow">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Nama</label>
                <input type="text" name="name" value="{{ old('name', $user->name) }}"
                    class="w-full mt-1 border-gray-300 rounded-lg">
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Email</label>
                <input type="email" name="email" value="{{ old('email', $user->email) }}"
                    class="w-full mt-1 border-gray-300 rounded-lg">
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Role</label>
                <select name="role" class="w-full mt-1 border-gray-300 rounded-lg">
                    <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Admin</option>
                    <option value="vendor" {{ $user->role === 'vendor' ? 'selected' : '' }}>Vendor</option>
                    <option value="customer" {{ $user->role === 'customer' ? 'selected' : '' }}>Customer</option>
                </select>
            </div>

            {{-- FORM CUSTOMER --}}
            @if($user->role === 'customer')
            @php
                $c = $user->customer;
            @endphp

            <div class="mt-6 p-4 bg-gray-50 rounded-lg border">
                <h3 class="font-semibold text-gray-800 mb-3">Data Customer</h3>

                <div class="mb-3">
                    <label class="block text-sm">Alamat</label>
                    <input type="text" name="address" value="{{ old('address', $c->address ?? '') }}"
                        class="w-full mt-1 border-gray-300 rounded-lg">
                </div>

                <div class="mb-3">
                    <label class="block text-sm">No. HP</label>
                    <input type="text" name="phone" value="{{ old('phone', $c->phone ?? '') }}"
                        class="w-full mt-1 border-gray-300 rounded-lg">
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                    <div>
                        <label class="block text-sm">Kota</label>
                        <input type="text" name="city" value="{{ old('city', $c->city ?? '') }}"
                            class="w-full mt-1 border-gray-300 rounded-lg">
                    </div>
                    <div>
                        <label class="block text-sm">Provinsi</label>
                        <input type="text" name="province" value="{{ old('province', $c->province ?? '') }}"
                            class="w-full mt-1 border-gray-300 rounded-lg">
                    </div>
                    <div>
                        <label class="block text-sm">Kode Pos</label>
                        <input type="text" name="postal_code" value="{{ old('postal_code', $c->postal_code ?? '') }}"
                            class="w-full mt-1 border-gray-300 rounded-lg">
                    </div>
                </div>
            </div>
            @endif

            <div class="mt-6 text-right">
                <button type="submit"
                    class="px-6 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition">
                    Simpan Perubahan
                </button>
            </div>

        </form>
    </div>
</x-app-layout>
