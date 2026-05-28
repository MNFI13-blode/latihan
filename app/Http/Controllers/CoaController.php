<?php

namespace App\Http\Controllers;

use App\Models\Coa;
use App\Models\Category;
use Illuminate\Http\Request;

class CoaController extends Controller
{
    public function index()
    {
        $coas = Coa::with('category')->latest()->get();

        return response()->json($coas);
    }

    public function store(Request $request)
    {
        Coa::create([
            'code' => $request->code,
            'name' => $request->name,
            'category_id' => $request->category_id
        ]);

        return redirect('/coas')
            ->with('success', 'COA created');
    }

    public function show($id)
    {
        $coa = Coa::with('category')->findOrFail($id);

        return response()->json($coa);
    }

    public function update(Request $request, $id)
    {
        $coa = Coa::findOrFail($id);

        $coa->update([
            'code' => $request->code,
            'name' => $request->name,
            'category_id' => $request->category_id
        ]);

        return redirect('/coas')
            ->with('success', 'COA updated');
    }

    public function destroy($id)
    {
        $coa = Coa::findOrFail($id);

        $coa->delete();

        return redirect('/coas')
            ->with('success', 'COA deleted');
    }
    public function view()
    {
        $coas = Coa::with('category')
            ->latest()
            ->get();

        $categories = Category::latest()->get();

        return view(
            'dashboard.sections.coas',
            compact('coas', 'categories')
        );
    }
}
