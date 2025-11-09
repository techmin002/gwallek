<?php

namespace Modules\User\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Modules\Branch\Entities\Branch;
use Modules\Employee\Entities\Employee;
use Spatie\Permission\Models\Role;

class UsersController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('access_user_management'), 403);

        $user = Auth::user();

        $users = User::query()
            ->when($user->access_type !== 'Super Admin', fn($q) => $q->where('branch_id', $user->branch_id))
            ->latest()
            ->get();

        return view('user::users.index', compact("users"));
    }


    public function create()
    {
        abort_if(Gate::denies('access_user_management'), 403);
        $branches = Branch::all();
        return view('user::users.create', compact('branches'));
    }


    public function store(Request $request)
    {
        // dd($request->all());
        abort_if(Gate::denies('access_user_management'), 403);

        $request->validate([
            'name'      => 'required|string|max:255',
            'email'     => 'required|email|max:255|unique:users,email',
            'phone'     => 'nullable|string|max:20',
            'address'   => 'nullable|string|max:255',
            'password'  => 'required|string|min:8|max:255|confirmed'
        ]);
        // dd('hello');

        $imageName = '';
        if ($request->image) {
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('upload/images/users'), $imageName);
        }

        $role = Role::where('name', $request->role)->first();

        $user = User::create([
            'name'        => $request->name,
            'email'       => $request->email,
            'branch_id'   => $request->branch_id ?? auth()->user()->branch_id ,
            'access_type' => $request->role,
            'password'    => Hash::make($request->password),
            'image'       => $imageName,
            'role_id'     => $role->id,
            'status'      => $request->status
        ]);

        $user->assignRole($request->role);
        $employee = new Employee();
        $employee->name = $request->name;
        $employee->email = $request->email;
        $employee->phone = $request->phone;
        $employee->address = $request->address;
        $employee->role = $role->name;
        $employee->created_by = auth()->id();
        $employee->user_id = $user->id;
        $employee->status = $request->status ?? 'on';
        $employee->save();

        return redirect()->route('users.index')->with('success', 'Created Successfully');
    }



    public function edit(User $user)
    {
        abort_if(Gate::denies('access_user_management'), 403);
        return view('user::users.edit', compact('user'));
    }


    public function update(Request $request, User $user)
    {
        abort_if(Gate::denies('access_user_management'), 403);

        if ($request->password) {
            $request->validate([
                'name'     => 'required|string|max:255',
                'email'    => 'required|email|max:255|unique:users,email,' . $user->id,
                'phone'    => 'nullable|string|max:20',
                'address'  => 'nullable|string|max:255',
                'password' => 'string|min:8|max:255|confirmed'
            ]);
        } else {
            $request->validate([
                'name'     => 'required|string|max:255',
                'email'    => 'required|email|max:255|unique:users,email,' . $user->id,
                'phone'    => 'nullable|string|max:20',
                'address'  => 'nullable|string|max:255',
            ]);
        }

        $imageName = '';
        if ($request->image) {
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('upload/images/users'), $imageName);
        } else {
            $imageName = $user->image;
        }

        $role_id = Role::where('name', $request->role)->first();

        $user->update([
            'name'        => $request->name,
            'email'       => $request->email,
            'phone'       => $request->phone,
            'address'     => $request->address,
            'password'    => $request->password ? Hash::make($request->password) : $user->password,
            'image'       => $imageName,
            'role_id'     => $role_id->id,
            'access_type' => $role_id->name,
            'status'      => $request->status,
        ]);

        $user->syncRoles($request->role);

        return redirect()->route('users.index')->with('success', 'Updated Successfully');
    }



    public function destroy(User $user)
    {
        abort_if(Gate::denies('access_user_management'), 403);

        $user->delete();

        return redirect()->route('users.index')->with('success', 'Removed Successfully');
    }

    public function status($id)
    {
        abort_if(Gate::denies('access_user_management'), 403);
        $user = User::findOrfail($id);
        if ($user->status == 'on') {
            $status = 'off';
        } else {
            $status = 'on';
        }
        $user->update([
            'status' => $status
        ]);
        return redirect()->route('users.index')->with('success', 'Status Updated Successfully');
    }
}
