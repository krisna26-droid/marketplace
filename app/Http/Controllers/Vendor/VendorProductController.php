<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VendorProductController extends Controller
{
    /**
     * Vendor product list.
     */
    public function index()
    {
        $products = Product::where('vendor_id', Auth::id())
            ->latest()
            ->get();

        return view('vendor.products.index', compact('products'));
    }

    /**
     * Show product detail.
     */
    public function show(Product $product)
    {
        abort_if($product->vendor_id !== Auth::id(), 403);

        return view('vendor.products.show', compact('product'));
    }

    /**
     * Create product form.
     */
    public function create()
    {
        $categories = Category::all();

        return view('vendor.products.create', compact('categories'));
    }

    /**
     * Store product.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|max:255|unique:products,name',
            'description' => 'required|string',
            'price'       => 'required|numeric|min:0',
            'stock'       => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
            'image'       => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $data = $request->only(['name', 'description', 'price', 'stock', 'category_id']);
        $data['vendor_id'] = Auth::id();

        $data['image'] = $request->hasFile('image')
            ? $request->file('image')->store('products', 'public')
            : null;

        Product::create($data);

        return redirect()->route('vendor.products.index')
            ->with('success', 'Produk berhasil ditambahkan!');
    }

    /**
     * Edit product.
     */
    public function edit(Product $product)
    {
        abort_if($product->vendor_id !== Auth::id(), 403);

        $categories = Category::all();

        return view('vendor.products.edit', compact('product', 'categories'));
    }

    /**
     * Update product.
     */
    public function update(Request $request, Product $product)
    {
        abort_if($product->vendor_id !== Auth::id(), 403);

        $request->validate([
            'name'        => 'required|string|max:255|unique:products,name,' . $product->id,
            'description' => 'required|string',
            'price'       => 'required|numeric|min:0',
            'stock'       => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
            'image'       => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $data = $request->only(['name', 'description', 'price', 'stock', 'category_id']);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        $product->update($data);

        return redirect()->route('vendor.products.index')
            ->with('success', 'Produk berhasil diperbarui!');
    }

    /**
     * Delete product.
     */
    public function destroy(Product $product)
    {
        abort_if($product->vendor_id !== Auth::id(), 403);

        $product->delete();

        return redirect()->route('vendor.products.index')
            ->with('success', 'Produk dihapus.');
    }

    public function reviews()
    {
        $reviews = \App\Models\Review::whereHas('product', function ($query) {
            $query->where('vendor_id', auth()->id());
        })
        ->with(['product', 'customer'])
        ->latest()
        ->paginate(15);

        return view('vendor.reviews.index', compact('reviews'));
    }

}
