<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Product;

class CustomerProductController extends Controller
{
    public function show(Product $product)
    {
        $product->load('category', 'vendor');
        return view('customer.products.show', compact('product'));
    }
}
