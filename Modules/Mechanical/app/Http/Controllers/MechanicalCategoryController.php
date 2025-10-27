<?php

namespace Modules\Mechanical\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Mechanical\Models\MechanicalCategory;

class MechanicalCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = MechanicalCategory::latest()->get();

        return view('mechanical::categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('mechanical::create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());
        // ✅ Validate data
        $request->validate([
            'name'        => 'required|string|max:255',
            'image'       => 'nullable|image|mimes:jpg,jpeg,png,gif,webp|max:4096',
            'description' => 'nullable|string',
            'status'      => 'nullable|in:on,off',
        ]);
        // dd('hello');
        // ✅ Create new instance
        $category = new MechanicalCategory();
        $category->name = $request->name;
        $category->description = $request->description;
        $category->status = $request->status ?? 'off';

        // ✅ Handle image upload
        if ($request->hasFile('image')) {
            $file      = $request->file('image');
            $filename  = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('upload/images/mechanicalscategories'), $filename);

            $category->image = $filename;
        }

        $category->save();

        return redirect()->route('mechanicals.categories.index')
            ->with('success', 'Category created successfully!');
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        return view('mechanical::show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return view('mechanical::edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // ✅ Validate data
        $request->validate([
            'name'        => 'required|string|max:255',
            'image'       => 'nullable|image|mimes:jpg,jpeg,png,gif,webp|max:4096',
            'description' => 'nullable|string',
            'status'      => 'nullable|in:on,off',
        ]);

        // ✅ Find category
        $category = MechanicalCategory::findOrFail($id);

        // ✅ Update fields
        $category->name        = $request->name;
        $category->description = $request->description;
        $category->status      = $request->status ?? 'off';

        // ✅ Handle image update
        if ($request->hasFile('image')) {
            // purana image delete (agar exist karta ho)
            if ($category->image && file_exists(public_path('upload/images/mechanicalscategories/' . $category->image))) {
                unlink(public_path('upload/images/mechanicalscategories/' . $category->image));
            }

            $file     = $request->file('image');
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('upload/images/mechanicalscategories'), $filename);

            $category->image = $filename;
        }

        $category->save();

        return redirect()->route('mechanicals.categories.index')
            ->with('success', 'Category updated successfully!');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $category = MechanicalCategory::findOrFail($id);

        if ($category->image && file_exists(public_path('upload/images/mechanicalscategories/' . $category->image))) {
            unlink(public_path('upload/images/mechanicalscategories/' . $category->image));
        }

        // ✅ Delete category
        $category->delete();

        return redirect()->route('mechanicals.categories.index')
            ->with('success', 'Category deleted successfully!');
    }


    public function status($id)
    {
        $category = MechanicalCategory::findOrFail($id);
        $category->status = $category->status === 'on' ? 'off' : 'on';
        $category->save();

        return redirect()->back()->with('success', 'Category status updated successfully!');
    }
}
