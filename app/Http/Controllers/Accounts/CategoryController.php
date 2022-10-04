<?php

namespace App\Http\Controllers\Accounts;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        return view('accounts.category.index');
    }

    public function getCategory()
    {
        $category = Category::all();
        return response()->json($category);
    }

    public function saveCategory(Request $request)
    {
        if ($request->ajax()) {
            $category = new Category();
            $category->name = $request->input('name');
            $category->save();
            return response()->json(['success' => 'category added successfully'], 200);
        }
    }

    public function editCategory(Request $request)
    {
        $category = Category::find($request->id);
        return $category;
    }

    public function updateCategory(Request $request)
    {
        $category = Category::find($request->category_id);
        $category->name = $request->input('name');
        $category->save();
        return response()->json(['success' => 'category updated successfully'], 200);
    }

    public function deleteCategory(Request $request)
    {
        $category = Category::find($request->id);
        if($category->delete())
        {
            return response()->json([
                'status' => 200,
                'message' => 'category deleted successfully'
            ]);
        }
    }
}
