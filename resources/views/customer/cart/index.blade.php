<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Keranjang Belanja</h2>
    </x-slot>

    <div class="py-10 px-8">
        @if (count($cart) > 0)
            <table class="w-full bg-white rounded shadow">
                <thead>
                    <tr class="bg-gray-100 text-left">
                        <th class="p-3">Produk</th>
                        <th class="p-3">Harga</th>
                        <th class="p-3">Jumlah</th>
                        <th class="p-3">Subtotal</th>
                        <th class="p-3">Aksi</th>
                        <th class="p-3">Checkout</th>
                    </tr>
                </thead>
                <tbody>
                    @php $total = 0; @endphp
                    @foreach ($cart as $id => $item)
                        @php $subtotal = $item['price'] * $item['quantity']; $total += $subtotal; @endphp
                        <tr class="border-b">
                            <td class="p-3 flex items-center gap-3">
                                @if ($item['image'])
                                    <img src="{{ asset('storage/' . $item['image']) }}" class="w-16 h-16 object-cover rounded">
                                @endif
                                {{ $item['name'] }}
                            </td>
                            <td class="p-3">Rp {{ number_format($item['price'], 0, ',', '.') }}</td>
                            <td class="p-3">
                                <form action="{{ route('customer.cart.update', $id) }}" method="POST" class="flex items-center gap-2">
                                    @csrf
                                    @method('PATCH')
                                    <input type="number" name="quantity" value="{{ $item['quantity'] }}" min="1"
                                        class="w-16 border rounded text-center">
                                    <button type="submit" class="text-indigo-600 hover:underline">Update</button>
                                </form>
                            </td>
                            <td class="p-3">Rp {{ number_format($subtotal, 0, ',', '.') }}</td>
                            <td class="p-3">
                                <form action="{{ route('customer.cart.remove', $id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:underline">Hapus</button>
                                </form>
                            </td>
                            <td class="p-3">
                                <a href="{{ route('customer.cart.showCheckoutItem', $id) }}" class="text-indigo-600 hover:underline">Checkout</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="mt-6 text-right">
                <p class="text-lg font-semibold">Total: Rp {{ number_format($total, 0, ',', '.') }}</p>
                <a href="{{ route('customer.cart.showCheckout') }}" 
                class="mt-4 inline-block px-5 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">
                    Checkout Semua
                </a>
            </div>
        @else
            <p class="text-gray-600">Keranjang belanja masih kosong.</p>
        @endif
    </div>
</x-app-layout>
