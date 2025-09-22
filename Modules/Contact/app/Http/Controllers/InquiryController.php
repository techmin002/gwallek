<?php

namespace Modules\Contact\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Contact\Models\Inquiry;

class InquiryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $inquiry = Inquiry::orderBy('created_at', 'desc')->get();
        return view('contact::inquiry.index', compact('inquiry'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('contact::create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());
        // dd($request->all());
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'project_type' => 'nullable|string|max:255',
            'description' => 'required|string',
        ]);

        Inquiry::create([
            'name' => $request->name,
            'email' => $request->email,
            'project_type' => $request->project_type,
            'description' => $request->description,
            'status' => 'pending', // default status
        ]);

        return redirect()->back()->with('success', 'Inquiry sent successfully!');
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        return view('contact::show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return view('contact::edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id) {}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $inquiry = Inquiry::findOrFail($id);
        $inquiry->delete();

        return redirect()->back()->with('success', 'Inquiry deleted successfully!');
    }

    public function toggleStatus($id)
    {
        // dd('hello');
        $inquiry = Inquiry::findOrFail($id);
        if ($inquiry->status == 'pending') {
            $inquiry->status = 'read';
            $inquiry->save();
        }

        return redirect()->back()->with('success', 'Inquiry status updated successfully!');
    }
}
