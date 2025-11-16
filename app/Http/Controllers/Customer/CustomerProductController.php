<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Product;

class CustomerProductController extends Controller
{
    public function show(Product $product)
    {
        $latestReview = $product->reviews()
            ->latest()
            ->first();

        $totalReviews = $product->reviews()->count();

        $averageRating = $product->reviews()->avg('rating') ?? 0;

        return view('customer.products.show', compact(
            'product',
            'latestReview',
            'totalReviews',
            'averageRating',
        ));
    }

    public function fullReviews(Product $product)
    {
        $reviews = $product->reviews()
            ->latest()
            ->with('customer')
            ->paginate(10);

        return view('customer.reviews.index', compact('product', 'reviews'));
    }
}
