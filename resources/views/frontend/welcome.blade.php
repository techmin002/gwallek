@php
    $sites = Modules\ProjectManager\Models\Site::all();
    $sliders = Modules\Slider\Entities\Slider::all();
@endphp
@extends('frontend.layouts.master')
@section('title', 'Gwallek Nirman Sewa')
@section('content')
    <!-- Hero Carousel Section -->
    <section id="home" class="hero-carousel">
        <!-- Carousel Indicators -->
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="0" class="active"></button>
            <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="1"></button>
            <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="2"></button>
        </div>

        <!-- Carousel Items -->
        <div id="heroCarousel" class="carousel slide carousel-fade" data-bs-ride="carousel">
            <div class="carousel-inner">

                @foreach ($sliders as $value)
                    <!-- Slide 2 - Hydropower Expertise -->
                    <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
                        <div class="carousel-overlay"></div>
                        <img src="{{ asset('upload/images/sliders/' . $value->image) }}" class="d-block w-100"
                            alt="Hydropower Project">
                        <div class="carousel-caption animate__animated animate__fadeInRight">
                            <h1 class="display-3 fw-bold mb-3">{{ $value->title }}</h1>
                            <p class="lead mb-4">{!! $value->short_description !!}</p>
                            <a href="#services" class="btn btn-primary-custom btn-lg">Explore Hydropower</a>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Carousel Controls -->
            <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>

        <!-- Scroll Down Indicator -->
        <div class="scroll-down animate__animated animate__bounce animate__infinite">
            <a href="#about"><i class="fas fa-chevron-down"></i></a>
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
                            {!! $profile->mission !!}
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 order-lg-2 order-1 animate-on-scroll" data-animation="fadeInRight">
                    <div class="about-image-container rounded-4 overflow-hidden shadow-lg">
                        <img src="frontend/images/about.avif" class="img-fluid about-image" alt="Our Team at Work">
                        <div class="image-overlay"></div>
                        <div class="image-badge">
                            <span class="badge-years">25+</span>
                            <span class="badge-text">Years of Excellence</span>
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
                                <h2 class="display-4 sc-timeline-main-title ">
                                    <span class="section-title-bg">Our Journey</span>
                                    <span
                                        class="section-title-text position-relative display-4 fw-bold text-primary-custom">Our
                                        Journey</span>
                                </h2>
                                <div class="section-divider mx-auto mt-2"></div>
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
                                                    <p class="sc-timeline-desc">Converted into Private Limited Company
                                                    </p>
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
                                                    <p class="sc-timeline-desc">Upgraded to 'A' Class Construction
                                                        Company</p>
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
                        <img src="{{ asset('upload/images/message_from/' . $messages->image) }}"
                            class="img-fluid director-image" alt="Managing Director">
                        <div class="director-overlay"></div>
                        <div class="director-badge">
                            <span class="director-title">{{ $messages->role }}</span>
                            <span class="director-name">{{ $messages->name }}</span>
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
                                {!! $messages->description !!}
                                <span class="quote-end"><i class="fas fa-quote-right"></i></span>
                            </p>
                        </blockquote>
                        <div class="director-info mt-4">
                            <h5 class="mb-0">{{ $messages->name }}</h5>
                            <p class="text-secondary-custom mb-0">{{ $messages->role }}</p>
                            <div class="signature mt-3">
                                <img src="{{ asset('upload/images/message_from/' . $messages->signature) }}"
                                    alt="Signature" class="img-fluid" style="height: 40px;">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Services Section -->
    <section id="services" class="py-5 position-relative overflow-hidden">
        <!-- Decorative elements -->
        <div class="position-absolute top-0 start-0 w-100 h-100" style="z-index: -1;">
            <div class="services-bg-pattern"></div>
        </div>

        <div class="container">
            <!-- Section Header -->
            <div class="row justify-content-center">
                <div class="col-lg-8 text-center mb-5">
                    <h2 class="display-4 fw-bold text-primary-custom position-relative d-inline-block">
                        <span class="section-title-bg">Our Services</span>
                        <span class="section-title-text">Our Services</span>
                    </h2>
                    <div class="section-divider mx-auto mt-3"></div>
                    <p class="lead mt-4">Comprehensive infrastructure solutions that build Nepal's future</p>
                </div>
            </div>

            <!-- 6:6 Content-Image Introduction -->
            <div class="row align-items-center mb-5 g-5">
                <div class="col-lg-6 animate-on-scroll" data-animation="fadeInLeft">
                    <div class="pe-lg-5">
                        <h3 class="text-primary-custom mb-4">Transforming Nepal's Infrastructure Landscape</h3>
                        <p class="lead">With over two decades of experience, Gwallek Nirman Sewa delivers excellence
                            across all sectors of civil engineering and construction.</p>

                        <div class="service-features mt-4">
                            <div class="feature-item d-flex mb-3">
                                <div class="feature-icon me-3 text-secondary-custom">
                                    <i class="fas fa-check-circle fa-lg"></i>
                                </div>
                                <div class="feature-text">
                                    <h5 class="mb-1">End-to-End Solutions</h5>
                                    <p class="mb-0">From planning to execution, we handle every project phase</p>
                                </div>
                            </div>

                            <div class="feature-item d-flex mb-3">
                                <div class="feature-icon me-3 text-secondary-custom">
                                    <i class="fas fa-check-circle fa-lg"></i>
                                </div>
                                <div class="feature-text">
                                    <h5 class="mb-1">Quality Assurance</h5>
                                    <p class="mb-0">Rigorous quality control at every stage of construction</p>
                                </div>
                            </div>

                            <div class="feature-item d-flex">
                                <div class="feature-icon me-3 text-secondary-custom">
                                    <i class="fas fa-check-circle fa-lg"></i>
                                </div>
                                <div class="feature-text">
                                    <h5 class="mb-1">Innovative Technologies</h5>
                                    <p class="mb-0">Implementing cutting-edge construction techniques</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6 animate-on-scroll" data-animation="fadeInRight">
                    <div class="services-intro-image rounded-4 overflow-hidden shadow-lg">
                        <img src="frontend/images/services.jpg" alt="Our Services" class="img-fluid">
                        <div class="image-overlay"></div>
                        <div class="image-badge">
                            <span class="badge-text">200+ Projects Completed</span>
                        </div>
                    </div>
                </div>
            </div>


            <!-- Services Cards -->
            <div class="row g-4">
                @foreach ($services as $service)
                    <!-- Road & Bridge -->
                    <div class="col-lg-4 col-md-6 animate-on-scroll" data-animation="fadeInUp" data-delay="0.1s">
                        <div class="service-card card h-100 border-0">
                            <div class="card-body p-4 text-center">
                                <div class="service-icon">
                                    <div class="icon-wrapper">
                                        <div class="icon-inner">
                                            <img src="{{ asset('upload/images/services/' . $service->icon) }}"
                                                height="50px" class="rounded-circle" alt="Road & Bridge">
                                        </div>
                                    </div>
                                </div>
                                <h4 class="text-primary-custom mb-3">{!! $service->name ?? '-' !!}</h4>
                                <p class="mb-4">{!! $service->description ?? '-' !!}</p>
                                <div class="service-btn-wrapper">
                                    <a href="{{ route('frontend.service', $service->id) }}"
                                        class="btn btn-outline-primary-custom stretched-link">Learn
                                        More</a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Counter Section -->
    <section class="counter-section py-5 position-relative overflow-hidden">
        <!-- Animated Background Elements -->
        <div class="position-absolute top-0 start-0 w-100 h-100">
            <div class="counter-bg-pattern"></div>
            <div class="counter-dots"></div>
        </div>

        <div class="container position-relative">
            <div class="row g-4 justify-content-center">
                <!-- Years Experience -->
                <div class="col-lg-3 col-md-6 animate-on-scroll" data-animation="zoomIn">
                    <div class="counter-box text-center p-4">
                        <div class="counter-icon mb-3">
                            <div class="icon-wrapper">
                                <i class="fas fa-history"></i>
                            </div>
                        </div>
                        <div class="counter-stats">
                            <div class="counter" data-count="25">0</div>
                            <span class="counter-suffix">+</span>
                        </div>
                        <h5 class="counter-title mt-3">Years Experience</h5>
                        <div class="counter-border"></div>
                    </div>
                </div>

                <!-- Employees -->
                <div class="col-lg-3 col-md-6 animate-on-scroll" data-animation="zoomIn" data-delay="0.2s">
                    <div class="counter-box text-center p-4">
                        <div class="counter-icon mb-3">
                            <div class="icon-wrapper">
                                <i class="fas fa-users"></i>
                            </div>
                        </div>
                        <div class="counter-stats">
                            <div class="counter" data-count="197">0</div>
                            <span class="counter-suffix">+</span>
                        </div>
                        <h5 class="counter-title mt-3">Employees</h5>
                        <div class="counter-border"></div>
                    </div>
                </div>

                <!-- NPR Credit -->
                <div class="col-lg-3 col-md-6 animate-on-scroll" data-animation="zoomIn" data-delay="0.4s">
                    <div class="counter-box text-center p-4">
                        <div class="counter-icon mb-3">
                            <div class="icon-wrapper">
                                <i class="fas fa-rupee-sign"></i>
                            </div>
                        </div>
                        <div class="counter-stats">
                            <div class="counter" data-count="320">0</div>
                            <span class="counter-suffix">M</span>
                        </div>
                        <h5 class="counter-title mt-3">NPR Credit</h5>
                        <div class="counter-border"></div>
                    </div>
                </div>

                <!-- Projects Completed -->
                <div class="col-lg-3 col-md-6 animate-on-scroll" data-animation="zoomIn" data-delay="0.6s">
                    <div class="counter-box text-center p-4">
                        <div class="counter-icon mb-3">
                            <div class="icon-wrapper">
                                <i class="fas fa-project-diagram"></i>
                            </div>
                        </div>
                        <div class="counter-stats">
                            <div class="counter" data-count="100">0</div>
                            <span class="counter-suffix">+</span>
                        </div>
                        <h5 class="counter-title mt-3">Projects Completed</h5>
                        <div class="counter-border"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>

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
                                <button class="nav-link active" id="all-tab" data-bs-toggle="pill"
                                    data-bs-target="#all" type="button" role="tab" aria-controls="all"
                                    aria-selected="true">
                                    <i class="fas fa-layer-group me-2"></i>All Projects
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="ongoing-tab" data-bs-toggle="pill"
                                    data-bs-target="#ongoing" type="button" role="tab" aria-controls="ongoing"
                                    aria-selected="false">
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

            </div>

            <!-- View All Button -->
            <div class="row mt-5">
                <div class="col-12 text-center animate-on-scroll">
                    <a href="{{ route('frontend.project') }}"
                        class="btn btn-primary-custom btn-lg px-5 py-3 position-relative overflow-hidden">
                        <span class="btn-text">View All Projects</span>
                        <span class="btn-hover-effect"></span>
                        <i class="fas fa-arrow-right ms-2"></i>
                    </a>
                </div>
            </div>
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

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Equipment Section -->
    <section class="equipment-section py-5 position-relative overflow-hidden">
        <!-- Decorative Elements -->
        <div class="equipment-shape shape-1"></div>
        <div class="equipment-shape shape-2"></div>
        <div class="equipment-particle particle-1"></div>
        <div class="equipment-particle particle-2"></div>

        <div class="container position-relative z-index-2">
            <div class="row justify-content-center">
                <div class="col-lg-8 text-center mb-6">
                    <h2 class="equipment-section-title">
                        <span class="section-title-bg">Our Equipment</span>
                        <span class="section-title-text display-4 fw-bold text-primary-custom">Our Equipment & Plant</span>
                        <div class="section-divider mx-auto mt-3"></div>
                    </h2>
                    <p class="equipment-section-subtitle py-3">Modern machinery for exceptional construction quality</p>
                </div>
            </div>

            <div class="row g-4 justify-content-center">
                <!-- Equipment Card 1 -->
                <div class="col-lg-4 col-md-6 animate-on-scroll" data-animation="fadeInUp">
                    <div class="equipment-card">
                        <div class="equipment-icon-container">
                            <div class="icon-bg"></div>
                            <i class="fas fa-truck-pickup equipment-icon"></i>
                        </div>
                        <h3 class="equipment-title">Construction Equipment</h3>
                        <div class="equipment-stats">
                            <div class="stat-item">
                                <span class="stat-number" data-count="28">0</span>
                                <span class="stat-label">Excavators</span>
                            </div>
                            <div class="stat-item">
                                <span class="stat-number" data-count="5">0</span>
                                <span class="stat-label">Vibrating Rollers</span>
                            </div>
                            <div class="stat-item">
                                <span class="stat-number" data-count="10">0</span>
                                <span class="stat-label">Backhoe Loaders</span>
                            </div>
                            <div class="stat-item">
                                <span class="stat-number" data-count="16">0</span>
                                <span class="stat-label">Concrete Mixers</span>
                            </div>
                        </div>
                        <div class="equipment-details-toggle">
                            <button class="btn-details">View Full Inventory <i class="fas fa-chevron-down"></i></button>
                        </div>
                        <div class="equipment-details">
                            <ul class="equipment-list">
                                <li>Bulldozers: 8 units</li>
                                <li>Motor Graders: 6 units</li>
                                <li>Cranes: 4 units</li>
                                <li>Forklifts: 12 units</li>
                                <li>Compactors: 7 units</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Equipment Card 2 -->
                <div class="col-lg-4 col-md-6 animate-on-scroll" data-animation="fadeInUp" data-delay="0.2">
                    <div class="equipment-card">
                        <div class="equipment-icon-container">
                            <div class="icon-bg"></div>
                            <i class="fas fa-truck equipment-icon"></i>
                        </div>
                        <h3 class="equipment-title">Transportation Equipment</h3>
                        <div class="equipment-stats">
                            <div class="stat-item">
                                <span class="stat-number" data-count="7">0</span>
                                <span class="stat-label">Flat Bed Trucks</span>
                            </div>
                            <div class="stat-item">
                                <span class="stat-number" data-count="16">0</span>
                                <span class="stat-label">Tippers</span>
                            </div>
                            <div class="stat-item">
                                <span class="stat-number" data-count="4">0</span>
                                <span class="stat-label">Water Tankers</span>
                            </div>
                            <div class="stat-item">
                                <span class="stat-number" data-count="8">0</span>
                                <span class="stat-label">Tractors</span>
                            </div>
                        </div>
                        <div class="equipment-details-toggle">
                            <button class="btn-details">View Full Inventory <i class="fas fa-chevron-down"></i></button>
                        </div>
                        <div class="equipment-details">
                            <ul class="equipment-list">
                                <li>Dump Trucks: 12 units</li>
                                <li>Trailers: 6 units</li>
                                <li>Pickup Trucks: 15 units</li>
                                <li>Utility Vehicles: 10 units</li>
                                <li>Fuel Tankers: 3 units</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Equipment Card 3 -->
                <div class="col-lg-4 col-md-6 animate-on-scroll" data-animation="fadeInUp" data-delay="0.4">
                    <div class="equipment-card">
                        <div class="equipment-icon-container">
                            <div class="icon-bg"></div>
                            <i class="fas fa-ruler-combined equipment-icon"></i>
                        </div>
                        <h3 class="equipment-title">Survey & Testing</h3>
                        <div class="equipment-stats">
                            <div class="stat-item">
                                <span class="stat-number" data-count="10">0</span>
                                <span class="stat-label">Total Stations</span>
                            </div>
                            <div class="stat-item">
                                <span class="stat-number" data-count="12">0</span>
                                <span class="stat-label">Level Machines</span>
                            </div>
                            <div class="stat-item">
                                <span class="stat-number" data-count="5">0</span>
                                <span class="stat-label">CBR Apparatus</span>
                            </div>
                            <div class="stat-item">
                                <span class="stat-number" data-count="5">0</span>
                                <span class="stat-label">Strength Testers</span>
                            </div>
                        </div>
                        <div class="equipment-details-toggle">
                            <button class="btn-details">View Full Inventory <i class="fas fa-chevron-down"></i></button>
                        </div>
                        <div class="equipment-details">
                            <ul class="equipment-list">
                                <li>Theodolites: 8 units</li>
                                <li>GPS Systems: 6 units</li>
                                <li>Soil Test Kits: 15 sets</li>
                                <li>Concrete Test Hammers: 10 units</li>
                                <li>Lab Testing Equipment: Full set</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- testimonial section start -->

    <section class="testimonial-section-gwallek">
        <div class="container-fluid">
            <div class="row g-0">
                <div class="col-lg-7">
                    <div class="about-content-gwallek">
                        <div class="layer-content-gwallek">
                            <div class="section-title-gwallek">
                                <h5>OUR CLIENTS</h5>
                                <h2>Happy <strong>Customers & Partners</strong></h2>
                                <div class="heading-line-gwallek"></div>
                                <p class="mt-4">Our commitment to quality, timeliness, and professional standards is
                                    what builds lasting partnerships. We are proud of the trust our clients place in us
                                    for their most critical projects, from large-scale infrastructure to community
                                    development.</p>
                            </div>
                            <a href="{{ route('frontend.contact') }}" class="btn btn-primary mt-4"
                                style="background-color: var(--secondary-color); border-color: var(--secondary-color);">Contact
                                Us</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-5">
                    <div class="testimonial-box-gwallek">
                        <div class="testimonial-container-gwallek">
                            <div class="layer-content-gwallek">
                                <div class="owl-carousel testimonial-owlCarousel-gwallek">
                                    <!-- Testimonial 1: Upper Chameliya Hydropower Project -->
                                    @foreach ($tests as $key => $value)
                                        <div class="item">
                                            <div class="position-relative">
                                                <div
                                                    class="testimonial-img-gwallek d-flex justify-content-center justify-content-md-start">
                                                    <img src="{{ asset('upload/images/testimonials/' . $value->image) }}"
                                                        alt="Client 1">
                                                </div>
                                                <div class="testimonial-content-gwallek mt-5 mt-md-0">
                                                    <p class="pt-5 pt-md-0 testiPara">{!! $value->message !!}</p>
                                                    <div class="testimonial-caption-gwallek">
                                                        <h6>{{ $value->name }}</h6>
                                                        <span>{{ $value->designation }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- testimonial section end  -->

    <!-- blog section start  -->
    <section id="gns-blog" class="gns-blog-section py-5 py-lg-6">
        <div class="container">
            <!-- Section Heading -->
            <div class="row text-center mb-5">
                <div class="col-12">
                    <div class="gns-section-heading">
                        <h2 class="section-title-text display-4 fw-bold text-primary-custom"><span>Our</span> Blog</h2>
                        <div class="section-divider mx-auto mt-3"></div>

                    </div>
                </div>
            </div>

            <div class="gns-blog-carousel-container position-relative">
                <div class="gns-blog-carousel" id="gnsBlogCarousel">
                    <!-- Blog Post 2 -->
                    @foreach ($blogs as $key => $value)
                        <div class="gns-blog-card">
                            <div class="gns-blog-img overflow-hidden">
                                <a href="#!">
                                    <img src="{{ asset('upload/images/blogs/' . $value->image) }}"
                                        alt="Construction Project" class="img-fluid w-100">
                                </a>
                            </div>
                            <div class="gns-blog-content p-4">
                                <a href="{{ route('frontend.details_blog', $value->id) }}"
                                    class="gns-blog-title">{{ $value->title }}</a>
                                <p class="gns-blog-excerpt mt-3">
                                    {!! $value->short_description !!}
                                </p>
                                <a href="{{ route('frontend.details_blog', $value->id) }}"
                                    class="gns-read-more d-inline-block mt-3">Read More <i
                                        class="fas fa-arrow-right ms-2"></i></a>
                                <div class="gns-blog-meta mt-4 pt-3 border-top">
                                    <ul class="list-unstyled d-flex flex-wrap gap-3 mb-0">
                                        <li class="d-flex align-items-center">
                                            <i class="fas fa-user me-2"></i> Admin
                                        </li>
                                        <li class="d-flex align-items-center">
                                            <i class="fas fa-calendar me-2"></i> {{ $value->created_at->format('d F Y') }}
                                        </li>
                                        <li class="d-flex align-items-center">
                                            <i class="fas fa-hard-hat me-2"></i> Construction
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    <!-- Add more posts as needed -->
                </div>

                <button class="gns-carousel-btn gns-prev-btn" aria-label="Previous">
                    <i class="fas fa-chevron-left"></i>
                </button>
                <button class="gns-carousel-btn gns-next-btn" aria-label="Next">
                    <i class="fas fa-chevron-right"></i>
                </button>
            </div>

            <div class="gns-carousel-dots mt-4" id="gnsBlogDots">
                <!-- Dots will be added by JavaScript -->
            </div>
        </div>
    </section>

    <!-- blog section end  -->

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
                            aria-controls="branch{{ $branch->id }}"
                            aria-selected="{{ $key == 0 ? 'true' : 'false' }}">
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
                                    <form id="gnsQuoteForm" action="{{ route('inquiry.store') }}" method="POST">
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
                                            <button type="submit" class="btn btn-block gns-submit-btn">
                                                Get Quote <i class="fas fa-arrow-right ms-2"></i>
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
                                    <input type="text" name="name" class="form-control" placeholder="Your Name"
                                        required>
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
@endsection
