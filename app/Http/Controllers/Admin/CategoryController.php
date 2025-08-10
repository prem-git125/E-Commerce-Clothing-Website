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

        Category::create([
            'name' => $validated['name'],
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

        $category->update([
            'name' => $validated['name'],
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
