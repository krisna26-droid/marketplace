<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;

class VendorController extends Controller
{
    public function index()
    {
        $vendors = User::where('is_vendor', true)->get();
        return view('admin.vendors.index', compact('vendors'));
    }

    public function approve($id)
    {
        User::where('id', $id)->update(['vendor_status' => 'approved']);
        return back()->with('success', 'Vendor disetujui.');
    }

    public function reject($id)
    {
        User::where('id', $id)->update(['vendor_status' => 'rejected']);
        return back()->with('success', 'Vendor ditolak.');
    }
}
