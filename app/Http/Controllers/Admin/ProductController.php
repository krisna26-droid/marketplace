<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\User;

class ProductController extends Controller
{
    // Tampilkan produk (aktif / terhapus)
    public function index(Request $request)
    {
        $filter = $request->get('status');
        $query = Product::with(['vendor', 'category']);

        // Filter status
        if ($filter === 'trashed') {
            $query->onlyTrashed();
        } elseif ($filter === 'all') {
            $query->withTrashed();
        } else {
            $query->withoutTrashed();
        }

        // Filter nama
        if ($request->has('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // Filter kategori
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        // Filter harga
        if ($request->filled('min_price') && $request->filled('max_price')) {
            $query->whereBetween('price', [$request->min_price, $request->max_price]);
        }

        // Filter vendor
        if ($request->filled('vendor_id')) {
            $query->where('vendor_id', $request->vendor_id);
        }

        $products = $query->latest()->paginate(10)->withQueryString();
        $categories = Category::all();
        $vendors = User::where('role', 'vendor')->get();

        return view('admin.products.index', compact('products', 'categories', 'vendors', 'filter'));
    }

    public function create()
    {
        $categories = Category::all();
        $vendors = User::where('role', 'vendor')->get();
        return view('admin.products.create', compact('categories', 'vendors'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:products,name',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
            'vendor_id' => 'required|exists:users,id',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $data = $request->except('image');
        $data['stock'] = max(0, (int)$request->stock);

        // Gambar
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('products', 'public');
        } else {
            $data['image'] = null;
        }

        Product::create($data);

        return redirect()->route('admin.products.index')->with('success', 'Produk baru berhasil ditambahkan.');
    }

    public function edit(Product $product)
    {
        $categories = Category::all();
        $vendors = User::where('role', 'vendor')->get();

        return view('admin.products.edit', compact('product', 'categories', 'vendors'));
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:products,name,' . $product->id,
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
            'vendor_id' => 'required|exists:users,id',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $data = $request->except('image', 'stock');
        $data['stock'] = max(0, (int)$request->stock);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        $product->update($data);

        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil diperbarui.');
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil dihapus (arsip).');
    }

    public function restore($id)
    {
        $product = Product::onlyTrashed()->findOrFail($id);
        $product->restore();

        return redirect()->route('admin.products.index', ['filter' => 'trashed'])
            ->with('success', 'Produk berhasil dipulihkan.');
    }

    public function forceDelete($id)
    {
        $product = Product::onlyTrashed()->findOrFail($id);
        $product->forceDelete();

        return redirect()->route('admin.products.index', ['filter' => 'trashed'])
            ->with('success', 'Produk dihapus permanen.');
    }
}
