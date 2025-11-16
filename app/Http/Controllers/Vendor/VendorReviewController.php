<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Models\Product;

class VendorReviewController extends Controller
{
    public function index(Product $product)
    {
        // Cek apakah produk milik vendor
        if ($product->vendor_id !== auth()->id()) {
            abort(403);
        }

        $reviews = $product->reviews()->latest()->paginate(10);

        return view('vendor.reviews.index', compact('product', 'reviews'));
    }
}
