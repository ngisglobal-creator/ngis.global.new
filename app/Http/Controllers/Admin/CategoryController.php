<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

use App\Models\Branch;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::with(['branch', 'parent'])->get();
        return view('admin.categories.index', compact('categories'));
    }

    public function create()
    {
        $branches = Branch::all();
        $parentCategories = Category::whereNull('parent_id')->get();
        return view('admin.categories.create', compact('branches', 'parentCategories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'branch_id' => 'required|exists:branches,id',
            'parent_id' => 'nullable|exists:categories,id',
            'name_ar'   => 'required|string|max:255',
            'name_en'   => 'required|string|max:255',
            'name_zh'   => 'required|string|max:255',
        ]);

        Category::create($request->all());

        return redirect()->route('admin.categories.index')->with('success', 'Category created successfully');
    }

    public function edit(Category $category)
    {
        $branches = Branch::all();
        $parentCategories = Category::whereNull('parent_id')->where('id', '!=', $category->id)->get();
        return view('admin.categories.edit', compact('category', 'branches', 'parentCategories'));
    }

    public function update(Request $request, Category $category)
    {
        $request->validate([
            'branch_id' => 'required|exists:branches,id',
            'parent_id' => 'nullable|exists:categories,id',
            'name_ar'   => 'required|string|max:255',
            'name_en'   => 'required|string|max:255',
            'name_zh'   => 'required|string|max:255',
        ]);

        $category->update($request->all());

        return redirect()->route('admin.categories.index')->with('success', 'Category updated successfully');
    }

    public function destroy(Category $category)
    {
        $category->delete();
        return redirect()->route('admin.categories.index')->with('success', 'Category deleted successfully');
    }
}
