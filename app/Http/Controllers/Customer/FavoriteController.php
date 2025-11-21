<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    public function index()
    {
        $favorites = Auth::user()->favorites()->paginate(10);
        return view('customer.wishlist', compact('favorites'));
    }

    public function toggle(Product $product)
    {
        Auth::user()->favorites()->toggle($product->id);
        return back()->with('success', 'Wishlist diperbarui!');
    }
}
