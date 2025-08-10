<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        return view('pages.admin.product.index');
    }

    public function create()
    {
        $categories = Category::all();
        return view('pages.admin.product.create', compact('categories'));
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::all();
        return view('pages.admin.product.update', compact('product', 'categories'));
    }

    public function products(Request $request)
    {
        $pageNumber = ($request->start / $request->length) + 1;
        $pageLength = $request->length;
        $skip = ($pageNumber - 1) * $pageLength;

        $orderColumnIndex = $request->order[0]['column'] ?? '0';
        $orderBy = $request->order[0]['dir'] ?? 'desc';

        $query = Product::where('status', 'active');

        $search = $request->search['value'] ?? null;
        if (!empty($search)) {
            $query->where(function ($query) use ($search) {
                $query->where('name', 'like', "%{$search}%");
                $query->orWhere('slug', 'like', "%{$search}%");
            });
        }

        $orderByName = match ($orderColumnIndex) {
            0 => 'name',
            2 => 'created_at',
            default => 'name'
        };

        $query->orderBy($orderByName, $orderBy);

        $recordTotal = $query->count();
        $filterRecords = $query->count();

        $products = $query->skip($skip)->take($pageLength)->get();

        return response()->json([
            'draw' => $request->draw,
            'recordsTotal' => $recordTotal,
            'recordsFiltered' => $filterRecords,
            'data' => $products
        ]);
    }

    public function store(ProductRequest $request)
    {
        $validated = $request->validated();

        if($request->hasFile('image_url')) {
            $imagePath = $request->file('image_url')->store('products', 'public');
            $validated['image_url'] = $imagePath;
        }

        $product = Product::create([
            'category_id' => $validated['category_id'],
            'name' => $validated['name'],
            'description' => $validated['description'],
            'price' => $validated['price'],
            'stock' => $validated['stock'],
            'type' => $validated['type'],
        ]);

        ProductImage::create([
            'product_id' => $product->id,
            'image_url' => $validated['image_url'],
        ]);

        return redirect()->route('admin.product.index')->with('success', 'Product created successfully.');
    }

    public function update(ProductRequest $request, $id)
    {
        $validated = $request->validated(); 

        $product = Product::findOrFail($id);

        if ($request->hasFile('image_url')) {
            $imagePath = $request->file('image_url')->store('products', 'public');
            $validated['image_url'] = $imagePath;
        }

        $product->update([
            'category_id' => $validated['category_id'],
            'name'        => $validated['name'],
            'description' => $validated['description'],
            'price'       => $validated['price'],
            'stock'       => $validated['stock'],
            'type'        => $validated['type'],
        ]);

        if (isset($validated['image_url'])) {
            ProductImage::updateOrCreate(
                ['product_id' => $product->id],
                ['image_url'  => $validated['image_url']]
            );
        }

        return redirect()->route('admin.product.index')->with('success', 'Product updated successfully.');
    }

    public function destroy($id)
    {
        $product = Product::find($id);
        $product->delete();
        return redirect()->route('admin.product.index')->with('success', 'Product deleted successfully.');
    }

}
