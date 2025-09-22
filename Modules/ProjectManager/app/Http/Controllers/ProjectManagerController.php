<?php

namespace Modules\ProjectManager\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Modules\ProjectManager\Models\ProjectAssignment;
use Modules\ProjectManager\Models\Site;
use Modules\ProjectManager\Models\SiteImages;

class ProjectManagerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user();

        if ($user->access_type == 'Super Admin') {
            $managers = User::with('branch')
                ->where('access_type', 'Manager')
                ->get();
        } else {
            $managers = User::with('branch')
                ->where('access_type', 'Manager')
                ->where('branch_id', $user->branch_id)
                ->get();
        }

        return view('projectmanager::manager.index', compact('managers'));
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
    public function store(Request $request) {}

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        $manager = User::findOrFail($id);

        // Manager के branch के staff लाओ
        $branchId = $manager->branch_id;
        // $staffs = User::where('branch_id', $branchId)
        //     ->where('access_type', 'Staff')
        //     ->get();

        $sites = Site::where('assign_to', $id)->get();

        // return view('manager.details', compact('manager', 'sites', 'staffs'));
        return view('projectmanager::manager.details', compact('manager', 'sites'));
    }


    public function viewSiteDetails($id)
    {
        $site = Site::with(['assignments.staff'])->findOrFail($id); // load assignments and staff
        return view('projectmanager::site.details', compact('site'));
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
    public function update(Request $request, $id) {}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id) {}

    public function assignStaff(Request $request, $id)
    {
        // dd($request->all());
        $request->validate([
            'branch_id'  => 'required|exists:branches,id',
            'site_id'    => 'required|exists:sites,id',
            'manager_id' => 'required|exists:users,id',
            'staff_ids'  => 'required|array', // array of staff
            'staff_ids.*' => 'exists:users,id', // each staff must exist
            'assign_date' => 'required|date',
        ]);

        foreach ($request->staff_ids as $staffId) {
            ProjectAssignment::create([
                'branch_id'  => $request->branch_id,
                'site_id'    => $request->site_id,
                'manager_id' => $request->manager_id,
                'staff_id'   => $staffId,
                'assign_date' => $request->assign_date,
            ]);
        }

        return redirect()->back()->with('success', 'Staff assigned successfully!');
    }

    public function removeStaff($id)
    {
        // dd($id);
        $assignment = ProjectAssignment::findOrFail($id);
        $assignment->delete();

        return redirect()->back()->with('success', 'Staff removed from this site successfully.');
    }

    public function Siteimages($id)
    {
        $site = Site::with('images')->findOrFail($id);
        return view('projectmanager::siteimage.index', compact('site'));
    }

    public function storeSiteImages(Request $request, $id)
    {
        // dd($request->all());
        $site = Site::findOrFail($id);

        $request->validate([
            'images.*' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:4096',
            'status' => 'nullable|in:on,off',
        ]);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $index => $file) {
                $imageName = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('upload/sites/'), $imageName);

                SiteImages::create([
                    'site_id' => $site->id,
                    'image' => $imageName,
                    'status' => $request->status ?? 'on',
                ]);
            }
        }

        return redirect()->back()->with('success', 'Images uploaded successfully!');
    }

    public function siteImageStatus($id)
    {
        $image = SiteImages::findOrFail($id);

        // Toggle status
        $image->status = $image->status === 'on' ? 'off' : 'on';
        $image->save();

        return redirect()->back()->with('success', 'Image status updated successfully!');
    }
    public function destroySiteImage($id)
    {
        $image = SiteImages::findOrFail($id);

        // Delete file from storage if exists
        $imagePath = public_path('upload/sites/' . $image->image);
        if (file_exists($imagePath)) {
            unlink($imagePath);
        }

        $image->delete();

        return redirect()->back()->with('success', 'Image deleted successfully!');
    }
}
