
@extends('frontend.layouts.master')
@section('title', 'Gwallek Nirman Sewa')
@section('content')
    <!-- get a quotes modal  -->
    <div class="modal fade gns-split-modal" id="quoteModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="row g-0">
                    <!-- Left Side - Construction Image -->
                    <div class="col-lg-6 d-none d-lg-block gns-modal-image">
                        <div class="gns-image-overlay"></div>
                        <div class="gns-image-content">
                            <h3>Let's Build Together</h3>
                            <p>Get a customized quote for your construction project</p>
                        </div>
                    </div>

                    <!-- Right Side - Compact Form -->
                    <div class="col-lg-6 gns-form-side">
                        <div class="modal-header border-0">
                            <h5 class="modal-title">Quick Quote Request</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form id="gnsQuoteForm" action="{{ route('inquiry.store') }}" method="POST">
                                @csrf
                                <div class="mb-3">
                                    <input type="text" name="name" class="form-control" placeholder="Your Name"
                                        required>
                                </div>
                                <div class="mb-3">
                                    <input type="email" name="email" class="form-control" placeholder="Email" required>
                                </div>
                                <div class="mb-3">
                                    <select class="form-select" name="project_type" required>
                                        <option selected disabled value="">Project Type</option>
                                        <option value="hydropower">Hydropower</option>
                                        <option value="building">Building</option>
                                        <option value="road_bridge">Road/Bridge</option>
                                        <option value="other">Other</option>
                                    </select>

                                </div>
                                <div class="mb-3">
                                    <textarea name="description" class="form-control" rows="4" placeholder="Enter Description"></textarea>
                                </div>
                                <button type="submit" class="btn btn-block gns-submit-btn">
                                    Get Quote <i class="fas fa-arrow-right ms-2"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <section class="breadcrumb-hero">
        <div class="container breadcrumb-content">
            <h1 class="py-5 mt-5">Our Project</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb justify-content-center mb-0">
                    <li class="breadcrumb-item"><a href="/"><i class="bi bi-house-door-fill"></i> Home</a></li>
                    <!-- <li class="breadcrumb-item"><a href="#"><i class="bi bi-gear-fill"></i> Services</a></li> -->
                    <li class="breadcrumb-item active" aria-current="page"><i class="bi bi-code-slash"></i>Our Project</li>
                </ol>
            </nav>
        </div>
    </section>

    <!-- our project start-->
    <!-- Projects Section -->
    <section id="projects" class="py-5 position-relative overflow-hidden">
        <!-- Background Elements -->
        <div class="position-absolute top-0 start-0 w-100 h-100" style="z-index: -1;">
            <div class="projects-bg-pattern"></div>
        </div>

        <div class="container">
            <!-- Section Header -->
            <div class="row justify-content-center">
                <div class="col-lg-8 text-center mb-5">
                    <h2 class="display-4 fw-bold text-primary-custom position-relative d-inline-block">
                        <span class="section-title-bg">Our Projects</span>
                        <span class="section-title-text">Our Projects</span>
                    </h2>
                    <div class="section-divider mx-auto mt-3"></div>
                    <p class="lead mt-4">Transforming visions into reality through engineering excellence</p>
                </div>
            </div>

            <!-- Project Filters -->
            <div class="row mb-5">
                <div class="col-12 animate-on-scroll">
                    <div class="project-filters">
                        <ul class="nav nav-pills justify-content-center" id="project-tab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="all-tab" data-bs-toggle="pill" data-bs-target="#all"
                                    type="button" role="tab" aria-controls="all" aria-selected="true">
                                    <i class="fas fa-layer-group me-2"></i>All Projects
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="ongoing-tab" data-bs-toggle="pill" data-bs-target="#ongoing"
                                    type="button" role="tab" aria-controls="ongoing" aria-selected="false">
                                    <i class="fas fa-hard-hat me-2"></i>Ongoing
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="completed-tab" data-bs-toggle="pill"
                                    data-bs-target="#completed" type="button" role="tab" aria-controls="completed"
                                    aria-selected="false">
                                    <i class="fas fa-check-circle me-2"></i>Completed
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="hydropower-tab" data-bs-toggle="pill"
                                    data-bs-target="#hydropower" type="button" role="tab"
                                    aria-controls="hydropower" aria-selected="false">
                                    <i class="fas fa-water me-2"></i>Hydropower
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="road-tab" data-bs-toggle="pill" data-bs-target="#road"
                                    type="button" role="tab" aria-controls="road" aria-selected="false">
                                    <i class="fas fa-road me-2"></i>Road & Bridge
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="building-tab" data-bs-toggle="pill"
                                    data-bs-target="#building" type="button" role="tab" aria-controls="building"
                                    aria-selected="false">
                                    <i class="fas fa-building me-2"></i>Building
                                </button>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Projects Grid -->
            <div class="row g-4 project-grid">
                @foreach ($sites as $site)
                    @php
                        $categories = [];

                        // Step 1: Status based category
                        $categories[] = $site->progress_status; // ongoing / completed

                        // Step 2: Name based category
                        $name = strtolower($site->name);
                        if (str_contains($name, 'road') || str_contains($name, 'bridge')) {
                            $categories[] = 'road';
                        }
                        if (
                            str_contains($name, 'building') ||
                            str_contains($name, 'mall') ||
                            str_contains($name, 'hospital') ||
                            str_contains($name, 'hotel')
                        ) {
                            $categories[] = 'building';
                        }
                        if (
                            str_contains($name, 'hydro') ||
                            str_contains($name, 'dam') ||
                            str_contains($name, 'power')
                        ) {
                            $categories[] = 'hydropower';
                        }

                        $categoryAttr = implode(' ', $categories);
                    @endphp

                    <div class="col-lg-4 col-md-6 project-item" data-category="{{ $categoryAttr }}">
                        <div class="project-card">
                            <div class="project-image">
                                <img src="{{ asset('upload/sites/' . $site->image) }}" alt="{{ $site->name }}"
                                    class="img-fluid">
                            </div>
                            <div class="project-overlay">
                                <div
                                    class="project-badge {{ $site->progress_status == 'ongoing' ? 'ongoing' : 'completed' }}">
                                    {{ ucfirst($site->progress_status) }}
                                </div>
                                <div class="project-content">
                                    <h5>{{ $site->name }}</h5>
                                    <div class="project-meta">
                                        <span><i class="fas fa-map-marker-alt"></i> {{ $site->location }}</span>
                                        <span><i class="fas fa-rupee-sign"></i> {{ $site->amount }} NPR</span>
                                    </div>
                                    <p class="project-desc">{!! $site->description !!}</p>
                                </div>
                                <div class="project-hover-content">
                                    <a href="{{ route('frontend.project_details', $site->id) }}"
                                        class="btn btn-outline-light btn-sm me-2">
                                        <i class="fas fa-info-circle me-1"></i> Details
                                    </a>
                                    <a href="{{ route('frontend.project_gallery', $site->id) }}"
                                        class="btn btn-secondary-custom btn-sm">
                                        <i class="fas fa-images me-1"></i> Gallery
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach

                {{-- <!-- Project 2 - Hotel -->
                <div class="col-lg-4 col-md-6 project-item" data-category="ongoing building">
                    <div class="project-card">
                        <div class="project-image">
                            <img src="https://images.unsplash.com/photo-1600607688969-a5bfcd646154?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80"
                                alt="Hotel Project" class="img-fluid">
                        </div>
                        <div class="project-overlay">
                            <div class="project-badge ongoing">Ongoing</div>
                            <div class="project-content">
                                <h5>Hotel Radisson - Dhangadi</h5>
                                <div class="project-meta">
                                    <span><i class="fas fa-map-marker-alt"></i> Dhangadi</span>
                                    <span><i class="fas fa-rupee-sign"></i> 304,000,000.00 NPR</span>
                                </div>
                                <p class="project-desc">Luxury hotel construction in Dhangadi</p>
                            </div>
                            <div class="project-hover-content">
                                <a href="/project_detail.html" class="btn btn-outline-light btn-sm me-2">
                                    <i class="fas fa-info-circle me-1"></i> Details
                                </a>
                                <a href="#" class="btn btn-secondary-custom btn-sm">
                                    <i class="fas fa-images me-1"></i> Gallery
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Project 3 - Road -->
                <div class="col-lg-4 col-md-6 project-item" data-category="ongoing road">
                    <div class="project-card">
                        <div class="project-image">
                            <img src="https://images.unsplash.com/photo-1605276374104-dee2a0ed3cd6?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80"
                                alt="Road Project" class="img-fluid">
                        </div>
                        <div class="project-overlay">
                            <div class="project-badge ongoing">Ongoing</div>
                            <div class="project-content">
                                <h5>Khalanga - Khar - Dethala Road</h5>
                                <div class="project-meta">
                                    <span><i class="fas fa-map-marker-alt"></i> Darchula</span>
                                    <span><i class="fas fa-rupee-sign"></i> 17,543,978.77 NPR</span>
                                </div>
                                <p class="project-desc">Road construction and upgrading in Darchula district</p>
                            </div>
                            <div class="project-hover-content">
                                <a href="/project_detail.html" class="btn btn-outline-light btn-sm me-2">
                                    <i class="fas fa-info-circle me-1"></i> Details
                                </a>
                                <a href="#" class="btn btn-secondary-custom btn-sm">
                                    <i class="fas fa-images me-1"></i> Gallery
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Project 4 - Trade Mall -->
                <div class="col-lg-4 col-md-6 project-item" data-category="completed building">
                    <div class="project-card">
                        <div class="project-image">
                            <img src="https://images.unsplash.com/photo-1600585154340-be6161a56a0c?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80"
                                alt="Trade Mall" class="img-fluid">
                        </div>
                        <div class="project-overlay">
                            <div class="project-badge completed">Completed</div>
                            <div class="project-content">
                                <h5>Aadhar Trade Mall, Balkhu</h5>
                                <div class="project-meta">
                                    <span><i class="fas fa-map-marker-alt"></i> Kathmandu</span>
                                    <span><i class="fas fa-rupee-sign"></i> 2,500,000,000.00 NPR</span>
                                </div>
                                <p class="project-desc">Commercial complex construction in Balkhu</p>
                            </div>
                            <div class="project-hover-content">
                                <a href="/project_detail.html" class="btn btn-outline-light btn-sm me-2">
                                    <i class="fas fa-info-circle me-1"></i> Details
                                </a>
                                <a href="#" class="btn btn-secondary-custom btn-sm">
                                    <i class="fas fa-images me-1"></i> Gallery
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Project 5 - Hospital -->
                <div class="col-lg-4 col-md-6 project-item" data-category="completed building">
                    <div class="project-card">
                        <div class="project-image">
                            <img src="/images/services.jpg" alt="Hospital Project" class="img-fluid">
                        </div>
                        <div class="project-overlay">
                            <div class="project-badge completed">Completed</div>
                            <div class="project-content">
                                <h5>District Hospital Baitadi</h5>
                                <div class="project-meta">
                                    <span><i class="fas fa-map-marker-alt"></i> Baitadi</span>
                                    <span><i class="fas fa-rupee-sign"></i> 226,969,239.00 NPR</span>
                                </div>
                                <p class="project-desc">50-bed hospital construction in Baitadi</p>
                            </div>
                            <div class="project-hover-content">
                                <a href="/project_detail.html" class="btn btn-outline-light btn-sm me-2">
                                    <i class="fas fa-info-circle me-1"></i> Details
                                </a>
                                <a href="#" class="btn btn-secondary-custom btn-sm">
                                    <i class="fas fa-images me-1"></i> Gallery
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Project 6 - Bridge -->
                <div class="col-lg-4 col-md-6 project-item" data-category="completed road">
                    <div class="project-card">
                        <div class="project-image">
                            <img src="https://images.unsplash.com/photo-1605000797499-95a51c5269ae?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1471&q=80"
                                alt="Bridge Project" class="img-fluid">
                        </div>
                        <div class="project-overlay">
                            <div class="project-badge completed">Completed</div>
                            <div class="project-content">
                                <h5>Steel Truss Bridge Over Seti River</h5>
                                <div class="project-meta">
                                    <span><i class="fas fa-map-marker-alt"></i> Rayal</span>
                                    <span><i class="fas fa-calendar-check"></i> Completed 2023</span>
                                </div>
                                <p class="project-desc">60-meter steel bridge construction</p>
                            </div>
                            <div class="project-hover-content">
                                <a href="/project_detail.html" class="btn btn-outline-light btn-sm me-2">
                                    <i class="fas fa-info-circle me-1"></i> Details
                                </a>
                                <a href="#" class="btn btn-secondary-custom btn-sm">
                                    <i class="fas fa-images me-1"></i> Gallery
                                </a>
                            </div>
                        </div>
                    </div>
                </div> --}}

            </div>

            <!-- View All Button -->
            <div class="row mt-5">
                <div class="col-12 text-center animate-on-scroll">
                    <a href="#" class="btn btn-primary-custom btn-lg px-5 py-3 position-relative overflow-hidden">
                        <span class="btn-text">View All Projects</span>
                        <span class="btn-hover-effect"></span>
                        <i class="fas fa-arrow-right ms-2"></i>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <script>
document.addEventListener("DOMContentLoaded", function () {
    const filterButtons = document.querySelectorAll(".project-filters .nav-link");
    const projects = document.querySelectorAll(".project-item");

    filterButtons.forEach(button => {
        button.addEventListener("click", function () {
            // 1️⃣ Active class update
            filterButtons.forEach(btn => btn.classList.remove("active"));
            this.classList.add("active");

            // 2️⃣ Filter key
            const target = this.id.replace("-tab", ""); // ongoing, completed, hydropower, road, building, all

            // 3️⃣ Show / hide projects
            projects.forEach(project => {
                const categories = project.getAttribute("data-category").split(" ");
                if (target === "all" || categories.includes(target)) {
                    project.style.display = "block"; // show
                } else {
                    project.style.display = "none"; // hide
                }
            });
        });
    });
});
</script>

@endsection
