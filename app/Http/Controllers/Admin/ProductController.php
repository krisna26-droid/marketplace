<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\User;
use Illuminate\Http\Request;


class ProductController extends Controller
{
    /**
     * Display product list with filters.
     */
    public function index(Request $request)
    {
        $filter = $request->query('status');
        $query = Product::with(['vendor', 'category']);

        // Status filter
        if ($filter === 'trashed') {
            $query->onlyTrashed();
        } elseif ($filter === 'all') {
            $query->withTrashed();
     }

        // Search by name
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // Category filter
        if ($request->filled('category_id')) {
            $query->where('category_id', (int) $request->category_id);
        }

        // Price filter
        if ($request->filled('min_price') && $request->filled('max_price')) {
            $min = (float) $request->min_price;
            $max = (float) $request->max_price;

            if ($min <= $max) {
                $query->whereBetween('price', [$min, $max]);
            }
        }

        // Vendor filter
        if ($request->filled('vendor_id')) {
            $query->where('vendor_id', (int) $request->vendor_id);
        }

        $products = $query->latest()->paginate(10)->appends($request->query());
        $categories = Category::all();
        $vendors = User::where('role', 'vendor')->get();

        return view('admin.products.index', compact(
            'products',
            'categories',
            'vendors',
            'filter'
        ));
    }

    /**
     * Show create form.
     */
    public function create()
    {
        $categories = Category::all();
        $vendors = User::where('role', 'vendor')->get();

        return view('admin.products.create', compact('categories', 'vendors'));
    }

    /**
     * Store new product.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|max:255|unique:products,name',
            'description' => 'required|string',
            'price'       => 'required|numeric|min:0',
            'stock'       => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
            'vendor_id'   => 'required|exists:users,id',
            'image'       => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $data = $request->only([
            'name', 'description', 'price', 'stock', 'category_id', 'vendor_id'
        ]);

        $data['stock'] = (int) $data['stock'];
        $data['image'] = $request->hasFile('image')
            ? $request->file('image')->store('products', 'public')
            : null;

        Product::create($data);

        return redirect()->route('admin.products.index')
            ->with('success', 'Produk baru berhasil ditambahkan.');
    }

    /**
     * Show edit form.
     */
    public function edit(Product $product)
    {
        $categories = Category::all();
        $vendors = User::where('role', 'vendor')->get();

        return view('admin.products.edit', compact('product', 'categories', 'vendors'));
    }

    /**
     * Update product.
     */
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name'        => 'required|string|max:255|unique:products,name,' . $product->id,
            'description' => 'required|string',
            'price'       => 'required|numeric|min:0',
            'stock'       => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
            'vendor_id'   => 'required|exists:users,id',
            'image'       => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $data = $request->only([
            'name', 'description', 'price', 'stock', 'category_id', 'vendor_id'
        ]);

        $data['stock'] = (int) $data['stock'];

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        $product->update($data);

        return redirect()->route('admin.products.index')
            ->with('success', 'Produk berhasil diperbarui.');
    }

    /**
     * Soft delete product.
     */
    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()->route('admin.products.index')
            ->with('success', 'Produk berhasil diarsipkan.');
    }

    /**
     * Restore soft-deleted product.
     */
    public function restore(int $id)
    {
        $product = Product::onlyTrashed()->findOrFail($id);
        $product->restore();

        return redirect()->route('admin.products.index', ['filter' => 'trashed'])
            ->with('success', 'Produk berhasil dipulihkan.');
    }

    /**
     * Permanently delete product.
     */
    public function forceDelete(int $id)
    {
        $product = Product::onlyTrashed()->findOrFail($id);
        $product->forceDelete();

        return redirect()->route('admin.products.index', ['filter' => 'trashed'])
            ->with('success', 'Produk dihapus permanen.');
    }
}
