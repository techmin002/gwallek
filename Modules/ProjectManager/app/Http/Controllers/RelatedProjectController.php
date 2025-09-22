<?php

namespace Modules\ProjectManager\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\ProjectManager\Models\RelatedProject;
use Modules\ProjectManager\Models\Site;

class RelatedProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($site_id)
    {
        $site = Site::with('relatedProjects')->findOrFail($site_id);
        return view('projectmanager::related_project.index', compact('site'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Site $site)
    {
        return view('projectmanager::related_project.create', compact('site'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $siteId)
    {
        // dd($siteId);
        // Validate input
        $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'description' => 'nullable|string',
            'status' => 'nullable|in:on,off',
        ]);

        // Find the site
        $site = Site::findOrFail($siteId);

        // Handle image upload
        $imageName = null;
        if ($request->hasFile('image')) {
            $imageName = time() . '_' . $request->file('image')->getClientOriginalName();
            $request->file('image')->move(public_path('upload/site/related_projects'), $imageName);
        }

        // Create Related Project
        $relatedProject = new RelatedProject();
        $relatedProject->site_id = $site->id;
        $relatedProject->name = $request->name;
        $relatedProject->image = $imageName;
        $relatedProject->description = $request->description;
        $relatedProject->status = $request->status == 'on' ? 'on' : 'off';
        $relatedProject->save();

        return redirect()->route('relatedproject.index', $site->id)
            ->with('success', 'Related Project created successfully!');
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
        $project = RelatedProject::findOrFail($id);
        return view('projectmanager::related_project.edit', compact('project'));
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // dd($request->all());
        $project = RelatedProject::findOrFail($id);

        // Validation
        $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'description' => 'nullable|string',
            'status' => 'nullable|in:on,off'
        ]);

        // Update fields
        $project->name = $request->name;
        $project->description = $request->description;
        $project->status = $request->status ?? 'off';

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image
            if ($project->image && file_exists(public_path('upload/site/related_projects/' . $project->image))) {
                unlink(public_path('upload/site/related_projects/' . $project->image));
            }

            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('upload/site/related_projects/'), $imageName);
            $project->image = $imageName;
        }

        $project->save();

        return redirect()->route('relatedproject.index', $project->site_id)
            ->with('success', 'Related Project updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $project = RelatedProject::findOrFail($id);

        // Delete image from storage if exists
        if ($project->image && file_exists(public_path('upload/site/related_projects/' . $project->image))) {
            unlink(public_path('upload/site/related_projects/' . $project->image));
        }

        $project->delete();

        return redirect()->back()->with('success', 'Related Project deleted successfully.');
    }

    public function status($id)
    {
        $project = RelatedProject::findOrFail($id);

        // Toggle 'on' / 'off'
        $project->status = ($project->status == 'on') ? 'off' : 'on';
        $project->save();

        return redirect()->back()->with('success', 'Project status updated successfully.');
    }
}
