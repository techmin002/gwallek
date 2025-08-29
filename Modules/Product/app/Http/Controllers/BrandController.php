<?php

namespace Modules\Product\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Product\Models\Brand;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $brands = Brand::all(); // Fetch all brands
        return view('product::brands.index', compact('brands'));
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
            'name' => 'required|string|max:255|unique:brands,name',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'description' => 'nullable|string',
            'status' => 'nullable|in:on,off',
        ]);

        $brand = new Brand();
        $brand->name = $request->name;
        $brand->description = $request->description;
        $brand->status = $request->status ?? 'off';

        // Upload brand image (optional)
        if ($request->hasFile('image')) {
            $imageName = time() . '_' . $request->image->getClientOriginalName();
            $request->image->move(public_path('upload/brands/'), $imageName);
            $brand->image = $imageName;
        }

        $brand->save();

        return redirect()->back()->with('success', 'Brand created successfully!');
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
        $brand = Brand::findOrFail($id); // Fetch the brand by ID
        return view('product::brands.edit', compact('brand'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $brand = Brand::findOrFail($id);

        // Validate input
        $request->validate([
            'name' => 'required|string|max:255|unique:brands,name,' . $brand->id,
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'status' => 'nullable|in:on,off',
        ]);

        // Update fields
        $brand->name = $request->name;
        $brand->description = $request->description;
        $brand->status = $request->status ?? 'off';

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($brand->image && file_exists(public_path('upload/brands/' . $brand->image))) {
                unlink(public_path('upload/brands/' . $brand->image));
            }

            $imageName = time() . '_' . $request->image->getClientOriginalName();
            $request->image->move(public_path('upload/brands/'), $imageName);
            $brand->image = $imageName;
        }

        $brand->save();

        return redirect()->route('brands.index')->with('success', 'Brand updated successfully!');
    }

    public function status($id)
    {
        $brand = Brand::findOrFail($id);

        // Toggle status
        $brand->status = $brand->status === 'on' ? 'off' : 'on';
        $brand->save();

        return redirect()->back()->with('success', 'Brand status updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $brand = Brand::findOrFail($id);

        // Delete the image file if it exists
        if ($brand->image && file_exists(public_path('upload/brands/' . $brand->image))) {
            unlink(public_path('upload/brands/' . $brand->image));
        }

        // Delete the brand record
        $brand->delete();

        return redirect()->route('brands.index')->with('success', 'Brand deleted successfully!');
    }
}
