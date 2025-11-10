<?php

namespace Modules\Client\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Modules\Client\Models\Client;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $clients = Client::latest()->get();
        return view('client::clients.index', compact('clients'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('client::clients.create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        $imageName = '';
        if ($request->image) {
            $imageName = time() . '.' . $request->image->extension();

            $request->image->move(public_path('upload/images/clients'), $imageName);
        }
        client::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'phone' => $request['phone'],
            'designation' => $request['designation'],
            'introduction' => $request['introduction'],
            'status' => $request['status'],
            'image' => $imageName
        ]);

        return redirect()->route('clients.index')->with('success', 'Created Successfully');
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        // return view('client::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        $client = client::findOrfail($id);
        return view('client::clients.edit', compact('client'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        $client = client::findOrfail($id);
        if ($request->image) {
            $imageName = time() . '.' . $request->image->extension();

            $request->image->move(public_path('upload/images/clients'), $imageName);
        } else {
            $imageName = $client->image;
        }
        $client->update([
            'name' => $request['name'],
            'email' => $request['email'],
            'phone' => $request['phone'],
            'designation' => $request['designation'],
            'introduction' => $request['introduction'],
            'status' => $request['status'],
            'image' => $imageName
        ]);

        return redirect()->route('clients.index')->with('success', 'Created Successfully');
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        $client = client::findOrfail($id);
        $client->delete();

        return redirect()->route('clients.index')->with('success', 'Removed Successfully');
    }

    public function status($id)
    {
        $client = client::findOrfail($id);
        if ($client->status == 'on') {
            $status = 'off';
        } else {
            $status = 'on';
        }
        $client->update([
            'status' => $status
        ]);
        return redirect()->route('clients.index')->with('success', 'Status Updated Successfully');
    }
}
