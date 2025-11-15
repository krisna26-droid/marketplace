<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;
use App\Models\OrderItem;

class CartController extends Controller
{
    public function index()
    {
        $cart = Session::get('cart', []);
        return view('customer.cart.index', compact('cart'));
    }

    public function update(Request $request, Product $product)
    {
        $cart = Session::get('cart', []);

        if (isset($cart[$product->id])) {

            $newQty = max(1, (int)$request->quantity);

            // Cek stok
            if ($product->stock < $newQty) {
                return redirect()->back()->with('error', 'Stok tidak mencukupi.');
            }

            $cart[$product->id]['quantity'] = $newQty;
            Session::put('cart', $cart);
        }

        return redirect()->route('customer.cart.index')->with('success', 'Jumlah produk diperbarui.');
    }

    public function add(Request $request, Product $product)
    {
        $cart = Session::get('cart', []);

        if (isset($cart[$product->id])) {

            $newQty = $cart[$product->id]['quantity'] + 1;

            // Cek stok
            if ($product->stock < $newQty) {
                return redirect()->back()->with('error', 'Stok tidak mencukupi.');
            }

            $cart[$product->id]['quantity'] = $newQty;

        } else {

            if ($product->stock < 1) {
                return redirect()->back()->with('error', 'Stok produk habis.');
            }

            $cart[$product->id] = [
                'name' => $product->name,
                'price' => $product->price,
                'quantity' => 1,
                'image' => $product->image,
            ];
        }

        Session::put('cart', $cart);
        return redirect()->back()->with('success', 'Produk ditambahkan ke keranjang.');
    }

    public function remove(Product $product)
    {
        $cart = Session::get('cart', []);

        if (isset($cart[$product->id])) {
            unset($cart[$product->id]);
            Session::put('cart', $cart);
        }

        return redirect()->route('customer.cart.index')->with('success', 'Produk dihapus dari keranjang.');
    }

    public function checkout(Request $request)
    {
        $cart = Session::get('cart', []);

        if (empty($cart)) {
            return redirect()->route('customer.cart.index')->with('error', 'Keranjang masih kosong.');
        }

        $request->validate([
            'shipping_address' => 'required|string|max:255',
            'payment_method' => 'required|string',
        ]);

        $checkoutType = $request->input('checkout_type', 'all');

        /* Checkout Single */
        if ($checkoutType === 'single') {

            $productId = $request->product_id;

            if (!isset($cart[$productId])) {
                return redirect()->back()->with('error', 'Produk tidak ditemukan di keranjang.');
            }

            $item = $cart[$productId];
            $total = $item['price'] * $item['quantity'];

            $product = Product::find($productId);

            if (!$product) {
                return redirect()->back()->with('error', 'Produk tidak ditemukan.');
            }

            if ($product->stock < $item['quantity']) {
                return redirect()->back()->with('error', 'Stok produk tidak mencukupi.');
            }

            $order = Order::create([
                'customer_id' => auth()->id(),
                'total_price' => $total,
                'status' => 'pending',
                'payment_status' => 'pending',
                'payment_method' => $request->payment_method,
                'shipping_address' => $request->shipping_address,
            ]);

            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $productId,
                'quantity' => $item['quantity'],
                'price' => $item['price'],
            ]);

            $product->stock -= $item['quantity'];
            $product->save();

            unset($cart[$productId]);
            Session::put('cart', $cart);

            return redirect()->route('customer.orders.index')->with('success', 'Pesanan berhasil dibuat.');
        }

        /* Checkout Semua */
        foreach ($cart as $productId => $item) {
            $product = Product::find($productId);

            if (!$product) {
                return redirect()->back()->with('error', 'Produk tidak ditemukan.');
            }

            if ($product->stock < $item['quantity']) {
                return redirect()->back()->with('error', 'Stok produk ' . $product->name . ' tidak mencukupi.');
            }
        }

        $total = collect($cart)->sum(function ($item) {
            return $item['price'] * $item['quantity'];
        });

        $order = Order::create([
            'customer_id' => auth()->id(),
            'total_price' => $total,
            'status' => 'pending',
            'payment_status' => 'pending',
            'payment_method' => $request->payment_method,
            'shipping_address' => $request->shipping_address,
        ]);

        foreach ($cart as $productId => $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $productId,
                'quantity' => $item['quantity'],
                'price' => $item['price'],
            ]);

            $product = Product::find($productId);
            $product->stock -= $item['quantity'];
            $product->save();
        }

        Session::forget('cart');

        return redirect()->route('customer.orders.index')->with('success', 'Pesanan berhasil dibuat.');
    }
}
