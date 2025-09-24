<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\ProductStockPrice;
use App\Models\ProductVarient;
use App\Models\Size;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index()
    {
        return view('pages.admin.product.index');
    }

    public function create()
    {
        $categories = Category::all();
        $sizes = Size::all();
        return view('pages.admin.product.create', compact('categories', 'sizes'));
    }

    public function edit($id)
    {
        $product = Product::where('id', $id)->first();
        $categories = Category::all();
        $sizes = Size::all();
        return view('pages.admin.product.update', compact('product', 'categories', 'sizes'));
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

        $product = Product::create([
            'category_id' => $validated['category_id'],
            'name' => $validated['name'],
            'description' => $validated['description'] ?? null,
            'price' => $validated['price'],
            'type' => $validated['type'],
            'status' => 'active'
        ]);

        if ($request->hasFile('base_image')) {
            $baseImagePath = $request->file('base_image')->store('products', 'public');
            $product->base_image = $baseImagePath;
            $product->save();
        }

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $imagePath = $image->store('products', 'public');
                ProductImage::create([
                    'product_id' => $product->id,
                    'image_url' => $imagePath
                ]);
            }
        }

        foreach($validated['size_id'] as $sizeId) {
            $varient = ProductVarient::create([
                'product_id' => $product->id,
                'size_id' => $sizeId,
            ]);

            ProductStockPrice::create([
                'product_id' => $product->id,
                'product_varient_id' => $varient->id,
                'price' => $validated['price'],
                'stock' => $validated['stock'],
            ]);
        }

        return redirect()->route('admin.product.index')->with('success', 'Product created successfully.');

    }

    public function update(ProductRequest $request, $id)
    {

    }


    public function destroy($id)
    {
        $product = Product::find($id);
        $product->delete();
        return redirect()->route('admin.product.index')->with('success', 'Product deleted successfully.');
    }
}
