<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    public function index() 
    {
        return view('pages.admin.category.index');
    }

    public function categories(Request $request)
    {
        $pageNumber = ($request->start / $request->length) + 1;
        $pageLength = $request->length;
        $skip = ($pageNumber - 1) * $pageLength;

        $orderColumnIndex = $request->order[0]['column'] ?? '0';
        $orderBy = $request->order[0]['dir'] ?? 'desc';

        $query = Category::query();

        $search = $request->search['value'] ?? null;
        if (!empty($search)) {
            $query->where(function ($query) use ($search) {
                $query->where('name', 'like', "%{$search}%");
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

        $categories = $query->skip($skip)->take($pageLength)->get();

        return response()->json([
            'draw' => $request->draw,
            'recordsTotal' => $recordTotal,
            'recordsFiltered' => $filterRecords,
            'data' => $categories
        ]);
    }

    public function store(CategoryRequest $request)
    {
        $validated = $request->validated();

        if($request->hasFile('img')) {
            $imgPath = $request->file('img')->store('categories', 'public');
            $validated['img'] = $imgPath;
        }

        Category::create([
            'name' => $validated['name'],
            'img' => $validated['img'],
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Category created successfully'
        ]);
    }

    public function update(CategoryRequest $request, $id)
    {
        $validated = $request->validated();

        $category = Category::find($id);

        if(!$category) {
            return response()->json([
                'status' => false,
                'message' => 'Category not found'
            ]);
        }

        if($request->hasFile('img')) {
            if($category->img && Storage::disk('public')->exists($category->img)) {
                Storage::disk('public')->delete($category->img);
            }
            $imgPath = $request->file('img')->store('categories', 'public');
            $validated['img'] = $imgPath;
        }

        $category->update([
            'name' => $validated['name'],
            'img' => $validated['img'] ?? $category->img,
        ]);

        $category->save();

        return response()->json([
            'status' => true,
            'message' => 'Category updated successfully'
        ]);
    }

    public function destroy($id)
    {
        $category = Category::find($id);

        if(!$category) {
            return response()->json([
                'status' => false,
                'message' => 'Category not found'
            ]);
        }

        $category->delete();

        return response()->json([
            'status' => true,
            'message' => 'Category deleted successfully'
        ]);
    }
}
