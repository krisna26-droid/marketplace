<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Review;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Order;
use App\Models\Customer;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    // Membuat review
    public function create(OrderItem $orderItem)
    {
        $product = $orderItem->product;
        return view('customer.reviews.create', compact('orderItem'));
    }
    public function store(Request $request, OrderItem $orderItem)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ]);

        // Pastikan customer adalah pemilik order
        if ($orderItem->order->customer_id !== auth()->id()) {
            abort(403, 'Tidak boleh mereview pesanan orang lain!');
        }

        // Pastikan pesanan selesai
        if ($orderItem->order->status !== 'completed') {
            return back()->with('error', 'Review hanya bisa diberikan setelah pesanan selesai.');
        }

        // Cegah double review (1 order_item hanya boleh 1 review)
        if (Review::where('order_item_id', $orderItem->id)->exists()) {
            return back()->with('error', 'Anda sudah memberi review untuk produk ini.');
        }

        // Simpan review
        Review::create([
            'order_id'      => $orderItem->order_id,
            'order_item_id' => $orderItem->id,
            'product_id'    => $orderItem->product_id,
            'customer_id'   => auth()->id(),
            'rating'        => $request->rating,
            'comment'       => $request->comment,
        ]);

        return back()->with('success', 'Review berhasil dikirim!');
    }

    public function index(Product $product)
    {
        $reviews = $product->reviews()
            ->latest()
            ->paginate(10);

        return view('customer.reviews.index', compact('product', 'reviews'));
    }

    
}
