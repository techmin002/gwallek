@extends('frontend.layouts.master')
@section('title', 'Gwallek Nirman Sewa')
@section('content')
    <section class="breadcrumb-hero">
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
    </section>

    <!-- About Section -->
    <section id="about" class="py-5 position-relative overflow-hidden">
        <!-- Decorative elements -->
        <div class="position-absolute top-0 start-0 w-100 h-100" style="z-index: -1;">
            <div class="about-bg-pattern"></div>
        </div>

        <div class="container">
            <!-- Section Header -->
            <div class="row justify-content-center">
                <div class="col-lg-8 text-center mb-5">
                    <h2 class="display-4 fw-bold text-primary-custom position-relative d-inline-block">
                        <span class="section-title-bg">About Us</span>
                        <span class="section-title-text">About Us</span>
                    </h2>
                    <div class="section-divider mx-auto mt-3"></div>
                </div>
            </div>

            <!-- Mission Section -->
            <div class="row mb-5 align-items-center g-5">
                <div class="col-lg-6 order-lg-1 order-2 animate-on-scroll" data-animation="fadeInLeft">
                    <div class="mission-card p-4 p-md-5 rounded-4 shadow">
                        <h3 class="text-primary-custom mb-4 position-relative">
                            <span class="title-decoration"></span>
                            Our Mission
                        </h3>
                        <div class="mission-content">
                            <p class="lead">{!! $profile->mission !!}</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 order-lg-2 order-1 animate-on-scroll" data-animation="fadeInRight">
                    <div class="about-image-container rounded-4 overflow-hidden shadow-lg">
                        <img src="/frontend/images/about.avif" class="img-fluid about-image" alt="Our Team at Work">
                        <div class="image-overlay"></div>
                        <div class="image-badge">
                            <span class="badge-years">25+</span>
                            <span class="badge-text">Years of Excellence</span>
                        </div>
                    </div>
                </div>
            </div>

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
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form id="gnsQuoteForm" action="{{ route('inquiry.store') }}" method="POST">
                                        @csrf
                                        <div class="mb-3">
                                            <input type="text" name="name" class="form-control"
                                                placeholder="Your Name" required>
                                        </div>
                                        <div class="mb-3">
                                            <input type="email" name="email" class="form-control" placeholder="Email"
                                                required>
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

            <!-- SC Timeline Section -->
            <section class="sc-timeline-section sc-py-5 position-relative overflow-hidden">
                <!-- Decorative Elements -->
                <div class="sc-timeline-decoration">
                    <div class="sc-timeline-circle sc-circle-1"></div>
                    <div class="sc-timeline-circle sc-circle-2"></div>
                    <div class="sc-timeline-wave"></div>
                </div>

                <div class="container">
                    <div class="row justify-content-center sc-mb-6">
                        <div class="col-lg-8 text-center">
                            <div class="sc-timeline-header">
                                <h2 class="sc-timeline-main-title">
                                    <span class="sc-title-bg">Our Journey</span>
                                    <span class="sc-title-front position-relative">Our Journey</span>
                                </h2>
                                <p class="sc-timeline-subtitle mt-3">Milestones that define our path to excellence</p>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <div class="sc-timeline-v3">
                                <!-- Timeline Progress Bar -->
                                <div class="sc-timeline-track">
                                    <div class="sc-timeline-progress"></div>
                                </div>

                                <!-- Timeline Items -->
                                <div class="sc-timeline-items row g-4">
                                    <!-- Item 1 -->
                                    <div class="sc-timeline-item col-md-6 sc-animate-on-scroll"
                                        data-sc-animation="fadeInUp">
                                        <div class="sc-timeline-card">
                                            <div class="sc-timeline-card-inner">
                                                <div class="sc-timeline-year">1999</div>
                                                <div class="sc-timeline-content">
                                                    <h3 class="sc-timeline-title">Company Founded</h3>
                                                    <p class="sc-timeline-desc">Established as a 'D' Class Contractor by
                                                        Mr. Suresh Chand</p>
                                                    <div class="sc-timeline-icon">
                                                        <i class="fas fa-building"></i>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="sc-timeline-connector"></div>
                                            <div class="sc-timeline-marker">
                                                <div class="sc-marker-dot"></div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Item 2 -->
                                    <div class="sc-timeline-item col-md-6 sc-animate-on-scroll"
                                        data-sc-animation="fadeInUp" data-sc-delay="0.2">
                                        <div class="sc-timeline-card sc-card-right">
                                            <div class="sc-timeline-card-inner">
                                                <div class="sc-timeline-year">2014</div>
                                                <div class="sc-timeline-content">
                                                    <h3 class="sc-timeline-title">Private Limited</h3>
                                                    <p class="sc-timeline-desc">Converted into Private Limited Company</p>
                                                    <div class="sc-timeline-icon">
                                                        <i class="fas fa-chart-line"></i>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="sc-timeline-connector"></div>
                                            <div class="sc-timeline-marker">
                                                <div class="sc-marker-dot"></div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Item 3 -->
                                    <div class="sc-timeline-item col-md-6 sc-animate-on-scroll"
                                        data-sc-animation="fadeInUp" data-sc-delay="0.4">
                                        <div class="sc-timeline-card">
                                            <div class="sc-timeline-card-inner">
                                                <div class="sc-timeline-year">2016</div>
                                                <div class="sc-timeline-content">
                                                    <h3 class="sc-timeline-title">Class A Achievement</h3>
                                                    <p class="sc-timeline-desc">Upgraded to 'A' Class Construction Company
                                                    </p>
                                                    <div class="sc-timeline-icon">
                                                        <i class="fas fa-trophy"></i>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="sc-timeline-connector"></div>
                                            <div class="sc-timeline-marker">
                                                <div class="sc-marker-dot"></div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Item 4 -->
                                    <div class="sc-timeline-item col-md-6 sc-animate-on-scroll"
                                        data-sc-animation="fadeInUp" data-sc-delay="0.6">
                                        <div class="sc-timeline-card sc-card-right">
                                            <div class="sc-timeline-card-inner">
                                                <div class="sc-timeline-year">2020</div>
                                                <div class="sc-timeline-content">
                                                    <h3 class="sc-timeline-title">Project Milestone</h3>
                                                    <p class="sc-timeline-desc">Completed over 50 major infrastructure
                                                        projects</p>
                                                    <div class="sc-timeline-icon">
                                                        <i class="fas fa-hard-hat"></i>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="sc-timeline-connector"></div>
                                            <div class="sc-timeline-marker">
                                                <div class="sc-marker-dot"></div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Item 5 -->
                                    <div class="sc-timeline-item col-md-6 sc-animate-on-scroll"
                                        data-sc-animation="fadeInUp" data-sc-delay="0.8">
                                        <div class="sc-timeline-card">
                                            <div class="sc-timeline-card-inner">
                                                <div class="sc-timeline-year">2025</div>
                                                <div class="sc-timeline-content">
                                                    <h3 class="sc-timeline-title">Industry Leader</h3>
                                                    <p class="sc-timeline-desc">One of Nepal's leading construction
                                                        companies with 200+ employees</p>
                                                    <div class="sc-timeline-icon">
                                                        <i class="fas fa-users"></i>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="sc-timeline-connector"></div>
                                            <div class="sc-timeline-marker">
                                                <div class="sc-marker-dot"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Director's Message -->
            <div class="row mt-5 g-5 align-items-center">
                <div class="col-lg-6 animate-on-scroll" data-animation="fadeInLeft">
                    <div class="director-image-container rounded-4 overflow-hidden shadow-lg">
                        <img src="{{ asset('upload/images/message_from/' . $messages1->image) }}"
                            class="img-fluid director-image" alt="Managing Director">
                        <div class="director-overlay"></div>
                        <div class="director-badge">
                            <span class="director-title">{{ $messages1->role }}</span>
                            <span class="director-name">{{ $messages1->name }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 animate-on-scroll" data-animation="fadeInRight">
                    <div class="director-message p-4 p-md-5 rounded-4 shadow">
                        <h3 class="text-primary-custom mb-4 position-relative">
                            <span class="title-decoration"></span>
                            Message from Leadership
                        </h3>
                        <blockquote class="message-quote">
                            <p class="quote-text">
                                <span class="quote-start"><i class="fas fa-quote-left"></i></span>
                                {!! $messages1->description !!}
                                <span class="quote-end"><i class="fas fa-quote-right"></i></span>
                            </p>
                        </blockquote>

                        <div class="director-info mt-4">
                            <h5 class="mb-0">{{ $messages1->name }}</h5>
                            <p class="text-secondary-custom mb-0">{{ $messages1->role }}</p>
                            <div class="signature mt-3">
                                <img src="{{ asset('upload/images/message_from/' . $messages1->signature) }}"
                                    alt="Signature" class="img-fluid" style="height: 40px;">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Message from Executive Director -->
            <div class="row mt-5 g-5 align-items-center">
                <div class="col-lg-6 order-lg-2 animate-on-scroll" data-animation="fadeInRight">
                    <div class="director-image-container rounded-4 overflow-hidden shadow-lg">
                        <img src="{{ asset('upload/images/message_from/' . $messages2->image) }}"
                            class="img-fluid director-image" alt="Executive Director">
                        <div class="director-overlay"></div>
                        <div class="director-badge">
                            <span class="director-title">{{ $messages2->role }}</span>
                            <span class="director-name">{{ $messages2->name }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 order-lg-1 animate-on-scroll" data-animation="fadeInLeft">
                    <div class="director-message p-4 p-md-5 rounded-4 shadow" style="background-color: #f8f9fa;">
                        <h3 class="text-primary-custom mb-4 position-relative">
                            <span class="title-decoration" style="background-color: #6c757d;"></span>
                            Message from Executive Director
                        </h3>
                        <blockquote class="message-quote director-quote">
                            <div class="">

                            </div>

                            <p>{!! $messages2->description !!}</p>

                            <div class="">
                                <i></i>
                            </div>
                        </blockquote>

                        <div class="director-info mt-4">
                            <h5 class="mb-0">{{ $messages2->name }}</h5>
                            <p class="text-secondary-custom mb-0">{{ $messages2->role }}</p>
                            <div class="signature mt-3">
                                <img src="{{ asset('upload/images/message_from/' . $messages2->signature) }}"
                                    alt="Signature" class="img-fluid" style="height: 40px;">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Team Section -->
    <section id="team" class="py-5 bg-light">
        <div class="container">
            <div class="row">
                <div class="col-12 text-center mb-5">
                    <h2 class="section-title-text display-4 fw-bold text-primary-custom">Our Team</h2>

                    <div class="section-divider mx-auto mt-3"></div>
                </div>
            </div>

            <!-- Auto-scrolling Team Members Container -->
            <div class="position-relative">
                <div class="team-scroller row g-4 flex-nowrap overflow-hidden py-3" id="teamScroller">
                    <!-- Team Member 1 -->
                    @foreach ($teams as $team)
                        <div class="col-md-4 animate-on-scroll" style="min-width: 300px; scroll-snap-align: start;">
                            <div class="team-card card h-100">
                                <img src="{{ asset('upload/images/teams/' . $team->image) }}"
                                    class="card-img-top team-img" alt="Managing Director">
                                <div class="card-body text-center">
                                    <h5 class="card-title text-primary-custom">{{ $team->name }}</h5>
                                    <p class="card-text text-secondary-custom">{{ $team->designation }}</p>
                                    <div class="social-icons">
                                        <a href="{{ $team->facebook }}" target="_blank"><i
                                                class="fab fa-facebook-f"></i></a>
                                        <a href="{{ $team->twitter }}" target="_blank"><i
                                                class="fab fa-twitter"></i></a>
                                        <a href="{{ $team->linkedin }}" target="_blank"><i
                                                class="fab fa-linkedin-in"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Navigation Arrows (optional) -->
                <button
                    class="team-scroll-btn position-absolute start-0 top-50 translate-middle-y btn btn-light rounded-circle shadow"
                    onclick="scrollTeam(-1)">
                    <i class="fas fa-chevron-left"></i>
                </button>
                <button
                    class="team-scroll-btn position-absolute end-0 top-50 translate-middle-y btn btn-light rounded-circle shadow"
                    onclick="scrollTeam(1)">
                    <i class="fas fa-chevron-right"></i>
                </button>
            </div>

            <!-- Advisors Section -->
            <section class="advisors-section py-5 position-relative">
                <!-- Decorative Elements -->
                <div class="advisor-shape shape-1"></div>
                <div class="advisor-shape shape-2"></div>

                <div class="container position-relative z-index-2">
                    <div class="row justify-content-center">
                        <div class="col-lg-8 text-center mb-5">
                            <h2 class="advisor-section-title">
                                <span class="section-title-bg">Our Advisors</span>
                                <span class="section-title-text display-4 fw-bold text-primary-custom">Our Advisors</span>
                                <div class="section-divider mx-auto mt-3"></div>
                            </h2>
                            <p class="advisor-section-subtitle">Expert guidance for strategic success</p>
                        </div>
                    </div>

                    <div class="row g-4 justify-content-center">
                        @foreach ($advisors as $advisor)
                            {{-- <div class="col-lg-6 animate-on-scroll" data-animation="fadeInUp" data-delay="0.2">
                                <div class="advisor-card">
                                    <div class="advisor-card-inner">
                                        <div class="advisor-icon-container">
                                            <div class="advisor-icon-bg"></div>
                                            <i class="fas fa-chart-line advisor-icon"></i>
                                        </div>
                                        <div class="advisor-content">
                                            <h3 class="advisor-name">Bahadur Singh Bista</h3>
                                            <p class="advisor-title">Financial Advisor</p>
                                            <div class="advisor-details">
                                                <p>Expert in construction project financing with specialization in
                                                    infrastructure investments.</p>
                                                <div class="advisor-stats">
                                                    <span class="stat-item"><i class="fas fa-graduation-cap me-2"></i>MBA,
                                                        Stanford</span>
                                                    <span class="stat-item"><i class="fas fa-briefcase me-2"></i>18 Years
                                                        Experience</span>
                                                    <span class="stat-item"><i class="fas fa-project-diagram me-2"></i>75+
                                                        Projects</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="advisor-hover-content">
                                            <div class="social-links">
                                                <a href="#" class="social-link"><i
                                                        class="fab fa-linkedin-in"></i></a>
                                                <a href="#" class="social-link"><i class="fas fa-envelope"></i></a>
                                                <a href="#" class="social-link"><i class="fas fa-file-alt"></i></a>
                                            </div>
                                            <div class="advisor-quote">
                                                <i class="fas fa-quote-left quote-icon"></i>
                                                <p>Strategic financial planning turns construction visions into viable
                                                    projects.</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="advisor-card-border"></div>
                                </div>
                            </div> --}}
                            <div class="col-lg-6 animate-on-scroll" data-animation="fadeInUp" data-delay="0.2">
                                <div class="advisor-card">
                                    <div class="advisor-card-inner">
                                        <div class="advisor-icon-container">
                                            <div class="advisor-icon-bg"></div>
                                            <div class="advisor-icon">
                                                <img src="{{ asset('upload/images/advisor/' . $advisor->image) }}"
                                                    class=" w-100" alt="">
                                            </div>
                                        </div>
                                        <div class="advisor-content">
                                            <h3 class="advisor-name">{{ $advisor->name }}</h3>
                                            <p class="advisor-title">{{ $advisor->type }}</p>
                                            <div class="advisor-details">
                                                <p>{!! $advisor->description !!}</p>
                                                <div class="advisor-stats">
                                                    @if ($advisor->designation)
                                                        <span class="stat-item"><i
                                                                class="fas fa-graduation-cap me-2"></i>{{ $advisor->designation }}</span>
                                                    @endif
                                                    @if ($advisor->experience)
                                                        <span class="stat-item"><i
                                                                class="fas fa-briefcase me-2"></i>{{ $advisor->experience }}</span>
                                                    @endif
                                                    @if ($advisor->projects)
                                                        <span class="stat-item"><i
                                                                class="fas fa-project-diagram me-2"></i>{{ $advisor->projects }}</span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <div class="advisor-hover-content">
                                            <div class="social-links">
                                                @if ($advisor->linkedin)
                                                    <a href="{{ $advisor->linkedin }}" class="social-link"
                                                        target="_blank">
                                                        <i class="fab fa-linkedin-in"></i>
                                                    </a>
                                                @endif

                                                @if ($advisor->mail)
                                                    <a href="mailto:{{ $advisor->mail }}" class="social-link">
                                                        <i class="fas fa-envelope"></i>
                                                    </a>
                                                @endif

                                                @if ($advisor->facebook)
                                                    <a href="{{ $advisor->facebook }}" class="social-link"
                                                        target="_blank">
                                                        <i class="fab fa-facebook-f"></i>
                                                    </a>
                                                @endif

                                            </div>
                                            <div class="advisor-quote"> <i class="fas fa-quote-left quote-icon"></i>
                                                <p>{!! $advisor->quote !!}</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="advisor-card-border"></div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    {{-- </div> --}}
                </div>
            </section>
        </div>
    </section>

    <!-- Clients Section -->
    <section id="clients" class="py-5 position-relative">
        <!-- Decorative Elements -->
        <div class="client-shape shape-1"></div>
        <div class="client-shape shape-2"></div>

        <div class="container position-relative z-index-2">
            <div class="row">
                <div class="col-12 text-center mb-5">
                    <h2 class="section-title">
                        <span class="section-title-bg">Our Clients</span>
                        <span class="section-title-text display-4 fw-bold text-primary-custom">Our Clients</span>
                    </h2>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="client-scroller-container">
                        <div class="client-scroller-track" id="clientScroller">
                            <!-- Client Logo Group (repeated for seamless looping) -->
                            <div class="client-logo-group">
                                @foreach ($clients as $client)
                                    <div class="client-logo-item">
                                        <img src="{{ asset('upload/images/clients/' . $client->image) }}"
                                            alt="Government of Nepal" class="img-fluid client-logo">
                                    </div>
                                @endforeach
                                {{-- <div class="client-logo-item">
                                    <img src="/frontend/images/manager.jpg" alt="Asian Development Bank"
                                        class="img-fluid client-logo">
                                </div>
                                <div class="client-logo-item">
                                    <img src="/frontend/images/manager.jpg" alt="Ministry of Federal Affairs"
                                        class="img-fluid client-logo">
                                </div>
                                <div class="client-logo-item">
                                    <img src="/frontend/images/manager.jpg" alt="Api Power Company"
                                        class="img-fluid client-logo">
                                </div>
                                <div class="client-logo-item">
                                    <img src="/frontend/images/manager.jpg" alt="World Bank"
                                        class="img-fluid client-logo">
                                </div>
                                <div class="client-logo-item">
                                    <img src="/frontend/images/manager.jpg" alt="UNDP" class="img-fluid client-logo">
                                </div> --}}
                            </div>
                            <!-- Duplicate for seamless looping -->
                            {{-- <div class="client-logo-group">
                                @foreach ($teams as $team)
                                    <div class="client-logo-item">
                                        <img src="{{ asset('upload/images/teams/' . $team->image) }}"
                                            alt="Government of Nepal" class="img-fluid client-logo">
                                    </div>
                                @endforeach
                            </div> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
