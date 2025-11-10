<?php

namespace Modules\Service\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Service\Models\Service;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $services = Service::latest()->get();
        return view('service::services.index', compact('services'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('service::services.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());
        // validation
        $request->validate([
            'name' => 'required|string|max:255|unique:services,name',
            'description' => 'nullable|string',
            'icon'        => 'nullable|mimes:png,jpg,jpeg,svg,gif|max:2048',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $imageName = null;
        if ($request->hasFile('image')) {
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('upload/images/services'), $imageName);
        }
        $iconName = null;
        if ($request->hasFile('icon')) {
            // Upload new Icon
            $iconName = $request->file('icon');
            $iconName = time() . '.' . $request->icon->extension();
            $request->icon->move(public_path('upload/images/services'), $iconName);
        }
        // create service
        Service::create([
            'name' => $request->name,
            'description' => $request->description,
            'status' => $request->status ? 'on' : 'off',
            'image' => $imageName,
            'icon' => $iconName,
        ]);

        return redirect()->route('services.index')->with('success', 'Service created successfully.');
    }
    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        // dd("HELLO SERVICE WHY CHOOSE");
        $servicetype = Service::with('type')->findOrFail($id);

        return view('service::services_type.index', compact('servicetype'));
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $service = Service::findOrFail($id);
        return view('service::services.edit', compact('service'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'icon'        => 'nullable|mimes:png,jpg,jpeg,svg,gif|max:2048',
        ]);
        $service = Service::findOrFail($id);

        $imageName = $service->image;
        if ($request->hasFile('image')) {
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('upload/images/services'), $imageName);
        } else {
            $imageName = $service->image;
        }

        // Upload Icon
        if ($request->hasFile('icon')) {
            $iconName = time() . '_icon.' . $request->icon->extension();
            $request->icon->move(public_path('upload/images/services'), $iconName);
        } else {
            $iconName = null;
        }

        $iconName = $service->icon;
        if ($request->hasFile('icon')) {
            $oldiconPath = public_path('upload/images/services/' . basename($service->icon));
            if ($service->icon && file_exists($oldiconPath)) {
                unlink($oldiconPath);
            }

            // Upload new Icon
            $iconName = $request->file('icon');
            $iconName = time() . '.' . $request->icon->extension();
            $request->icon->move(public_path('upload/images/services'), $iconName);
            $service->icon = $iconName;
        }

        $service->update([
            'name' => $request->name,
            'description' => $request->description,
            'status' => $request->has('status') ? 'on' : 'off',
            'image' => $imageName,
            'icon' => $iconName,
        ]);

        return redirect()->route('services.index')->with('success', 'Service updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $service = Service::findOrFail($id);
        $service->delete();

        return redirect()->route('services.index')->with('success', 'Service deleted successfully.');
    }

    public function status($id)
    {
        $service = Service::findOrFail($id);
        if ($service->status == 'on') {
            $status = 'off';
        } else {
            $status = 'on';
        }

        $service->update([
            'status' => $status
        ]);

        return redirect()->route('services.index')->with('success', 'Service Status Updated Successfully');
    }
}
