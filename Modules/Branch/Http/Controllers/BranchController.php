<?php

namespace Modules\Branch\Http\Controllers;

use App\Models\User;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Hash;
use Modules\Branch\Entities\Branch;
use Modules\Employee\Entities\Employee;
use Spatie\Permission\Models\Role;

class BranchController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $branches = Branch::with('user')->get();
        // dd($branches);
        return view('branch::branch.index', compact('branches'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('branch::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => ['required'],
                'email'    => 'required|email|max:255|unique:users,email',
                'password' => 'required|string|min:8|max:255|confirmed',
                'phone' => ['required'],
                'address' => ['required'],
                'admin_name' => ['required'],
                'admin_email' => 'required|email|max:255|unique:users,email',
                'admin_phone' => ['required'],
                'admin_address' => ['required'],
            ]);

            $role = Role::where('name', 'Admin')->first();

            // Branch Create
            $branch = new Branch();
            $branch->name = $request->name;
            $branch->email = $request->email;
            $branch->phone = $request->phone;
            $branch->address = $request->address;
            $branch->status = $request->status ?? 'on';
            $branch->save();

            // User Create
            $user = User::create([
                'name'       => $request->admin_name,
                'email'      => $request->admin_email,
                'branch_id'  => $branch->id,
                'created_by' => auth()->id(),
                'access_type' => $role->name,
                'password'   => Hash::make($request->password),
                'role_id'    => $role->id,
                'status'     => $request->status ?? 'on',
            ]);

            $user->assignRole('Admin');

            // Employee Create
            $employee = new Employee();
            $employee->name = $request->admin_name;
            $employee->email = $request->admin_email;
            $employee->phone = $request->admin_phone;
            $employee->address = $request->admin_address;
            $employee->role = $role->name;
            $employee->created_by = auth()->id();
            $employee->user_id = $user->id;
            $employee->status = $request->status ?? 'on';
            $employee->save();

            return back()->with('success', 'Branch Created Successfully!');
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Validation errors handle
            return back()->withErrors($e->errors())->withInput();
        } catch (\Illuminate\Database\QueryException $e) {
            return back()->with('error', 'Database Error: ' . $e->getMessage())->withInput();
        } catch (\Exception $e) {
            // Other errors handle
            return back()->with('error', 'Something went wrong: ' . $e->getMessage())->withInput();
        }
    }


    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('branch::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('branch::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        // dd($request->all());
        $branch = Branch::findOrfail($id);
        $branch->name = $request['name'];
        $branch->email = $request['email'];
        $branch->phone = $request['phone'];
        $branch->address = $request['address'];
        $branch->save();

        $user = User::where('id', $request['userId'])->first();
        $user->name = $request['admin_name'];
        $user->email = $request['admin_email'];
        $user->save();
        $user->assignRole('Admin');
        $employee = Employee::where('user_id', $request['userId'])->first();
        $employee->name = $request['admin_name'];
        $employee->email = $request['admin_email'];
        $employee->phone = $request['admin_phone'];
        $employee->address = $request['admin_address'];
        $employee->save();
        return back()->with('success', 'Branch Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        $branch = Branch::findOrfail($id);
        $user = User::where('branch_id', $id)->first();
        if ($user) {
            $user->branch_id = null;
            $user->save();
        }
        $branch->delete();
        return back()->with('success', 'Branch Deleted Successfully');
    }
}
