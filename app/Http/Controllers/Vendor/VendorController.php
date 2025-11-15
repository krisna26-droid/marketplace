<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class VendorController extends Controller
{
    public function index()
    {
        $vendor = Auth::user();

        // Hitung total produk milik vendor
        $totalProducts = Product::where('vendor_id', $vendor->id)->count();

        // Ambil order yang berisi produk milik vendor
        $orders = Order::whereHas('items.product', function ($query) use ($vendor) {
            $query->where('vendor_id', $vendor->id);
        })->get();

        $totalOrders = $orders->count();

        // Total pendapatan hanya dari order completed + paid
        $totalRevenue = $orders->where('status', 'completed')
                               ->where('payment_status', 'paid')
                               ->sum('total_price');

        return view('vendor.dashboard', compact('totalProducts', 'totalOrders', 'totalRevenue'));
    }
}
