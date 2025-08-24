@extends('frontend.layouts.master')
@section('title',"Gwallek Nirman Sewa")
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
            <!-- Slide 1 - Infrastructure Development -->
            <div class="carousel-item active">
                <div class="carousel-overlay"></div>
                <img src="frontend/images//hero1.jpg" class="d-block w-100" alt="Infrastructure Development">
                <div class="carousel-caption animate__animated animate__fadeInUp">
                    <h1 class="display-3 fw-bold mb-3">Building Nepal's Future</h1>
                    <p class="lead mb-4">Transforming landscapes with cutting-edge infrastructure solutions since
                        1999</p>
                    <div class="d-flex justify-content-center">
                        <a href="#projects" class="btn btn-secondary-custom btn-lg mx-2">Our Projects</a>
                        <a href="#services" class="btn btn-outline-light btn-lg mx-2">Our Services</a>
                    </div>
                </div>
            </div>

            <!-- Slide 2 - Hydropower Expertise -->
            <div class="carousel-item">
                <div class="carousel-overlay"></div>
                <img src="frontend/images/hero2.jpg" class="d-block w-100" alt="Hydropower Project">
                <div class="carousel-caption animate__animated animate__fadeInRight">
                    <h1 class="display-3 fw-bold mb-3">Hydropower Specialists</h1>
                    <p class="lead mb-4">Delivering sustainable energy solutions with 28+ MW projects nationwide</p>
                    <a href="#services" class="btn btn-primary-custom btn-lg">Explore Hydropower</a>
                </div>
            </div>

            <!-- Slide 3 - Road Construction -->
            <div class="carousel-item">
                <div class="carousel-overlay"></div>
                <img src="frontend/images/hero3.jpg" class="d-block w-100" alt="Road Construction">
                <div class="carousel-caption animate__animated animate__fadeInLeft">
                    <h1 class="display-3 fw-bold mb-3">Connecting Communities</h1>
                    <p class="lead mb-4">Building roads and bridges that unite Nepal's diverse regions</p>
                    <a href="#contact" class="btn btn-secondary-custom btn-lg">Partner With Us</a>
                </div>
            </div>
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
                        <p class="lead">Gwallek Nirman Sewa Pvt. Ltd was originally established as a 'D' Class
                            Contractor in 1999 A.D. (2056 B.S) and was subsequently converted into Private Limited
                            in March 2014 A.D.</p>
                        <p>We have emerged as one of Nepal's leading Construction Companies, involved in the
                            construction of large scale infrastructure, including roads, bridges, buildings etc,
                            achieving remarkable success in every field without any history of litigation.</p>
                        <p>Being a reputable Construction Company in Civil Engineering Fields, we have played a
                            vital role in major projects in Nepal.</p>
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
                    <img src="frontend/images/manager.jpg" class="img-fluid director-image" alt="Managing Director">
                    <div class="director-overlay"></div>
                    <div class="director-badge">
                        <span class="director-title">Managing Director</span>
                        <span class="director-name">Mr. Suresh Chand</span>
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
                        <div class="quote-icon start">
                            <i class="fas fa-quote-left"></i>
                        </div>
                        <p>We are the fastest growing infrastructure company in the country and we aim to become the
                            best in the next 7 years. We are not just building infrastructure we are building
                            history at the same time.</p>
                        <div class="quote-icon end">
                            <i class="fas fa-quote-right"></i>
                        </div>
                    </blockquote>
                    <div class="director-info mt-4">
                        <h5 class="mb-0">Mr. Suresh Chand</h5>
                        <p class="text-secondary-custom mb-0">Managing Director</p>
                        <div class="signature mt-3">
                            <img src="/signature.png" alt="Signature" class="img-fluid" style="height: 40px;">
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
            <!-- Hydropower -->
            <div class="col-lg-4 col-md-6 animate-on-scroll" data-animation="fadeInUp">
                <div class="service-card card h-100 border-0">
                    <div class="card-body p-4 text-center">
                        <div class="service-icon">
                            <div class="icon-wrapper">
                                <div class="icon-inner">
                                    <img src="frontend/images/hydro-power.gif" height="50px" class="rounded-circle"
                                        alt="Hydropower">
                                </div>
                            </div>
                        </div>
                        <h4 class="text-primary-custom mb-3">Hydropower</h4>
                        <p class="mb-4">Specialized in hydropower plant construction with expertise in dam building,
                            turbine installation, and power generation infrastructure.</p>
                        <div class="service-btn-wrapper">
                            <a href="/details_service.html"
                                class="btn btn-outline-primary-custom stretched-link">Learn More</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Road & Bridge -->
            <div class="col-lg-4 col-md-6 animate-on-scroll" data-animation="fadeInUp" data-delay="0.1s">
                <div class="service-card card h-100 border-0">
                    <div class="card-body p-4 text-center">
                        <div class="service-icon">
                            <div class="icon-wrapper">
                                <div class="icon-inner">
                                    <img src="frontend/images/bridge.gif" height="50px" class="rounded-circle"
                                        alt="Road & Bridge">
                                </div>
                            </div>
                        </div>
                        <h4 class="text-primary-custom mb-3">Road & Bridge Projects</h4>
                        <p class="mb-4">Comprehensive road construction services including highways, rural roads,
                            and advanced bridge engineering solutions.</p>
                        <div class="service-btn-wrapper">
                            <a href="/details_service.html"
                                class="btn btn-outline-primary-custom stretched-link">Learn More</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- River Training -->
            <div class="col-lg-4 col-md-6 animate-on-scroll" data-animation="fadeInUp" data-delay="0.2s">
                <div class="service-card card h-100 border-0">
                    <div class="card-body p-4 text-center">
                        <div class="service-icon">
                            <div class="icon-wrapper">
                                <div class="icon-inner">
                                    <img src="frontend/images/flood.gif" height="50px" class="rounded-circle"
                                        alt="River Training">
                                </div>
                            </div>
                        </div>
                        <h4 class="text-primary-custom mb-3">River Training Projects</h4>
                        <p class="mb-4">Expertise in flood control, riverbank protection, and sustainable water
                            management solutions.</p>
                        <div class="service-btn-wrapper">
                            <a href="/details_service.html"
                                class="btn btn-outline-primary-custom stretched-link">Learn More</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Building & Land Dev -->
            <div class="col-lg-4 col-md-6 animate-on-scroll" data-animation="fadeInUp" data-delay="0.3s">
                <div class="service-card card h-100 border-0">
                    <div class="card-body p-4 text-center">
                        <div class="service-icon">
                            <div class="icon-wrapper">
                                <div class="icon-inner">
                                    <img src="frontend/images/building.gif" height="50px" class="rounded-circle"
                                        alt="Building Development">
                                </div>
                            </div>
                        </div>
                        <h4 class="text-primary-custom mb-3">Building & Land Development</h4>
                        <p class="mb-4">From residential complexes to commercial buildings, we deliver quality
                            construction with modern architecture.</p>
                        <div class="service-btn-wrapper">
                            <a href="/details_service.html"
                                class="btn btn-outline-primary-custom stretched-link">Learn More</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Water Supply -->
            <div class="col-lg-4 col-md-6 animate-on-scroll" data-animation="fadeInUp" data-delay="0.4s">
                <div class="service-card card h-100 border-0">
                    <div class="card-body p-4 text-center">
                        <div class="service-icon">
                            <div class="icon-wrapper">
                                <div class="icon-inner">
                                    <img src="frontend/images/water.gif" height="50px" class="rounded-circle"
                                        alt="Water Supply">
                                </div>
                            </div>
                        </div>
                        <h4 class="text-primary-custom mb-3">Water Supply & Sanitation</h4>
                        <p class="mb-4">Comprehensive solutions for clean water supply systems and modern sanitation
                            infrastructure.</p>
                        <div class="service-btn-wrapper">
                            <a href="/details_service.html"
                                class="btn btn-outline-primary-custom stretched-link">Learn More</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Irrigation -->
            <div class="col-lg-4 col-md-6 animate-on-scroll" data-animation="fadeInUp" data-delay="0.5s">
                <div class="service-card card h-100 border-0">
                    <div class="card-body p-4 text-center">
                        <div class="service-icon">
                            <div class="icon-wrapper">
                                <div class="icon-inner">
                                    <img src="frontend/images/plane.gif" height="50px" class="rounded-circle"
                                        alt="Irrigation">
                                </div>
                            </div>
                        </div>
                        <h4 class="text-primary-custom mb-3">Irrigation Projects</h4>
                        <p class="mb-4">Design and implementation of efficient irrigation systems to support
                            agricultural development.</p>
                        <div class="service-btn-wrapper">
                            <a href="/details_service.html"
                                class="btn btn-outline-primary-custom stretched-link">Learn More</a>
                        </div>
                    </div>
                </div>
            </div>
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
            <!-- Project 1 - Hydropower -->
            <div class="col-lg-4 col-md-6 project-item" data-category="ongoing hydropower">
                <div class="project-card">
                    <div class="project-image">
                        <img src="https:/frontend/images.unsplash.com/photo-1605106702734-205df224ecce?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80"
                            alt="Hydropower Project" class="img-fluid">
                    </div>
                    <div class="project-overlay">
                        <div class="project-badge ongoing">Ongoing</div>
                        <div class="project-content">
                            <h5>Middle Chamelia Hydropower 28.304 MW</h5>
                            <div class="project-meta">
                                <span><i class="fas fa-map-marker-alt"></i> Darchula</span>
                                <span><i class="fas fa-rupee-sign"></i> 1,820,000,000.00 NPR</span>
                            </div>
                            <p class="project-desc">28.304 MW hydropower plant construction in Darchula district</p>
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

            <!-- Project 2 - Hotel -->
            <div class="col-lg-4 col-md-6 project-item" data-category="ongoing building">
                <div class="project-card">
                    <div class="project-image">
                        <img src="https:/frontend/images.unsplash.com/photo-1600607688969-a5bfcd646154?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80"
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
                        <img src="https:/frontend/images.unsplash.com/photo-1605276374104-dee2a0ed3cd6?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80"
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
                        <img src="https:/frontend/images.unsplash.com/photo-1600585154340-be6161a56a0c?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80"
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
                        <img src="frontend/images/services.jpg" alt="Hospital Project" class="img-fluid">
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
                        <img src="https:/frontend/images.unsplash.com/photo-1605000797499-95a51c5269ae?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1471&q=80"
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
            </div>
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
                            <div class="client-logo-item">
                                <img src="frontend/images/manager.jpg" alt="Government of Nepal"
                                    class="img-fluid client-logo">
                            </div>
                            <div class="client-logo-item">
                                <img src="frontend/images/manager.jpg" alt="Asian Development Bank"
                                    class="img-fluid client-logo">
                            </div>
                            <div class="client-logo-item">
                                <img src="frontend/images/manager.jpg" alt="Ministry of Federal Affairs"
                                    class="img-fluid client-logo">
                            </div>
                            <div class="client-logo-item">
                                <img src="frontend/images/manager.jpg" alt="Api Power Company"
                                    class="img-fluid client-logo">
                            </div>
                            <div class="client-logo-item">
                                <img src="frontend/images/manager.jpg" alt="World Bank"
                                    class="img-fluid client-logo">
                            </div>
                            <div class="client-logo-item">
                                <img src="frontend/images/manager.jpg" alt="UNDP" class="img-fluid client-logo">
                            </div>
                        </div>
                        <!-- Duplicate for seamless looping -->
                        <div class="client-logo-group">
                            <div class="client-logo-item">
                                <img src="frontend/images/manager.jpg" alt="Government of Nepal"
                                    class="img-fluid client-logo">
                            </div>
                            <div class="client-logo-item">
                                <img src="frontend/images/manager.jpg" alt="Asian Development Bank"
                                    class="img-fluid client-logo">
                            </div>
                            <div class="client-logo-item">
                                <img src="frontend/images/manager.jpg" alt="Ministry of Federal Affairs"
                                    class="img-fluid client-logo">
                            </div>
                            <div class="client-logo-item">
                                <img src="frontend/images/manager.jpg" alt="Api Power Company"
                                    class="img-fluid client-logo">
                            </div>
                            <div class="client-logo-item">
                                <img src="frontend/images/manager.jpg" alt="World Bank"
                                    class="img-fluid client-logo">
                            </div>
                            <div class="client-logo-item">
                                <img src="frontend/images/manager.jpg" alt="UNDP" class="img-fluid client-logo">
                            </div>
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
                        <a href="#" class="btn btn-primary mt-4"
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
                                <div class="item">
                                    <div class="position-relative">
                                        <div
                                            class="testimonial-img-gwallek d-flex justify-content-center justify-content-md-start">
                                            <img src="frontend/images/manager.jpg" alt="Client 1">
                                        </div>
                                        <div class="testimonial-content-gwallek mt-5 mt-md-0">
                                            <p class="pt-5 pt-md-0 testiPara">"The Gwallek Nirman Sewa team's
                                                handling of the Upper Chameliya Hydropower Project was exceptional.
                                                Their expertise and dedication were key to successfully delivering
                                                such a complex and vital infrastructure project on schedule."</p>
                                            <div class="testimonial-caption-gwallek">
                                                <h6>Suresh Karki</h6>
                                                <span>Project Head, Api Power Company</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Testimonial 2: District Hospital Baitadi -->
                                <div class="item">
                                    <div class="position-relative">
                                        <div
                                            class="testimonial-img-gwallek d-flex justify-content-center justify-content-md-start">
                                            <img src="frontend/images/manager.jpg" alt="Client 2">
                                        </div>
                                        <div class="testimonial-content-gwallek mt-5 mt-md-0">
                                            <p class="pt-5 pt-md-0 testiPara">"We chose Gwallek Nirman Sewa for the
                                                District Hospital Baitadi project because of their reputation for
                                                quality work. They did not disappoint. Their commitment to the
                                                community was evident in the high standards they maintained
                                                throughout the construction."</p>
                                            <div class="testimonial-caption-gwallek">
                                                <h6>Anjali Rai</h6>
                                                <span>Government Official, Baitadi</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Testimonial 3: Steel Truss Bridge -->
                                <div class="item">
                                    <div class="position-relative">
                                        <div
                                            class="testimonial-img-gwallek d-flex justify-content-center justify-content-md-start">
                                            <img src="frontend/images/manager.jpg" alt="Client 3">
                                        </div>
                                        <div class="testimonial-content-gwallek mt-5 mt-md-0">
                                            <p class="pt-5 pt-md-0 testiPara">"The construction of the Steel Truss
                                                Bridge over the Seti River was a testament to Gwallek's engineering
                                                excellence. The project was completed safely and efficiently,
                                                providing a critical link for the region. We are very satisfied with
                                                their work."</p>
                                            <div class="testimonial-caption-gwallek">
                                                <h6>Dinesh Gurung</h6>
                                                <span>Lead Engineer, Public Works Dept.</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
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
                <!-- Blog Post 1 -->
                <div class="gns-blog-card">
                    <div class="gns-blog-img overflow-hidden">
                        <a href="#!">
                            <img src="https:/frontend/images.unsplash.com/photo-1605152276897-4f618f831968?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80"
                                alt="Construction Project" class="img-fluid w-100">
                        </a>
                    </div>
                    <div class="gns-blog-content p-4">
                        <a href="#!" class="gns-blog-title">Innovations in Hydropower Construction</a>
                        <p class="gns-blog-excerpt mt-3">
                            Exploring the latest technologies being implemented in Nepal's hydropower sector.
                        </p>
                        <a href="/detail_blog.html" class="gns-read-more d-inline-block mt-3">Read More <i
                                class="fas fa-arrow-right ms-2"></i></a>
                        <div class="gns-blog-meta mt-4 pt-3 border-top">
                            <ul class="list-unstyled d-flex flex-wrap gap-3 mb-0">
                                <li class="d-flex align-items-center">
                                    <i class="fas fa-user me-2"></i> Admin
                                </li>
                                <li class="d-flex align-items-center">
                                    <i class="fas fa-calendar me-2"></i> 15 August
                                </li>
                                <li class="d-flex align-items-center">
                                    <i class="fas fa-hard-hat me-2"></i> Construction
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Blog Post 2 -->
                <div class="gns-blog-card">
                    <div class="gns-blog-img overflow-hidden">
                        <a href="#!">
                            <img src="https:/frontend/images.unsplash.com/photo-1605152276897-4f618f831968?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80"
                                alt="Construction Project" class="img-fluid w-100">
                        </a>
                    </div>
                    <div class="gns-blog-content p-4">
                        <a href="#!" class="gns-blog-title">Innovations in Hydropower Construction</a>
                        <p class="gns-blog-excerpt mt-3">
                            Exploring the latest technologies being implemented in Nepal's hydropower sector.
                        </p>
                        <a href="/detail_blog.html" class="gns-read-more d-inline-block mt-3">Read More <i
                                class="fas fa-arrow-right ms-2"></i></a>
                        <div class="gns-blog-meta mt-4 pt-3 border-top">
                            <ul class="list-unstyled d-flex flex-wrap gap-3 mb-0">
                                <li class="d-flex align-items-center">
                                    <i class="fas fa-user me-2"></i> Admin
                                </li>
                                <li class="d-flex align-items-center">
                                    <i class="fas fa-calendar me-2"></i> 15 August
                                </li>
                                <li class="d-flex align-items-center">
                                    <i class="fas fa-hard-hat me-2"></i> Construction
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Blog Post 3 -->
                <div class="gns-blog-card">
                    <div class="gns-blog-img overflow-hidden">
                        <a href="#!">
                            <img src="https:/frontend/images.unsplash.com/photo-1605152276897-4f618f831968?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80"
                                alt="Construction Project" class="img-fluid w-100">
                        </a>
                    </div>
                    <div class="gns-blog-content p-4">
                        <a href="#!" class="gns-blog-title">Innovations in Hydropower Construction</a>
                        <p class="gns-blog-excerpt mt-3">
                            Exploring the latest technologies being implemented in Nepal's hydropower sector.
                        </p>
                        <a href="/detail_blog.html" class="gns-read-more d-inline-block mt-3">Read More <i
                                class="fas fa-arrow-right ms-2"></i></a>
                        <div class="gns-blog-meta mt-4 pt-3 border-top">
                            <ul class="list-unstyled d-flex flex-wrap gap-3 mb-0">
                                <li class="d-flex align-items-center">
                                    <i class="fas fa-user me-2"></i> Admin
                                </li>
                                <li class="d-flex align-items-center">
                                    <i class="fas fa-calendar me-2"></i> 15 August
                                </li>
                                <li class="d-flex align-items-center">
                                    <i class="fas fa-hard-hat me-2"></i> Construction
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="gns-blog-card">
                    <div class="gns-blog-img overflow-hidden">
                        <a href="#!">
                            <img src="https:/frontend/images.unsplash.com/photo-1605152276897-4f618f831968?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80"
                                alt="Construction Project" class="img-fluid w-100">
                        </a>
                    </div>
                    <div class="gns-blog-content p-4">
                        <a href="#!" class="gns-blog-title">Innovations in Hydropower Construction</a>
                        <p class="gns-blog-excerpt mt-3">
                            Exploring the latest technologies being implemented in Nepal's hydropower sector.
                        </p>
                        <a href="detail_blog.html" class="gns-read-more d-inline-block mt-3">Read More <i
                                class="fas fa-arrow-right ms-2"></i></a>
                        <div class="gns-blog-meta mt-4 pt-3 border-top">
                            <ul class="list-unstyled d-flex flex-wrap gap-3 mb-0">
                                <li class="d-flex align-items-center">
                                    <i class="fas fa-user me-2"></i> Admin
                                </li>
                                <li class="d-flex align-items-center">
                                    <i class="fas fa-calendar me-2"></i> 15 August
                                </li>
                                <li class="d-flex align-items-center">
                                    <i class="fas fa-hard-hat me-2"></i> Construction
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="gns-blog-card">
                    <div class="gns-blog-img overflow-hidden">
                        <a href="#!">
                            <img src="https:/frontend/images.unsplash.com/photo-1605152276897-4f618f831968?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80"
                                alt="Construction Project" class="img-fluid w-100">
                        </a>
                    </div>
                    <div class="gns-blog-content p-4">
                        <a href="/detail_blog.html" class="gns-blog-title">Innovations in Hydropower Construction</a>
                        <p class="gns-blog-excerpt mt-3">
                            Exploring the latest technologies being implemented in Nepal's hydropower sector.
                        </p>
                        <a href="#!" class="gns-read-more d-inline-block mt-3">Read More <i
                                class="fas fa-arrow-right ms-2"></i></a>
                        <div class="gns-blog-meta mt-4 pt-3 border-top">
                            <ul class="list-unstyled d-flex flex-wrap gap-3 mb-0">
                                <li class="d-flex align-items-center">
                                    <i class="fas fa-user me-2"></i> Admin
                                </li>
                                <li class="d-flex align-items-center">
                                    <i class="fas fa-calendar me-2"></i> 15 August
                                </li>
                                <li class="d-flex align-items-center">
                                    <i class="fas fa-hard-hat me-2"></i> Construction
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="gns-blog-card">
                    <div class="gns-blog-img overflow-hidden">
                        <a href="#!">
                            <img src="https:/frontend/images.unsplash.com/photo-1605152276897-4f618f831968?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80"
                                alt="Construction Project" class="img-fluid w-100">
                        </a>
                    </div>
                    <div class="gns-blog-content p-4">
                        <a href="#!" class="gns-blog-title">Innovations in Hydropower Construction</a>
                        <p class="gns-blog-excerpt mt-3">
                            Exploring the latest technologies being implemented in Nepal's hydropower sector.
                        </p>
                        <a href="/detail_blog.html" class="gns-read-more d-inline-block mt-3">Read More <i
                                class="fas fa-arrow-right ms-2"></i></a>
                        <div class="gns-blog-meta mt-4 pt-3 border-top">
                            <ul class="list-unstyled d-flex flex-wrap gap-3 mb-0">
                                <li class="d-flex align-items-center">
                                    <i class="fas fa-user me-2"></i> Admin
                                </li>
                                <li class="d-flex align-items-center">
                                    <i class="fas fa-calendar me-2"></i> 15 August
                                </li>
                                <li class="d-flex align-items-center">
                                    <i class="fas fa-hard-hat me-2"></i> Construction
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

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
        <ul class="nav nav-pills mb-4 justify-content-center" id="branch-tabs" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="main-branch-tab" data-bs-toggle="pill"
                    data-bs-target="#main-branch" type="button" role="tab" aria-controls="main-branch"
                    aria-selected="true">
                    <i class="fas fa-building me-2"></i>Head Office
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="branch2-tab" data-bs-toggle="pill" data-bs-target="#branch2"
                    type="button" role="tab" aria-controls="branch2" aria-selected="false">
                    <i class="fas fa-store me-2"></i>Kathmandu Branch
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="branch3-tab" data-bs-toggle="pill" data-bs-target="#branch3"
                    type="button" role="tab" aria-controls="branch3" aria-selected="false">
                    <i class="fas fa-warehouse me-2"></i>Pokhara Branch
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="branch4-tab" data-bs-toggle="pill" data-bs-target="#branch4"
                    type="button" role="tab" aria-controls="branch4" aria-selected="false">
                    <i class="fas fa-hotel me-2"></i>Chitwan Branch
                </button>
            </li>
        </ul>

        <!-- Tab Content -->
        <div class="tab-content" id="branch-tabs-content">
            <!-- Head Office -->
            <div class="tab-pane fade show active" id="main-branch" role="tabpanel"
                aria-labelledby="main-branch-tab">
                <div class="row g-4">
                    <div class="col-lg-6">
                        <div class="branch-card p-4 h-100">
                            <h3 class="fw-bold mb-4"><i class="fas fa-building me-2"></i>Head Office</h3>
                            <div class="branch-info mb-4">
                                <div class="info-item d-flex mb-3">
                                    <div class="icon-circle bg-primary me-3">
                                        <i class="fas fa-map-marker-alt text-white"></i>
                                    </div>
                                    <div>
                                        <h5 class="fw-bold mb-1">Address</h5>
                                        <p class="mb-0">Jawlakhel, Lalitpur, Nepal</p>
                                    </div>
                                </div>
                                <div class="info-item d-flex mb-3">
                                    <div class="icon-circle bg-primary me-3">
                                        <i class="fas fa-phone text-white"></i>
                                    </div>
                                    <div>
                                        <h5 class="fw-bold mb-1">Phone</h5>
                                        <p class="mb-0">
                                            <a href="tel:+9779764638130"
                                                class="text-contact">+977-9764638130</a><br>
                                            <a href="tel:+977014411122" class="text-contact">+977-01-4411122</a>
                                        </p>
                                    </div>
                                </div>
                                <div class="info-item d-flex mb-3">
                                    <div class="icon-circle bg-primary me-3">
                                        <i class="fas fa-envelope text-white"></i>
                                    </div>
                                    <div>
                                        <h5 class="fw-bold mb-1">Email</h5>
                                        <p class="mb-0">
                                            <a href="mailto:gwallekpvt.ltd@gmail.com"
                                                class="text-contact">gwallekpvt.ltd@gmail.com</a><br>
                                            <a href="mailto:support@gwallek.com"
                                                class="text-contact">support@gwallek.com</a>
                                        </p>
                                    </div>
                                </div>
                                <div class="info-item d-flex">
                                    <div class="icon-circle bg-primary me-3">
                                        <i class="fas fa-clock text-white"></i>
                                    </div>
                                    <div>
                                        <h5 class="fw-bold mb-1">Opening Hours</h5>
                                        <p class="mb-0">Sunday-Friday: 9:00 AM - 6:00 PM<br>Saturday: 10:00 AM -
                                            4:00 PM</p>
                                    </div>
                                </div>
                            </div>
                            <div class="branch-features">
                                <h5 class="fw-bold mb-3">Facilities</h5>
                                <div class="d-flex flex-wrap gap-2">
                                    <span class="badge bg-light text-dark"><i class="fas fa-wifi me-1"></i> Free
                                        WiFi</span>
                                    <span class="badge bg-light text-dark"><i class="fas fa-parking me-1"></i>
                                        Parking</span>
                                    <span class="badge bg-light text-dark"><i class="fas fa-wheelchair me-1"></i>
                                        Accessibility</span>
                                    <span class="badge bg-light text-dark"><i class="fas fa-coffee me-1"></i>
                                        Lounge</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="contact-form-wrapper p-4 h-100">
                            <h4 class="fw-bold mb-4 text-center text-contact">Send a Message</h4>
                            <form id="contactFormMain" novalidate>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="name-main" class="form-label">Your Name</label>
                                        <input type="text" class="form-control" id="name-main" required>
                                        <div class="invalid-feedback">Please enter your name.</div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="email-main" class="form-label">Your Email</label>
                                        <input type="email" class="form-control" id="email-main" required>
                                        <div class="invalid-feedback">Please enter a valid email address.</div>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="subject-main" class="form-label">Subject</label>
                                    <input type="text" class="form-control" id="subject-main" required>
                                    <div class="invalid-feedback">Please enter a subject.</div>
                                </div>
                                <div class="mb-4">
                                    <label for="message-main" class="form-label">Message</label>
                                    <textarea class="form-control" id="message-main" rows="5" required></textarea>
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
                <div class="mt-4">
                    <div class="map-container rounded-3 overflow-hidden shadow-sm">
                        <iframe
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3533.025313969194!2d85.3110918150616!3d27.68551098280061!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x39eb19b200000001%3A0x16b6456250a8a7a1!2sJawalakhel%2C%20Lalitpur%2044600%2C%20Nepal!5e0!3m2!1sen!2snp!4v1678886543210!5m2!1sen!2snp"
                            allowfullscreen="" loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade"></iframe>
                    </div>
                </div>
            </div>

            <!-- Kathmandu Branch -->
            <div class="tab-pane fade" id="branch2" role="tabpanel" aria-labelledby="branch2-tab">
                <div class="row g-4">
                    <div class="col-lg-6">
                        <div class="branch-card p-4 h-100">
                            <h3 class="fw-bold mb-4"><i class="fas fa-store me-2"></i>Kathmandu Branch</h3>
                            <div class="branch-info mb-4">
                                <div class="info-item d-flex mb-3">
                                    <div class="icon-circle bg-primary me-3">
                                        <i class="fas fa-map-marker-alt text-white"></i>
                                    </div>
                                    <div>
                                        <h5 class="fw-bold mb-1">Address</h5>
                                        <p class="mb-0">New Road, Kathmandu, Nepal</p>
                                    </div>
                                </div>
                                <div class="info-item d-flex mb-3">
                                    <div class="icon-circle bg-primary me-3">
                                        <i class="fas fa-phone text-white"></i>
                                    </div>
                                    <div>
                                        <h5 class="fw-bold mb-1">Phone</h5>
                                        <p class="mb-0">
                                            <a href="tel:+9779801234567"
                                                class="text-contact">+977-9801234567</a><br>
                                            <a href="tel:+977014266677" class="text-contact">+977-01-4266677</a>
                                        </p>
                                    </div>
                                </div>
                                <div class="info-item d-flex mb-3">
                                    <div class="icon-circle bg-primary me-3">
                                        <i class="fas fa-envelope text-white"></i>
                                    </div>
                                    <div>
                                        <h5 class="fw-bold mb-1">Email</h5>
                                        <p class="mb-0">
                                            <a href="mailto:kathmandu@gwallek.com"
                                                class="text-contact">kathmandu@gwallek.com</a>
                                        </p>
                                    </div>
                                </div>
                                <div class="info-item d-flex">
                                    <div class="icon-circle bg-primary me-3">
                                        <i class="fas fa-clock text-white"></i>
                                    </div>
                                    <div>
                                        <h5 class="fw-bold mb-1">Opening Hours</h5>
                                        <p class="mb-0">Sunday-Friday: 9:30 AM - 6:30 PM<br>Saturday: Closed</p>
                                    </div>
                                </div>
                            </div>
                            <div class="branch-features">
                                <h5 class="fw-bold mb-3">Facilities</h5>
                                <div class="d-flex flex-wrap gap-2">
                                    <span class="badge bg-light text-dark"><i class="fas fa-wifi me-1"></i> Free
                                        WiFi</span>
                                    <span class="badge bg-light text-dark"><i class="fas fa-tshirt me-1"></i> Dress
                                        Code</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="contact-form-wrapper p-4 h-100">
                            <h4 class="fw-bold mb-4 text-center text-contact">Send a Message</h4>
                            <form id="contactFormBranch2" novalidate>
                                <div class="mb-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="forwardMain2" checked>
                                        <label class="form-check-label" for="forwardMain2">
                                            Also send to head office for better response
                                        </label>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="name-branch2" class="form-label">Your Name</label>
                                        <input type="text" class="form-control" id="name-branch2" required>
                                        <div class="invalid-feedback">Please enter your name.</div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="email-branch2" class="form-label">Your Email</label>
                                        <input type="email" class="form-control" id="email-branch2" required>
                                        <div class="invalid-feedback">Please enter a valid email address.</div>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="subject-branch2" class="form-label">Subject</label>
                                    <input type="text" class="form-control" id="subject-branch2" required>
                                    <div class="invalid-feedback">Please enter a subject.</div>
                                </div>
                                <div class="mb-4">
                                    <label for="message-branch2" class="form-label">Message</label>
                                    <textarea class="form-control" id="message-branch2" rows="5" required></textarea>
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
                <div class="mt-4">
                    <div class="map-container rounded-3 overflow-hidden shadow-sm">
                        <iframe
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3532.321361843502!2d85.3123883150621!3d27.70852378189459!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x39eb185ff2a8a7a9%3A0x1b1f5e5e5e5e5e5e!2sNew%20Road%2C%20Kathmandu%2044600%2C%20Nepal!5e0!3m2!1sen!2snp!4v1678886543210!5m2!1sen!2snp"
                            allowfullscreen="" loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade"></iframe>
                    </div>
                </div>
            </div>

            <!-- Pokhara Branch -->
            <div class="tab-pane fade" id="branch3" role="tabpanel" aria-labelledby="branch3-tab">
                <div class="row g-4">
                    <div class="col-lg-6">
                        <div class="branch-card p-4 h-100">
                            <h3 class="fw-bold mb-4"><i class="fas fa-warehouse me-2"></i>Pokhara Branch</h3>
                            <div class="branch-info mb-4">
                                <div class="info-item d-flex mb-3">
                                    <div class="icon-circle bg-primary me-3">
                                        <i class="fas fa-map-marker-alt text-white"></i>
                                    </div>
                                    <div>
                                        <h5 class="fw-bold mb-1">Address</h5>
                                        <p class="mb-0">Lakeside, Pokhara, Nepal</p>
                                    </div>
                                </div>
                                <div class="info-item d-flex mb-3">
                                    <div class="icon-circle bg-primary me-3">
                                        <i class="fas fa-phone text-white"></i>
                                    </div>
                                    <div>
                                        <h5 class="fw-bold mb-1">Phone</h5>
                                        <p class="mb-0">
                                            <a href="tel:+9779812345678"
                                                class="text-contact">+977-9812345678</a><br>
                                            <a href="tel:+97761523456" class="text-contact">+977-61-523456</a>
                                        </p>
                                    </div>
                                </div>
                                <div class="info-item d-flex mb-3">
                                    <div class="icon-circle bg-primary me-3">
                                        <i class="fas fa-envelope text-white"></i>
                                    </div>
                                    <div>
                                        <h5 class="fw-bold mb-1">Email</h5>
                                        <p class="mb-0">
                                            <a href="mailto:pokhara@gwallek.com"
                                                class="text-contact">pokhara@gwallek.com</a>
                                        </p>
                                    </div>
                                </div>
                                <div class="info-item d-flex">
                                    <div class="icon-circle bg-primary me-3">
                                        <i class="fas fa-clock text-white"></i>
                                    </div>
                                    <div>
                                        <h5 class="fw-bold mb-1">Opening Hours</h5>
                                        <p class="mb-0">Sunday-Friday: 10:00 AM - 5:00 PM<br>Saturday: 10:00 AM -
                                            3:00 PM</p>
                                    </div>
                                </div>
                            </div>
                            <div class="branch-features">
                                <h5 class="fw-bold mb-3">Facilities</h5>
                                <div class="d-flex flex-wrap gap-2">
                                    <span class="badge bg-light text-dark"><i class="fas fa-parking me-1"></i>
                                        Parking</span>
                                    <span class="badge bg-light text-dark"><i class="fas fa-shipping-fast me-1"></i>
                                        Delivery</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="contact-form-wrapper p-4 h-100">
                            <h4 class="fw-bold mb-4 text-center text-contact">Send a Message</h4>
                            <form id="contactFormBranch3" novalidate>
                                <div class="mb-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="forwardMain3" checked>
                                        <label class="form-check-label" for="forwardMain3">
                                            Also send to head office for better response
                                        </label>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="name-branch3" class="form-label">Your Name</label>
                                        <input type="text" class="form-control" id="name-branch3" required>
                                        <div class="invalid-feedback">Please enter your name.</div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="email-branch3" class="form-label">Your Email</label>
                                        <input type="email" class="form-control" id="email-branch3" required>
                                        <div class="invalid-feedback">Please enter a valid email address.</div>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="subject-branch3" class="form-label">Subject</label>
                                    <input type="text" class="form-control" id="subject-branch3" required>
                                    <div class="invalid-feedback">Please enter a subject.</div>
                                </div>
                                <div class="mb-4">
                                    <label for="message-branch3" class="form-label">Message</label>
                                    <textarea class="form-control" id="message-branch3" rows="5" required></textarea>
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
                <div class="mt-4">
                    <div class="map-container rounded-3 overflow-hidden shadow-sm">
                        <iframe
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3516.085361843502!2d83.9623883150621!3d28.20852378189459!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3995947a5f5f5f5f%3A0x1b1f5e5e5e5e5e5e!2sLakeside%2C%20Pokhara%2033700%2C%20Nepal!5e0!3m2!1sen!2snp!4v1678886543210!5m2!1sen!2snp"
                            allowfullscreen="" loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade"></iframe>
                    </div>
                </div>
            </div>

            <!-- Chitwan Branch -->
            <div class="tab-pane fade" id="branch4" role="tabpanel" aria-labelledby="branch4-tab">
                <div class="row g-4">
                    <div class="col-lg-6">
                        <div class="branch-card p-4 h-100">
                            <h3 class="fw-bold mb-4"><i class="fas fa-hotel me-2"></i>Chitwan Branch</h3>
                            <div class="branch-info mb-4">
                                <div class="info-item d-flex mb-3">
                                    <div class="icon-circle bg-primary me-3">
                                        <i class="fas fa-map-marker-alt text-white"></i>
                                    </div>
                                    <div>
                                        <h5 class="fw-bold mb-1">Address</h5>
                                        <p class="mb-0">Narayangarh, Chitwan, Nepal</p>
                                    </div>
                                </div>
                                <div class="info-item d-flex mb-3">
                                    <div class="icon-circle bg-primary me-3">
                                        <i class="fas fa-phone text-white"></i>
                                    </div>
                                    <div>
                                        <h5 class="fw-bold mb-1">Phone</h5>
                                        <p class="mb-0">
                                            <a href="tel:+9779823456789"
                                                class="text-contact">+977-9823456789</a><br>
                                            <a href="tel:+97756567890" class="text-contact">+977-56-567890</a>
                                        </p>
                                    </div>
                                </div>
                                <div class="info-item d-flex mb-3">
                                    <div class="icon-circle bg-primary me-3">
                                        <i class="fas fa-envelope text-white"></i>
                                    </div>
                                    <div>
                                        <h5 class="fw-bold mb-1">Email</h5>
                                        <p class="mb-0">
                                            <a href="mailto:chitwan@gwallek.com"
                                                class="text-contact">chitwan@gwallek.com</a>
                                        </p>
                                    </div>
                                </div>
                                <div class="info-item d-flex">
                                    <div class="icon-circle bg-primary me-3">
                                        <i class="fas fa-clock text-white"></i>
                                    </div>
                                    <div>
                                        <h5 class="fw-bold mb-1">Opening Hours</h5>
                                        <p class="mb-0">Sunday-Friday: 9:00 AM - 5:30 PM<br>Saturday: Closed</p>
                                    </div>
                                </div>
                            </div>
                            <div class="branch-features">
                                <h5 class="fw-bold mb-3">Facilities</h5>
                                <div class="d-flex flex-wrap gap-2">
                                    <span class="badge bg-light text-dark"><i class="fas fa-parking me-1"></i>
                                        Parking</span>
                                    <span class="badge bg-light text-dark"><i class="fas fa-utensils me-1"></i>
                                        Cafe</span>
                                    <span class="badge bg-light text-dark"><i class="fas fa-child me-1"></i> Kids
                                        Area</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="contact-form-wrapper p-4 h-100">
                            <h4 class="fw-bold mb-4 text-center text-contact">Send a Message</h4>
                            <form id="contactFormBranch4" novalidate>
                                <div class="mb-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="forwardMain4" checked>
                                        <label class="form-check-label" for="forwardMain4">
                                            Also send to head office for better response
                                        </label>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="name-branch4" class="form-label">Your Name</label>
                                        <input type="text" class="form-control" id="name-branch4" required>
                                        <div class="invalid-feedback">Please enter your name.</div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="email-branch4" class="form-label">Your Email</label>
                                        <input type="email" class="form-control" id="email-branch4" required>
                                        <div class="invalid-feedback">Please enter a valid email address.</div>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="subject-branch4" class="form-label">Subject</label>
                                    <input type="text" class="form-control" id="subject-branch4" required>
                                    <div class="invalid-feedback">Please enter a subject.</div>
                                </div>
                                <div class="mb-4">
                                    <label for="message-branch4" class="form-label">Message</label>
                                    <textarea class="form-control" id="message-branch4" rows="5" required></textarea>
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
                <div class="mt-4">
                    <div class="map-container rounded-3 overflow-hidden shadow-sm">
                        <iframe
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3532.321361843502!2d84.4123883150621!3d27.70852378189459!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3994e5e5e5e5e5e5%3A0x1b1f5e5e5e5e5e5e!2sNarayangarh%2C%20Chitwan%2044200%2C%20Nepal!5e0!3m2!1sen!2snp!4v1678886543210!5m2!1sen!2snp"
                            allowfullscreen="" loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade"></iframe>
                    </div>
                </div>
            </div>
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
                        <form id="gnsQuoteForm">
                            <div class="mb-3">
                                <input type="text" class="form-control" placeholder="Your Name" required>
                            </div>
                            <div class="mb-3">
                                <input type="email" class="form-control" placeholder="Email" required>
                            </div>
                            <div class="mb-3">
                                <select class="form-select">
                                    <option selected disabled>Project Type</option>
                                    <option>Hydropower</option>
                                    <option>Building</option>
                                    <option>Road/Bridge</option>
                                    <option>Other</option>
                                </select>
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
