<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index($id)
    {
        $products = Product::where('category_id', $id)->with('images')->get();
        return view('pages.product.index', compact('products'));
    }

    public function show($id)
    {
        $product = Product::with('images')->findOrFail($id);
        dd($product->toArray());
        return view('pages.product.show', compact('product'));
    }
}
