<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Modules\Advisor\Models\Advisor;
use Modules\Blog\Entities\Blog;
use Modules\Branch\Entities\Branch;
use Modules\Client\Models\Client;
use Modules\Contact\Models\BlogComment;
use Modules\Contact\Models\MessageFrom;
use Modules\ProjectManager\Models\Customer;
use Modules\ProjectManager\Models\Site;
use Modules\Service\Models\Service;
use Modules\Service\Models\ServiceType;
use Modules\Setting\Entities\CompanyProfile;
use Modules\Team\Entities\Team;
use Modules\Testimonial\Entities\Testimonial;

class FrontendController extends Controller
{
    public function index()
    {
        $clients = Client::where('status', 'on')->get();
        $branches = Branch::all();
        $blogs = Blog::where('status', 'on')
            ->orderBy('created_at', 'DESC')
            ->get();
        $tests = Testimonial::where('status', 'on')->get();
        $services = Service::where('status', 'on')->get();
        $messages = MessageFrom::where('role', 'Managing Director')->latest()->first();
        $profile = CompanyProfile::first();
        return view('frontend.welcome', compact('profile', 'messages', 'services', 'tests', 'blogs', 'branches', 'clients'));
    }
    public function aboutus()
    {
       $advisors = Advisor::where('status', 'on')->get();
        // dd($advisors);
        $clients = Client::where('status', 'on')->get();
        $teams = Team::where('status', 'on')->get();
        $profile = CompanyProfile::first();
        $messages1 = MessageFrom::where('role', 'Managing Director')->latest()->first();
        $messages2 = MessageFrom::where('role', 'Executive Director')->latest()->first();
        // dd('hello about us');
        return view('frontend.pages.aboutus', compact('profile', 'messages1', 'messages2', 'teams', 'clients', 'advisors'));
    }
    public function contact()
    {
        $branches = Branch::all();
        // dd('hello about us');
        return view('frontend.pages.contact', compact('branches'));
    }




    public function details_service($id)
    {
        $type = ServiceType::with('service')->findOrFail($id);
        $pastProjects = Site::where('created_at', '<', $type->created_at)->get();
        // Pass to view
        return view('frontend.pages.details_service', compact('type', 'pastProjects'));
    }

    public function faq()
    {
        // dd('hello about us');
        return view('frontend.pages.faq');
    }
    public function project()
    {
        $sites = Site::with(['customer', 'branch'])->where('status', 'on')->get();
        return view('frontend.pages.project', compact('sites'));
    }
    public function project_details($id)
    {
        // Fetch site with related customer, branch, and images
        $site = Site::with(['customer', 'branch', 'images', 'relatedProjects'])
            ->where('status', 'on') // optional: only active sites
            ->findOrFail($id);

        return view('frontend.pages.project_details', compact('site'));
    }

    public function project_gallery($id)
    {
        // Fetch site with related customer, branch, and images
        $images = Site::with('images')->where('status', 'on')->findOrFail($id);
        return view('frontend.pages.gallery', compact('images'));
    }

    public function blog()
    {
        $blogs = Blog::where('status', 'on')->get();
        return view('frontend.pages.blog', compact('blogs'));
    }

    public function details_blog($id)
    {
        $comments = BlogComment::where('blog_id', $id)
            ->where('status', 'accept')
            ->orderBy('created_at', 'desc')
            ->get();
        $total = $comments->count();
        $blogs = Blog::where('status', 'on')->findOrFail($id);
        return view('frontend.pages.details_blog', compact('blogs', 'comments','total'));
    }

    public function service($id)
    {
        // dd("HELLO SERVICE WHY CHOOSE");
        $servicetype = Service::with('type')->findOrFail($id);

        return view('frontend.pages.service', compact('servicetype'));
    }
}
