<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::latest()->get();

        return response()->json($categories);
    }

    public function store(Request $request)
    {
        Category::create([
            'name' => $request->name
        ]);

        return redirect('/categories')
            ->with('success', 'Category created');
    }

    public function show($id)
    {
        $category = Category::findOrFail($id);

        return response()->json($category);
    }

    public function update(Request $request, $id)
    {
        $category = Category::findOrFail($id);

        $category->update([
            'name' => $request->name
        ]);

        return redirect('/categories')
            ->with('success', 'Category updated');
    }

    public function destroy($id)
    {
        $category = Category::findOrFail($id);

        $category->delete();

        return redirect('/categories')
            ->with('success', 'Category deleted');
    }
    
    public function view()
    {
        $categories = Category::latest()->get();

        return view('dashboard.sections.categories', compact('categories'));
    }
}
