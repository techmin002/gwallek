<?php

namespace Modules\Service\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Service\Models\Service;
use Modules\Service\Models\ServiceType;

class ServiceTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('service::index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($service_id)
    {
        $service = Service::findOrFail($service_id);
        return view('service::services_type.create', compact('service'));
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validation
        // dd($request->all());
        $request->validate([
            'service_id'  => 'required|exists:services,id',
            'name'        => 'required|string|max:255',
            'title'       => 'nullable|string|max:255',
            'overview'    => 'nullable|string',
            'description' => 'nullable|string',
            'benifits'    => 'nullable|string',
            'image'       => 'nullable|image|mimes:jpeg,png,jpg,gif|max:4096',
            'status'      => 'nullable',
        ]);

        // Create new ServiceType
        $type = new ServiceType();
        $type->service_id  = $request->service_id;
        $type->name        = $request->name;
        $type->title       = $request->title;
        $type->overview    = $request->overview;
        $type->description = $request->description;
        $type->benifits    = $request->benifits;
        $type->status      = $request->has('status') ? 'on' : 'off';


        // Image Upload
        if ($request->hasFile('image')) {
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('upload/images/servicestype'), $imageName);
            $type->image = $imageName;
        }

        // Save to DB
        $type->save();

        return redirect()
            ->route('services.show', $request->service_id)
            ->with('success', 'Service Type added successfully!');
    }




    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        return view('service::show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $type = ServiceType::findOrFail($id);
        $service = $type->service;

        return view('service::services_type.edit', compact('type', 'service'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // dd($request->all());
        $request->validate([
            'service_id'  => 'required|exists:services,id',
            'name'        => 'required|string|max:255',
            'title'       => 'nullable|string|max:255',
            'overview'    => 'nullable|string',
            'description' => 'nullable|string',
            'benifits'    => 'nullable|string',
            'image'       => 'nullable|image|mimes:jpeg,png,jpg,gif|max:4096',
            'status'      => 'nullable',
        ]);

        $type = ServiceType::findOrFail($id);

        // Update fields
        $type->name        = $request->name;
        $type->title       = $request->title;
        $type->overview    = $request->overview;
        $type->description = $request->description;
        $type->benifits    = $request->benifits;
        $type->status      = $request->has('status') ? 'on' : 'off';

        // Image update
        if ($request->hasFile('image')) {
            $oldImagePath = public_path('upload/images/servicestype/' . basename($type->image));
            if ($type->image && file_exists($oldImagePath)) {
                unlink($oldImagePath);
            }

            // Upload new image
            $imageName = $request->file('image');
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('upload/images/servicestype'), $imageName);
            $type->image = $imageName;
        }
        // dd('No IMAGE');


        $type->save();

        return redirect()->route('services.show', $type->service_id)
            ->with('success', 'Why Choose updated successfully.');
    }




    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $type = ServiceType::findOrFail($id);
        $type->delete();

        return redirect()->back()->with('success', 'Service Type Deleted Successfully');
    }

    public function status($id)
    {
        // dd($id);
        $type =  ServiceType::findOrFail($id);
        $type->status = $type->status === 'on' ? 'off' : 'on';
        $type->save();

        return redirect()->back()->with('success', 'Service Type Status Updated Successfully');
    }
}
