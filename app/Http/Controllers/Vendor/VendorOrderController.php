<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class VendorOrderController extends Controller
{
    public function index()
    {
        $vendor = Auth::user();

        // Ambil semua order yang memiliki produk dari vendor login
        $orders = Order::with(['customer', 'items.product'])
            ->whereHas('items.product', function ($query) use ($vendor) {
                $query->where('vendor_id', $vendor->id);
            })
            ->latest()
            ->get();

        return view('vendor.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        $this->authorize('view', $order);

        $order->load(['customer', 'items.product']);

        return view('vendor.orders.show', compact('order'));
    }
}
