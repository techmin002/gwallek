<?php

namespace Modules\Mechanical\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Branch\Entities\Branch;
use Modules\Mechanical\Models\Mechanical;
use Modules\Mechanical\Models\MechanicalCategory;

class MechanicalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (auth()->user()->access_type == 'Super Admin') {
            $mechanicals = Mechanical::with(['category', 'branch'])->latest()->get();
            $branches = Branch::all();
        } else {
            $mechanicals = Mechanical::with(['category', 'branch'])
                ->where('branch_id', auth()->user()->branch_id)
                ->latest()
                ->get();
            $branches = Branch::where('id', auth()->user()->branch_id)->get();
        }

        $categories = MechanicalCategory::where('status', 'on')->get();

        return view('mechanical::mechanical.index', compact('mechanicals', 'categories', 'branches'));
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
        // Validation
        $validated = $request->validate([
            'name'              => 'required|string|max:255',
            'category_id'       => 'required|exists:mechanical_categories,id',
            'branch_id'         => 'required|exists:branches,id',
            'image'             => 'nullable|image|mimes:jpg,jpeg,png|max:5120',
            'purchase_date'     => 'nullable|date',
            'amount'            => 'nullable|numeric',
            'insurance_date'    => 'nullable|date',
            'insurance_document' => 'nullable|mimes:pdf,jpg,jpeg,png|max:5120',
            'engine_number'     => 'nullable|string|max:255',
            'chasis_number'    => 'nullable|string|max:255',
            'vehicle_number'    => 'nullable|string|max:255',
            'service_date'      => 'nullable|date',
            'description'       => 'nullable|string',
            'status'            => 'nullable|in:on,off',
        ]);

        $filename = null;
        $docname = null;
        try {
            // Handle Image Upload
            if ($request->hasFile('image')) {
                $filename = time() . '.' . $request->image->getClientOriginalExtension();
                $request->image->move(public_path('upload/images/mechanicals'), $filename);
                // $mechanical->image = $filename;
            }

            // Handle Insurance Document Upload
            if ($request->hasFile('insurance_document')) {
                $docname = time() . '.' . $request->insurance_document->getClientOriginalExtension();
                $request->insurance_document->move(public_path('upload/images/mechanicals/insurance'), $docname);
                // $mechanical->insurance_document = $docname;
            }

            // Save Mechanical
            $mechanical = new Mechanical();
            $mechanical->name              = $validated['name'];
            $mechanical->category_id       = $validated['category_id'];
            $mechanical->branch_id         = $validated['branch_id'];
            $mechanical->image             = $filename;
            $mechanical->purchase_date     = $validated['purchase_date'] ?? null;
            $mechanical->amount            = $validated['amount'] ?? null;
            $mechanical->insurance_date    = $validated['insurance_date'] ?? null;
            $mechanical->insurance_document = $docname;
            $mechanical->engine_number     = $validated['engine_number'] ?? null;
            $mechanical->chasis_number    = $validated['chasis_number'] ?? null;
            $mechanical->vehicle_number    = $validated['vehicle_number'] ?? null;
            $mechanical->service_date      = $validated['service_date'] ?? null;
            $mechanical->description       = $validated['description'] ?? null;
            $mechanical->status            = $validated['status'] == 'on' ? 1 : 0;
            $mechanical->save();

            return redirect()->back()->with('success', 'Mechanical Item created successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Something went wrong: ' . $e->getMessage());
        }
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
        $validated = $request->validate([
            'name'              => 'required|string|max:255',
            'category_id'       => 'required|exists:mechanical_categories,id',
            'branch_id'         => 'required|exists:branches,id',
            'purchase_date'     => 'nullable|date',
            'amount'            => 'nullable|numeric',
            'insurance_date'    => 'nullable|date',
            'engine_number'     => 'nullable|string|max:255',
            'chasis_number'     => 'nullable|string|max:255',
            'vehicle_number'    => 'nullable|string|max:255',
            'service_date'      => 'nullable|date',
            'description'       => 'nullable|string',
            'status'            => 'nullable|in:on,off',
            'image'             => 'nullable|image|mimes:jpg,jpeg,png,gif|max:5120',
            'insurance_document' => 'nullable|mimes:pdf,jpg,jpeg,png|max:5120',
        ]);

        try {
            $mechanical = Mechanical::findOrFail($id);

            // === Image Upload ===
            if ($request->hasFile('image')) {
                // delete old image
                if ($mechanical->image && file_exists(public_path('upload/images/mechanicals/' . $mechanical->image))) {
                    unlink(public_path('upload/images/mechanicals/' . $mechanical->image));
                }

                $filename = time() . '.' . $request->image->getClientOriginalExtension();
                $request->image->move(public_path('upload/images/mechanicals'), $filename);

                $mechanical->image = $filename; // only filename store in DB
            }

            // === Insurance Document Upload ===
            if ($request->hasFile('insurance_document')) {
                // delete old doc
                if ($mechanical->insurance_document && file_exists(public_path('upload/images/mechanicals/insurance/' . $mechanical->insurance_document))) {
                    unlink(public_path('upload/images/mechanicals/insurance/' . $mechanical->insurance_document));
                }

                $docname = time() . '.' . $request->insurance_document->getClientOriginalExtension();
                $request->insurance_document->move(public_path('upload/images/mechanicals/insurance'), $docname);

                $mechanical->insurance_document = $docname; // only filename store in DB
            }

            // === Update Other Fields ===
            $mechanical->name            = $validated['name'];
            $mechanical->category_id     = $validated['category_id'];
            $mechanical->branch_id       = $validated['branch_id'];
            $mechanical->purchase_date   = $validated['purchase_date'] ?? null;
            $mechanical->amount          = $validated['amount'] ?? null;
            $mechanical->insurance_date  = $validated['insurance_date'] ?? null;
            $mechanical->engine_number   = $validated['engine_number'] ?? null;
            $mechanical->chasis_number   = $validated['chasis_number'] ?? null;
            $mechanical->vehicle_number  = $validated['vehicle_number'] ?? null;
            $mechanical->service_date    = $validated['service_date'] ?? null;
            $mechanical->description     = $validated['description'] ?? null;
            $mechanical->status          = $validated['status'] == 'on' ? 1 : 0;

            $mechanical->save();

            return redirect()->back()->with('success', 'Mechanical Item updated successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Update failed: ' . $e->getMessage());
        }
    }





    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $mechanical = Mechanical::findOrFail($id);

            // === Delete Image ===
            if ($mechanical->image && file_exists(public_path($mechanical->image))) {
                unlink(public_path($mechanical->image));
            }

            // === Delete Insurance Document ===
            if ($mechanical->insurance_document && file_exists(public_path($mechanical->insurance_document))) {
                unlink(public_path($mechanical->insurance_document));
            }

            // === Delete Record ===
            $mechanical->delete();

            return redirect()->back()->with('success', 'Mechanical Item deleted successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Delete failed: ' . $e->getMessage());
        }
    }
}
