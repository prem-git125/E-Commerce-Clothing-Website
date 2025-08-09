<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index() 
    {
        return view('pages.admin.category.index');
    }

    public function store(CategoryRequest $request)
    {
        $validated = $request->validated();

        $category = Category::create([
            'name' => $validated['name'],
        ]);

        $category->save();

        return redirect()->route('admin.categories')->with('success', 'Category created successfully.');
    }
}
