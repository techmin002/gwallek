<?php

namespace Modules\ProjectManager\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Branch\Entities\Branch;
use Modules\ProjectManager\Models\Customer;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (auth()->user()->access_type == 'Super Admin') {
            $branches = Branch::all();
            $allCustomers = Customer::with('branch')->get(); // Naya variable
        } else {
            $branch_id = auth()->user()->branch_id;
            $branches = Branch::where('id', $branch_id)->get();
            $allCustomers = Customer::with('branch')
                ->where('branch_id', $branch_id)
                ->get(); // Naya variable
        }

        return view('projectmanager::customer.index', [
            'branches' => $branches,
            'customers' => $allCustomers // Blade me 'customers' use karenge
        ]);
    }




    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('projectmanager::customer.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->status);
        // Validation
        $request->validate([
            'name'      => 'required|string|max:255',
            'phone'     => 'required|string|max:20',
            'email'     => 'nullable|email|unique:customers,email',
            'address'   => 'nullable|string|max:500',
            'status'    => 'required|in:on,off',
            'branch_id' => 'nullable|exists:branches,id',
            'image'     => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Image validation
        ]);

        // Branch logic
        if (auth()->user()->access_type == 'Super Admin') {
            $branch_id = $request->branch_id;
        } else {
            $branch_id = auth()->user()->branch_id;
        }

        // Store customer
        $customer = new Customer();
        $customer->name = $request->name;
        $customer->phone = $request->phone;
        $customer->email = $request->email;
        $customer->address = $request->address;
        $customer->status = $request->has('status') ? 'on' : 'off';
        $customer->branch_id = $branch_id;

        // Image upload
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('upload/images/customers'), $imageName);
            $customer->image = $imageName;
        }

        $customer->save();

        return redirect()->route('customers.index')
            ->with('success', 'Customer created successfully!');
    }



    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        return view('projectmanager::show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return view('projectmanager::customer.edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Find customer
        $customer = Customer::findOrFail($id);

        // Validation
        $request->validate([
            'name'      => 'required|string|max:255',
            'phone'     => 'required|string|max:20',
            'email'     => 'nullable|email|unique:customers,email,' . $customer->id,
            'address'   => 'nullable|string|max:500',
            'status'    => 'required|in:on,off',
            'branch_id' => 'nullable|exists:branches,id',
            'image'     => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // Branch logic
        if (auth()->user()->access_type == 'Super Admin') {
            $branch_id = $request->branch_id;
        } else {
            $branch_id = auth()->user()->branch_id;
        }

        // Update customer data
        $customer->name = $request->name;
        $customer->phone = $request->phone;
        $customer->email = $request->email;
        $customer->address = $request->address;
        $customer->status = $request->has('status') ? 'on' : 'off';
        $customer->branch_id = $branch_id;

        // Image upload
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($customer->image && file_exists(public_path('upload/images/customers/' . $customer->image))) {
                unlink(public_path('upload/images/customers/' . $customer->image));
            }

            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('upload/images/customers'), $imageName);
            $customer->image = $imageName;
        }

        $customer->save();

        return redirect()->route('customers.index')
            ->with('success', 'Customer updated successfully!');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $customer = Customer::findOrFail($id);

        // Optional: delete customer image if exists
        if ($customer->image && file_exists(public_path('upload/images/customers/' . $customer->image))) {
            unlink(public_path('upload/images/customers/' . $customer->image));
        }

        $customer->delete();

        return redirect()->back()->with('success', 'Customer deleted successfully!');
    }

    public function status($id)
    {
        $customer = Customer::findOrFail($id);

        // Toggle status
        $customer->status = $customer->status === 'on' ? 'off' : 'on';
        $customer->save();

        return redirect()->back()->with('success', 'Customer status updated successfully!');
    }
}
