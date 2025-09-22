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


    <section class="breadcrumb-hero">
        <div class="container breadcrumb-content">
            <h1 class="py-5 mt-5">Contact Us</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb justify-content-center mb-0">
                    <li class="breadcrumb-item"><a href="/"><i class="bi bi-house-door-fill"></i> Home</a></li>
                    <!-- <li class="breadcrumb-item"><a href="#"><i class="bi bi-gear-fill"></i> About Us</a></li> -->
                    <li class="breadcrumb-item active" aria-current="page"><i class="bi bi-code-slash"></i>Contact Us</li>
                </ol>
            </nav>
        </div>
    </section>

    <!-- contact section start  -->
    <!-- === CONTACT SECTION === -->

    <!-- === CONTACT SECTION === -->


    <section class="multi-branch-contact">
        <div class="container py-5">
            <!-- Section Header -->
            <div class="text-center mb-5">
                <h1 class="display-4 fw-bold section-title-text text-primary-custom">Reach Out To Us</h1>
                <div class="divider-line mx-auto my-3"></div>
                <p class="lead text-muted">We're here to help and answer any questions you might have. Contact any of our
                    branches below.</p>
            </div>

            <!-- Branch Tabs Navigation -->
            <!-- Branch Tabs -->
            <ul class="nav nav-pills mb-4 justify-content-center" id="branch-tabs" role="tablist">
                @foreach ($branches as $key => $branch)
                    <li class="nav-item" role="presentation">
                        <button class="nav-link @if ($key == 0) active @endif"
                            id="branch{{ $branch->id }}-tab" data-bs-toggle="pill"
                            data-bs-target="#branch{{ $branch->id }}" type="button" role="tab"
                            aria-controls="branch{{ $branch->id }}" aria-selected="{{ $key == 0 ? 'true' : 'false' }}">
                            {{ $branch->name ?? 'N/A' }}
                        </button>
                    </li>
                @endforeach
            </ul>

            <!-- Branch Content -->
            <div class="tab-content" id="branch-tabs-content">
                @foreach ($branches as $key => $branch)
                    <div class="tab-pane fade @if ($key == 0) show active @endif"
                        id="branch{{ $branch->id }}" role="tabpanel" aria-labelledby="branch{{ $branch->id }}-tab">
                        <div class="row g-4">
                            <!-- Branch Info -->
                            <div class="col-lg-6">
                                <div class="branch-card p-4 h-100">
                                    <h3 class="fw-bold mb-4"><i
                                            class="fas fa-building me-2"></i>{{ $branch->name ?? 'N/A' }}</h3>
                                    <div class="branch-info mb-4">
                                        <div class="info-item d-flex mb-3">
                                            <div class="icon-circle bg-primary me-3">
                                                <i class="fas fa-map-marker-alt text-white"></i>
                                            </div>
                                            <div>
                                                <h5 class="fw-bold mb-1">Address</h5>
                                                <p class="mb-0">{{ $branch->address ?? 'N/A' }}</p>
                                            </div>
                                        </div>
                                        <div class="info-item d-flex mb-3">
                                            <div class="icon-circle bg-primary me-3">
                                                <i class="fas fa-phone text-white"></i>
                                            </div>
                                            <div>
                                                <h5 class="fw-bold mb-1">Phone</h5>
                                                <p class="mb-0">
                                                    {{ $branch->phone ?? 'N/A' }}
                                                </p>
                                                <p class="mb-0">
                                                    {{ $branch->phone2 ?? 'N/A' }}
                                                </p>
                                            </div>
                                        </div>
                                        <div class="info-item d-flex mb-3">
                                            <div class="icon-circle bg-primary me-3">
                                                <i class="fas fa-envelope text-white"></i>
                                            </div>
                                            <div>
                                                <h5 class="fw-bold mb-1">Email</h5>
                                                <p class="mb-0">{{ $branch->email ?? 'N/A' }}</p>
                                                <p class="mb-0">{{ $branch->email2 ?? 'N/A' }}</p>
                                            </div>
                                        </div>
                                        <div class="info-item d-flex">
                                            <div class="icon-circle bg-primary me-3">
                                                <i class="fas fa-clock text-white"></i>
                                            </div>
                                            <div>
                                                <h5 class="fw-bold mb-1">Opening Hours</h5>
                                                <p class="mb-0">{!! $branch->opening_hours ?? 'N/A' !!}</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="branch-features">
                                        <h5 class="fw-bold mb-3">Facilities</h5>
                                        <div class="d-flex flex-wrap gap-2">
                                            <span class="badge bg-light text-dark">{!! $branch->facilities ?? 'N/A' !!}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Contact Form -->
                            <div class="col-lg-6">
                                <div class="contact-form-wrapper p-4 h-100">
                                    <h4 class="fw-bold mb-4 text-center text-contact">Send a Message</h4>
                                    <form action="{{ route('messages.store') }}" method="POST" novalidate>
                                        @csrf
                                        <input type="hidden" name="branch_id" value="{{ $branch->id }}">
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label for="name-{{ $branch->id }}" class="form-label">Your
                                                    Name</label>
                                                <input type="text" class="form-control" id="name-{{ $branch->id }}"
                                                    name="name" required>
                                                <div class="invalid-feedback">Please enter your name.</div>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label for="email-{{ $branch->id }}" class="form-label">Your
                                                    Email</label>
                                                <input type="email" class="form-control"
                                                    id="email-{{ $branch->id }}" name="email" required>
                                                <div class="invalid-feedback">Please enter a valid email address.</div>
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label for="subject-{{ $branch->id }}" class="form-label">Subject</label>
                                            <input type="text" class="form-control" id="subject-{{ $branch->id }}"
                                                name="subject" required>
                                            <div class="invalid-feedback">Please enter a subject.</div>
                                        </div>
                                        <div class="mb-4">
                                            <label for="message-{{ $branch->id }}" class="form-label">Message</label>
                                            <textarea class="form-control" id="message-{{ $branch->id }}" name="message" rows="5" required></textarea>
                                            <div class="invalid-feedback">Please enter your message.</div>
                                        </div>
                                        <div class="text-center">
                                            <button type="submit" class="btn btn-primary-gradient btn-lg px-4">
                                                <i class="fas fa-paper-plane me-2"></i>Send Message
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <!-- Google Map -->
                        <div class="mt-4">
                            <div class="map-container rounded-3 overflow-hidden shadow-sm">
                                @if ($branch->map)
                                    {!! $branch->map !!}
                                @else
                                    <p class="text-center">Map not available</p>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>


        </div>
    </section>
@endsection
