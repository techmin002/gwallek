<?php

namespace Modules\ProjectManager\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Modules\Branch\Entities\Branch;
use Modules\Finance\Models\CashCounter;
use Modules\ProjectManager\Models\Customer;
use Modules\ProjectManager\Models\Site;
use Modules\ProjectManager\Models\SitePayment;
use Modules\ProjectManager\Models\SitePaymentDetails;

class SiteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user();

        if ($user->access_type == 'Super Admin') {
            // Super Admin can see all branches
            $branches = Branch::all();
            $staff = User::where('access_type', 'Manager')->get(); // Only managers
            $customers = Customer::all();
            $sites = Site::with(['branch', 'staff', 'customer'])->get();
        } else {
            // Normal user → only see own branch managers & customers
            $branches = null; // No branch dropdown
            $staff = User::where('branch_id', $user->branch_id)
                ->where('access_type', 'Manager')
                ->get(); // Only managers from own branch
            $customers = Customer::where('branch_id', $user->branch_id)->get();
            $sites = Site::with(['branch', 'staff', 'customer'])
                ->where('branch_id', $user->branch_id)
                ->get();
        }

        return view('projectmanager::site.index', compact('branches', 'staff', 'customers', 'sites'));
    }



    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('projectmanager::create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());

        $request->validate([
            'name' => 'required|string|max:255',
            'amount' => 'required|numeric',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'branch_id' => 'required|exists:branches,id',
            'assign_to' => 'required|exists:users,id',
            'customer_id' => 'required|exists:customers,id',
            'contract_image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:4096',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:4096',

            'payment_method' => 'nullable|string|in:cash,online,check',
            'paid_amount' => 'nullable|numeric|min:0',
            'check_number' => 'nullable|string',
            'online_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:4096',
        ]);

        // ✅ Create Site
        $site = new Site();
        $site->name = $request->name;
        $site->amount = $request->amount;
        $site->start_date = $request->start_date;
        $site->end_date = $request->end_date;
        $site->branch_id = $request->branch_id;
        $site->assign_to = $request->assign_to;
        $site->customer_id = $request->customer_id;
        $site->description = $request->description;
        $site->status = $request->status;
        $site->location = $request->location;
        $site->progress_status = $request->progress_status;
        $site->project_area = $request->project_area;
        $site->contract_id = $request->contract_id;
        $site->overview = $request->overview;
        $site->key_features = $request->key_features;
        $site->technical_specifications = $request->technical_specifications;
        $site->environmental_impact = $request->environmental_impact;

        // ✅ Upload site image
        if ($request->hasFile('image')) {
            $imageName = time() . '_' . $request->image->getClientOriginalName();
            $request->image->move(public_path('upload/sites/'), $imageName);
            $site->image = $imageName;
        }

        // ✅ Upload contract image (required)
        if ($request->hasFile('contract_image')) {
            $contractName = time() . '_' . $request->contract_image->getClientOriginalName();
            $request->contract_image->move(public_path('upload/sites/contracts/'), $contractName);
            $site->contract_image = $contractName;
        }

        $site->save();

        // ✅ Handle Online Image Upload
        $onlineImagePath = null;
        if ($request->hasFile('online_image')) {
            $onlineImage = $request->file('online_image');
            $onlineImagePath = time() . '.' . $onlineImage->getClientOriginalExtension();
            $onlineImage->move(public_path('upload/images/Payment'), $onlineImagePath);
        }

        // ✅ Payment calculations
        $totalAmount = $request->amount ?? 0;
        $paidAmount = $request->paid_amount ?? 0;
        $dueAmount  = $totalAmount - $paidAmount;

        // ✅ Create Payment record
        $payment = SitePayment::create([
            'site_id' => $site->id,
            'amount' => $totalAmount,
            'paid_amount' => $paidAmount,
            'due_amount' => $dueAmount,
            'payment_method' => $request->payment_method,
            'check_number' => $request->check_number,
            'online_image' => $onlineImagePath,
        ]);

        // ✅ Store Payment Details
        SitePaymentDetails::create([
            'site_id' => $site->id,
            'payment_id' => $payment->id,
            'amount' => $paidAmount,
            'payment_method' => $request->payment_method,
            'check_number' => $request->check_number,
            'online_image' => $onlineImagePath,
            'date' => now(), // Or $request->date if user selects
        ]);

        // ✅ Branch-wise Cash Counter Update
        if ($request->payment_method === 'cash' && $paidAmount > 0) {
            $branchId = $site->branch_id;

            $cashCounter = CashCounter::where('branch_id', $branchId)->first();

            if ($cashCounter) {
                $cashCounter->opening_amount = ($cashCounter->opening_amount ?? 0) + $paidAmount;
                $cashCounter->due_amount     = ($cashCounter->due_amount ?? 0) + $paidAmount;
                $cashCounter->save();
            } else {
                CashCounter::create([
                    'branch_id'      => $branchId,
                    'opening_amount' => $paidAmount,
                    'due_amount'     => $paidAmount,
                ]);
            }
        }

        return redirect()->back()->with('success', 'Site created successfully!');
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
        return view('projectmanager::edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // dd($request->all());
        $site = Site::findOrFail($id);

        // Validate input
        $request->validate([
            'name' => 'required|string|max:255',
            'amount' => 'required|numeric',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'branch_id' => 'required|exists:branches,id',
            'assign_to' => 'required|exists:users,id',
            'customer_id' => 'required|exists:customers,id',
            'location' => 'required|string|max:255',
            'progress_status' => 'required|in:ongoing,completed',
            'project_area' => 'required|string|max:255',
            'contract_id' => 'required|string|max:255',
            'overview' => 'required|string',
            'key_features' => 'nullable|string',
            'technical_specifications' => 'nullable|string',
            'environmental_impact' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:4096',
            'contract_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:4096',
            'status' => 'nullable|in:on,off',
            'description' => 'nullable|string',
        ]);

        // Update fields
        $site->name = $request->name;
        $site->amount = $request->amount;
        $site->start_date = $request->start_date;
        $site->end_date = $request->end_date;
        $site->branch_id = $request->branch_id;
        $site->assign_to = $request->assign_to;
        $site->customer_id = $request->customer_id;
        $site->location = $request->location;
        $site->progress_status = $request->progress_status;
        $site->project_area = $request->project_area;
        $site->contract_id = $request->contract_id;
        $site->overview = $request->overview;
        $site->key_features = $request->key_features;
        $site->technical_specifications = $request->technical_specifications;
        $site->environmental_impact = $request->environmental_impact;
        $site->description = $request->description;
        $site->status = $request->has('status') && $request->status === 'on' ? 'on' : 'off';

        // Upload site image (optional)
        if ($request->hasFile('image')) {
            if ($site->image && file_exists(public_path('upload/sites/' . $site->image))) {
                unlink(public_path('upload/sites/' . $site->image));
            }
            $imageName = time() . '_' . $request->image->getClientOriginalName();
            $request->image->move(public_path('upload/sites/'), $imageName);
            $site->image = $imageName;
        }

        // Upload contract paper (required)
        if ($request->hasFile('contract_image')) {
            if ($site->contract_image && file_exists(public_path('upload/sites/contracts/' . $site->contract_image))) {
                unlink(public_path('upload/sites/contracts/' . $site->contract_image));
            }
            $contractName = time() . '_' . $request->contract_image->getClientOriginalName();
            $request->contract_image->move(public_path('upload/sites/contracts/'), $contractName);
            $site->contract_image = $contractName;
        }

        $site->save();

        return redirect()->back()->with('success', 'Site updated successfully!');
    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $site = Site::findOrFail($id);

        // Delete site image if exists
        if ($site->image && file_exists(public_path('upload/sites/' . $site->image))) {
            unlink(public_path('upload/sites/' . $site->image));
        }

        // Delete contract image if exists
        if ($site->contract_image && file_exists(public_path('upload/sites/' . $site->contract_image))) {
            unlink(public_path('upload/sites/' . $site->contract_image));
        }

        $site->delete();

        return redirect()->back()->with('success', 'Site deleted successfully!');
    }



    public function status($id)
    {
        $site = Site::findOrFail($id);

        // Toggle status
        $site->status = $site->status === 'on' ? 'off' : 'on';
        $site->save();

        return redirect()->back()->with('success', 'Site status updated successfully!');
    }



    public function getCustomers(Request $request)
    {
        $customers = Customer::where('branch_id', $request->branch_id)->get();
        return response()->json(['customers' => $customers]);
    }

    public function getBranchManagers($branch_id)
    {
        $managers = User::where('branch_id', $branch_id)
            ->where('access_type', 'Manager')
            ->get();
        return response()->json($managers);
    }
    public function getBranchStaff($branchId)
    {
        $staff = User::where('branch_id', $branchId)
            ->where('access_type', 'Staff')
            ->select('id', 'name')
            ->get();

        return response()->json($staff);
    }
}
