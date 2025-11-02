<?php

namespace Modules\Product\Http\Controllers;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Branch\Entities\Branch;
use Modules\Product\Models\Brand;
use Modules\Product\Models\Categories;
use Modules\Product\Models\Product;
use Modules\Product\Models\Unit;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index()
    {
        if (auth()->user()->name == 'Super Admin') {
            $products = Product::with(['brand', 'unit', 'category', 'branch'])->get();
            $branches = Branch::all();
        } else {
            $products = Product::with(['brand', 'unit', 'category', 'branch'])
                ->where('branch_id', auth()->user()->branch_id)
                ->get();
            $branches = Branch::where('id', auth()->user()->branch_id)->get();
        }

        $units = Unit::all();
        $brands = Brand::all();
        $categories = Categories::all();

        return view('product::products.index', compact('products', 'units', 'brands', 'categories', 'branches'));
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
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'nullable|integer',
            'brand_id' => 'required',
            'branch_id' => 'nullable',
            'category_id' => 'required',
            'unit_id' => 'nullable',
            'stock' => 'nullable|numeric',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'status' => 'nullable|in:on,off',
        ]);

        try {
            $product = new Product();
            $product->name = $request->name;
            $product->slug = \Illuminate\Support\Str::slug($request->name);
            $product->category_id = $request->category_id;
            $product->brand_id = $request->brand_id;
            $product->unit_id = $request->unit_id;
            $product->branch_id = $request->branch_id ?? auth()->user()->branch_id;
            $product->price = $request->price;
            $product->stock = $request->stock;
            $product->description = $request->description;
            $product->status = $request->status ?? 0;

            // Upload main image
            if ($request->hasFile('image')) {
                $imageName = time() . '_' . $request->image->getClientOriginalName();
                $request->image->move(public_path('upload/products/'), $imageName);
                $product->image = $imageName;
            }

            // Save product
            $product->save();

            return redirect()->route('products.index')->with('success', 'Product created successfully!');
        } catch (\Exception $e) {
            // Return with error if something fails
            return back()->with('error', 'Failed to create product: ' . $e->getMessage())->withInput();
        }
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
        $product = Product::findOrFail($id);
        $categories = Categories::all();
        $brands = Brand::all();
        $units = Unit::all();
        $branches = Branch::all();

        return view('product::products.edit', compact('product', 'categories', 'brands', 'units', 'branches'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // dd($request->all());

        $product = Product::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'nullable|integer',
            'brand_id' => 'required',
            'branch_id' => 'nullable',
            'category_id' => 'required',
            'unit_id' => 'nullable',
            'stock' => 'nullable|numeric',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'status' => 'nullable|in:on,off',
        ]);

        $product->name = $request->name;
        $product->slug = \Illuminate\Support\Str::slug($request->name);
        $product->price = $request->price;
        $product->brand_id = $request->brand_id;
        $product->branch_id = $request->branch_id ?? auth()->user()->branch_id;
        $product->category_id = $request->category_id;
        $product->unit_id = $request->unit_id;
        $product->description = $request->description;
        $product->status = $request->status ?? 'off';

        // Replace Image if uploaded
        if ($request->hasFile('image')) {
            if ($product->image && file_exists(public_path('upload/products/' . $product->image))) {
                unlink(public_path('upload/products/' . $product->image));
            }
            $imageName = time() . '_' . $request->image->getClientOriginalName();
            $request->image->move(public_path('upload/products/'), $imageName);
            $product->image = $imageName;
        }

        $product->save();

        return redirect()->route('products.index')->with('success', 'Product updated successfully!');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $product = Product::findOrFail($id);

        // Delete image
        if ($product->image && file_exists(public_path('upload/products/' . $product->image))) {
            unlink(public_path('upload/products/' . $product->image));
        }

        $product->delete();

        return redirect()->back()->with('success', 'Product deleted successfully!');
    }

    public function status($id)
    {
        $product = Product::findOrFail($id);
        $product->status = $product->status == 'on' ? 'off' : 'on';
        $product->save();

        return redirect()->route('products.index')->with('success', 'Product status updated!');
    }
}
