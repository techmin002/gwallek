<?php

namespace Modules\Contact\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Modules\Contact\Models\Contact;
use Modules\Contact\Models\MessageFrom;

class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();


        if ($user->access_type !== 'Super Admin') {
        
            $contacts = Contact::where('branch_id', $user->branch_id)
                ->orderBy('created_at', 'desc')
                ->get();
        } else {
            $contacts = Contact::orderBy('created_at', 'desc')->get();
        }

        return view('contact::contact.index', compact('contacts'));
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
        $request->validate([
            'branch_id' => ['required', 'exists:branches,id'],
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'nullable|string|max:255',
            'message' => 'required|string',
        ]);

        Contact::create([
            'branch_id' => $request->branch_id,
            'name' => $request->name,
            'email' => $request->email,
            'subject' => $request->subject,
            'message' => $request->message,
            'status' => 'pending', // default status
        ]);

        return redirect()->back()->with('success', 'Message sent successfully!');
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
        $contact = Contact::findOrFail($id);
        $contact->delete();

        return redirect()->back()->with('success', 'Contact deleted successfully!');
    }

    public function toggleStatus($id)
    {
        $contact = Contact::findOrFail($id);

        if ($contact->status == 'pending') {
            $contact->status = 'read';
            $contact->save();
        }

        return redirect()->back()->with('success', 'Contact status updated successfully!');
    }

    public function messagefrommd()
    {
        $messages = MessageFrom::where('role', 'Managing Director')->latest()->first();
        return view('contact::message_from.index', compact('messages'));
    }

    public function messagefromed()
    {
        $messages = MessageFrom::where('role', 'Executive Director')->latest()->first();
        return view('contact::message_from.index', compact('messages'));
    }

    public function messagefromupdate(Request $request, $id)
    {
        // dd($id);
        $request->validate([
            'name' => 'required|string|max:255',
            'role' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,gif',
            'signature' => 'nullable|image|mimes:jpg,jpeg,png,gif',
        ]);

        $message = MessageFrom::findOrFail($id);
        $message->name = $request->name;
        $message->role = $request->role;
        $message->description = $request->description;

        // Handle Image Upload
        if ($request->hasFile('image')) {
            // Delete old image
            if ($message->image && file_exists(public_path('upload/images/message_from/' . $message->image))) {
                unlink(public_path('upload/images/message_from/' . $message->image));
            }
            $filename = time() . '_image.' . $request->image->getClientOriginalExtension();
            $request->image->move(public_path('upload/images/message_from'), $filename);
            $message->image = $filename;
        }

        // Handle Signature Upload
        if ($request->hasFile('signature')) {
            if ($message->signature && file_exists(public_path('upload/images/message_from/' . $message->signature))) {
                unlink(public_path('upload/images/message_from/' . $message->signature));
            }
            $filename = time() . '_signature.' . $request->signature->getClientOriginalExtension();
            $request->signature->move(public_path('upload/images/message_from'), $filename);
            $message->signature = $filename;
        }

        $message->save();

        return redirect()->back()->with('success', 'Message updated successfully!');
    }
}
