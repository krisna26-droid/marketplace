<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Customer;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with('category', 'vendor');

        // Filter pencarian nama produk
        if ($request->has('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // Filter berdasarkan kategori dan subkategori
        if ($request->filled('category_id')) {
            $category = Category::find($request->category_id);

            if ($category) {
                // Ambil ID kategori induk + semua anaknya
                $categoryIds = $this->getAllCategoryIds($category);
                $query->whereIn('category_id', $categoryIds);
            }
        }

        $products = $query->latest()->paginate(9);
        $categories = Category::with('children')->whereNull('parent_id')->get();

        return view('customer.dashboard', compact('products', 'categories'));
    }

    // Ambil semua ID kategori anak dari kategori induk (rekursif)
    private function getAllCategoryIds(Category $category)
    {
        $ids = [$category->id];

        foreach ($category->children as $child) {
            $ids = array_merge($ids, $this->getAllCategoryIds($child));
        }

        return $ids;
    }
}
