<?php

namespace Modules\Product\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Product\Models\Categories;

class CategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Categories::all();
        return view('product::categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('product::create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'description' => 'nullable|string',
            'status' => 'nullable|in:on,off',
        ]);

        $category = new Categories();
        $category->name = $request->name;
        $category->description = $request->description;
        $category->status = $request->status ?? 'off';

        if ($request->hasFile('image')) {
            $imageName = time() . '_' . $request->image->getClientOriginalName();
            $request->image->move(public_path('upload/categories/'), $imageName);
            $category->image = $imageName;
        }

        $category->save();

        return redirect()->back()->with('success', 'Category created successfully!');
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        return view('product::show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $category = Categories::findOrFail($id);
        return view('product::categories.edit', compact('category'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // dd($request->all());
        $category = Categories::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,' . $category->id,
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'description' => 'nullable|string',
            'status' => 'nullable|in:on,off',
        ]);

        $category->name = $request->name;
        $category->description = $request->description;
        $category->status = $request->status ?? 'off';

        if ($request->hasFile('image')) {
            if ($category->image && file_exists(public_path('upload/categories/' . $category->image))) {
                unlink(public_path('upload/categories/' . $category->image));
            }

            $imageName = time() . '_' . $request->image->getClientOriginalName();
            $request->image->move(public_path('upload/categories/'), $imageName);
            $category->image = $imageName;
        }

        $category->save();

        return redirect()->route('categories.index')->with('success', 'Category updated successfully!');
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $category = Categories::findOrFail($id);

        if ($category->image && file_exists(public_path('upload/categories/' . $category->image))) {
            unlink(public_path('upload/categories/' . $category->image));
        }

        $category->delete();

        return redirect()->route('categories.index')->with('success', 'Category deleted successfully!');
    }

    // Status toggle
    public function status($id)
    {
        $category = Categories::findOrFail($id);
        $category->status = $category->status == 'on' ? 'off' : 'on';
        $category->save();

        return redirect()->route('categories.index')->with('success', 'Category status updated!');
    }
}
