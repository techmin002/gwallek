<?php

namespace Modules\Advisor\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Advisor\Models\Advisor;

class AdvisorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // dd('hello');
        $advisors = Advisor::latest()->get();
        return view('advisor::advisor.index', compact('advisors'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('advisor::advisor.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());
        // Validate input
        $request->validate([
            'name'        => 'required|string|max:255',
            'type'        => 'nullable|string|max:255',
            'designation' => 'nullable|string|max:255',
            'experience'  => 'nullable|string|max:255',
            'projects'    => 'nullable|string|max:255',
            'linkedin'    => 'nullable|url|max:255',
            'mail'        => 'nullable|email|max:255',
            'description' => 'nullable|string',
            'quote'       => 'nullable|string',
            'image'       => 'nullable|image|mimes:jpg,jpeg,png,svg,gif|max:2048',
            'status'      => 'nullable',
        ]);

        $imageName = '';
        if ($request->image) {
            $imageName = time() . '.' . $request->image->extension();

            $request->image->move(public_path('upload/images/advisor'), $imageName);
        }
        // Create new Advisor
        $advisor = new Advisor();
        $advisor->name = $request->name;
        $advisor->type = $request->type;
        $advisor->designation = $request->designation;
        $advisor->experience = $request->experience;
        $advisor->projects = $request->projects;
        $advisor->linkedin = $request->linkedin;
        $advisor->mail = $request->mail;
        $advisor->facebook = $request->facebook;
        $advisor->description = $request->description;
        $advisor->quote = $request->quote;
        $advisor->image = $imageName;
        $advisor->status = $request->status;
        $advisor->save();

        return redirect()->route('advisors.index')->with('success', 'Advisor created successfully.');
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        return view('advisor::show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $advisor = Advisor::findOrFail($id);
        return view('advisor::advisor.edit', compact('advisor'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // dd($request->status);
        // Validate input
        $request->validate([
            'name'        => 'required|string|max:255',
            'type'        => 'nullable|string|max:255',
            'designation' => 'nullable|string|max:255',
            'experience'  => 'nullable|string|max:255',
            'projects'    => 'nullable|string|max:255',
            'linkedin'    => 'nullable|url|max:255',
            'mail'        => 'nullable|email|max:255',
            'description' => 'nullable|string',
            'quote'       => 'nullable|string',
            'image'       => 'nullable|image|mimes:jpg,jpeg,png,svg,gif|max:2048',
            'status'      => 'nullable',
        ]);

        // Find advisor
        $advisor = Advisor::findOrFail($id);

        // Handle image update
        if ($request->hasFile('image')) {
            // delete old image
            if ($advisor->image && file_exists(public_path('upload/images/advisor/' . $advisor->image))) {
                unlink(public_path('upload/images/advisor/' . $advisor->image));
            }

            // upload new image
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('upload/images/advisor'), $imageName);
            $advisor->image = $imageName;
        }

        // Update other fields
        $advisor->name        = $request->name;
        $advisor->type        = $request->type;
        $advisor->designation = $request->designation;
        $advisor->experience  = $request->experience;
        $advisor->projects    = $request->projects;
        $advisor->linkedin    = $request->linkedin;
        $advisor->mail        = $request->mail;
        $advisor->facebook = $request->facebook;
        $advisor->description = $request->description;
        $advisor->quote       = $request->quote;
        $advisor->status      = $request->status;

        $advisor->save();

        return redirect()->route('advisors.index')->with('success', 'Advisor updated successfully.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $advisor = Advisor::findOrFail($id);

        // delete old image if exists
        if ($advisor->image && file_exists(public_path('upload/images/advisor/' . $advisor->image))) {
            unlink(public_path('upload/images/advisor/' . $advisor->image));
        }

        // delete record
        $advisor->delete();

        return redirect()->route('advisors.index')->with('success', 'Advisor deleted successfully.');
    }


    public function status($id)
    {
        $advisor = Advisor::findOrFail($id);

        // Toggle status
        $advisor->status = $advisor->status == 'on' ? 'off' : 'on';

        $advisor->save();

        // Redirect back with message
        return redirect()->back()->with('success', 'Advisor status updated successfully.');
    }
}
