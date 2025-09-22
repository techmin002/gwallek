@extends('frontend.layouts.master')
@section('title', 'Gwallek Nirman Sewa')
@section('content')
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

    {{-- <section class="breadcrumb-hero">
        <div class="container breadcrumb-content">
            <h1 class="py-5 mt-5">About Us</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb justify-content-center mb-0">
                    <li class="breadcrumb-item"><a href="/"><i class="bi bi-house-door-fill"></i> Home</a></li>
                    <!-- <li class="breadcrumb-item"><a href="#"><i class="bi bi-gear-fill"></i> About Us</a></li> -->
                    <li class="breadcrumb-item active" aria-current="page"><i class="bi bi-code-slash"></i>About Us</li>
                </ol>
            </nav>
        </div>
    </section> --}}

    <!-- details service start  -->

    <!-- Hero Section -->
    <section class="gws-hero">
        <div class="container">
            <h1>{!! $type->name !!}</h1>
            <p>{!! $type->title !!}</p>
        </div>
        <div class="gws-scroll-indicator">⬇</div>
    </section>

    <!-- Overview -->
    <section id="overview" class="gws-section">
        <div class="container gws-fade">
            <div class="row align-items-center g-5">
                <div class="col-lg-6">
                    <div class="gws-glass">
                        <h2>Overview</h2>
                        <p>{!! $type->overview !!}</p>
                        <div class="gws-highlight">"Our goal is to power communities while preserving the natural beauty of
                            Nepal’s landscapes."</div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <img src="{{ asset('upload/images/servicestype/' . $type->image) }}" class="img-fluid gws-img"
                        alt="Hydropower">
                </div>
            </div>
        </div>
    </section>

    <!-- Our Work -->
    <section class="gws-section bg-light gws-wave">
        <div class="container gws-fade">
            <h2>Our Work in Hydropower</h2>
            <div class="gws-glass">
                {!! $type->description !!}</p>
            </div>
        </div>
    </section>

    <!-- Past Projects -->
    <section class="gws-section">
        <div class="container gws-fade">
            <h2>Past Projects</h2>
            <div class="row g-4">
                @forelse($pastProjects as $project)
                    <div class="col-md-4">
                        <div class="gws-glass">
                            <img src="{{ asset('upload/sites/' . $project->image) }}" class="img-fluid gws-img">
                            <h5 class="mt-3">{{ $project->name }}</h5>
                            <p>Value: NPR {{ $project->amount }}
                                {!! $project->description !!}
                            </p>
                        </div>
                    </div>
                @empty
                    <p class="text-center text-danger">No past projects available.</p>
                @endforelse
                {{-- <div class="col-md-4">
                    <div class="gws-glass">
                        <img src="/frontend/images/hero2.jpg" class="img-fluid gws-img">
                        <h5 class="mt-3">Middle Chameliya (28.304 MW)</h5>
                        <p>Major civil works and powerhouse construction.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="gws-glass">
                        <img src="/frontend/images/hero3.jpg" class="img-fluid gws-img">
                        <h5 class="mt-3">Rural Micro-Hydro</h5>
                        <p>Empowering rural communities with renewable energy.</p>
                    </div>
                </div> --}}
            </div>
        </div>
    </section>

    <!-- Benefits -->
    <section class="gws-section bg-light gws-wave">
        <div class="container gws-fade">
            <h2>Benefits</h2>
            <div class="gws-glass">
                <ul>
                    {!! $type->benifits !!}
                </ul>
            </div>
        </div>
    </section>

    <!-- CTA -->
    <section class="gws-section">
        <div class="container text-center gws-cta gws-fade">
            <h2 class="text-white">Work With Us</h2>
            <p>Interested in developing a hydropower project with us? Let’s collaborate to power Nepal’s future.</p>
            <a href="{{ route('frontend.contact') }}" class="btn">Contact Us</a>
        </div>
    </section>
@endsection
