<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $totalUsers = User::count();
        $totalVendors = User::where('role', 'vendor')->count();
        $totalProducts = Product::count();
        $totalOrders = Order::count();


        $startDate = $request->get('start_date', Carbon::now()->startOfMonth()->toDateString());
        $endDate = $request->get('end_date', Carbon::now()->endOfMonth()->toDateString());

        $orders = Order::whereBetween('created_at', [$startDate, $endDate])->get();

        $totalRevenue = $orders
            ->where('status', 'completed')
            ->where('payment_status', 'paid')
            ->sum('total_price');
        $totalOrders = $orders->count();
        $statusSummary = $orders->groupBy('status')->map->count();

        $topProducts = OrderItem::with('product')
            ->selectRaw('product_id, SUM(quantity) as total_sold')
            ->groupBy('product_id')
            ->orderByDesc('total_sold')
            ->take(5)
            ->get();

        $topVendors = User::where('role', 'vendor')
            ->withCount(['products as total_products'])
            ->orderByDesc('total_products')
            ->take(5)
            ->get();

        return view('admin.reports.index', compact(
            'totalRevenue', 'totalOrders', 'statusSummary',
            'topProducts', 'topVendors', 'startDate', 'endDate',
            'totalUsers', 'totalVendors', 'totalProducts'
        ));
    }
}
