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
            <h1 class="py-5 mt-5">Our Project Images</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb justify-content-center mb-0">
                    <li class="breadcrumb-item"><a href="/"><i class="bi bi-house-door-fill"></i> Home</a></li>
                    <!-- <li class="breadcrumb-item"><a href="#"><i class="bi bi-gear-fill"></i> Services</a></li> -->
                    <li class="breadcrumb-item active" aria-current="page"><i class="bi bi-code-slash"></i>Our Project
                        Images</li>
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
                        <span class="section-title-bg">Our Projects Images</span>
                        <span class="section-title-text">Our Projects Images</span>
                    </h2>
                    <div class="section-divider mx-auto mt-3"></div>
                    <p class="lead mt-4">Transforming visions into reality through engineering excellence</p>
                </div>
            </div>

            <!-- Projects Grid -->
            <div class="row g-4">
                @forelse($images->images as $image)
                    <div class="col-lg-4 col-md-6" data-category="ongoing hydropower">
                        <div class="project-card position-relative overflow-hidden">
                            <a href="{{ asset('upload/sites/' . $image->image) }}" class="glightbox"
                                data-gallery="gallery1">
                                <img src="{{ asset('upload/sites/' . $image->image) }}" alt="Hydropower Project"
                                    class="img-fluid rounded shadow">

                                <!-- Hover Icon -->
                                <div class="hover-icon position-absolute top-50 start-50 translate-middle">
                                    <i class="fa-solid fa-plus fa-2x text-white"></i>
                                </div>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>


        </div>
    </section>
@endsection
