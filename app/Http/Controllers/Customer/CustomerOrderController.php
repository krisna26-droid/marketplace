<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class CustomerOrderController extends Controller
{
    public function index()
    {
        // Ambil semua pesanan milik customer yang sedang login
        $orders = Order::where('customer_id', Auth::id())
            ->latest()
            ->get();

        return view('customer.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        // Pastikan customer hanya bisa melihat pesanan miliknya
        if ($order->customer_id !== Auth::id()) {
            abort(403, 'Akses ditolak.');
        }

        return view('customer.orders.show', compact('order'));
    }

    public function cancel(Order $order)
    {
        if ($order->customer_id !== Auth::id()) {
            abort(403, 'Akses ditolak.');
        }

        if (strtolower($order->status) !== 'pending') {
            return back()->with('error', 'Pesanan tidak dapat dibatalkan.');
        }

        $order->update(['status' => 'cancelled']);

        return redirect()->route('customer.orders.index')
            ->with('success', 'Pesanan berhasil dibatalkan.');
    }

    public function pay(Order $order)
    {
        // Pastikan hanya pemilik order yang bisa membayar
        if ($order->customer_id !== Auth::id()) {
            abort(403, 'Akses ditolak.');
        }

        // Cegah pembayaran ulang
        if ($order->payment_status === 'paid') {
            return back()->with('error', 'Pesanan ini sudah dibayar.');
        }

        $validated = request()->validate([
            'payment_method' => 'required|string',
        ]);

        // Update status pembayaran & order
        $order->update([
            'payment_status' => 'paid',
            'status' => 'completed',
            'payment_method' => 'manual',
        ]);

        return redirect()->route('customer.orders.index')
            ->with('success', 'Pembayaran berhasil! Terima kasih.');
    }

    public function showPayment(Order $order)
    {
        if ($order->customer_id !== Auth::id()) {
            abort(403, 'Akses ditolak.');
        }

        if ($order->payment_status === 'paid') {
            return redirect()->route('customer.orders.index')
                ->with('error', 'Pesanan ini sudah dibayar.');
        }

        return view('customer.orders.pay', compact('order'));
    }

}
