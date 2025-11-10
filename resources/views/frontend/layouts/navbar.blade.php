@php
    $profile = Modules\Setting\Entities\CompanyProfile::first();
    $services = Modules\Service\Models\Service::with('type')->orderBy('created_at', 'desc')->get();

@endphp

<body>
    <!-- Back to Top Button -->
    <a href="#" class="back-to-top"><i class="fas fa-arrow-up"></i></a>

    <!-- Navigation -->

    <!-- Navbar -->
    <header>
        <!-- Top Navbar -->
        <nav id="top-nav" class="top-navbar fixed-top py-2">
            <div class="container d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center">
                    <a href="tel:+977-9764638130" class="text-white text-decoration-none me-4"><i
                            class="fas fa-phone me-2"></i>{{ $profile->company_phone }}</a>
                    <a href="mailto:gwallekpvt.ltd@gmail.com" class="text-white text-decoration-none"><i
                            class="fas fa-envelope me-2"></i>{{ $profile->company_email }}</a>
                </div>
                <div class="d-none d-lg-block">
                    <a href="{{ $profile->facebook }}" class="text-white me-3"><i class="fab fa-facebook-f"></i></a>
                    <a href="{{ $profile->twitter }}" class="text-white me-3"><i class="fab fa-twitter"></i></a>
                    <a href="{{ $profile->instagram }}" class="text-white"><i class="fab fa-instagram"></i></a>
                </div>
            </div>
        </nav>

        <!-- Main Navbar -->
        <nav id="main-nav" class="navbar navbar-expand-lg main-navbar fixed-top" style="top: 40px;">
            <div class="container">
                <a class="navbar-brand" href="/">
                    <img src="https://placehold.co/100x60/1C3E5D/FFFFFF?text=GNS" alt="GNS Logo">
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false"
                    aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNavDropdown">
                    <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="/">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('frontend.aboutus') }}">About Us</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="servicesDropdown" role="button"
                                aria-expanded="false">
                                Services
                            </a>
                            <!-- The data-bs-toggle and data-bs-target attributes have been removed for hover functionality -->
                            <div class="dropdown-menu mega-menu" aria-labelledby="servicesDropdown">
                                <div class="container">
                                    <div class="row">
                                        @foreach ($services as $service)
                                            <div class="col-lg-3 col-md-6 mb-3">
                                                <h6>{{ $service->name }}</h6>
                                                <ul class="list-group list-group-flush">
                                                    @foreach ($service->type as $types)
                                                        <li class="list-group-item"> <a
                                                                href="{{ route('frontend.details_service', $types->id) }}">{{ $types->name }}</a>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('frontend.project') }}">Projects</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('frontend.blog') }}">Blogs</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('frontend.contact') }}">Contact</a>
                        </li>
                    </ul>
                    <a href="#" class="btn btn-primary-custom ms-lg-3 mt-3 mt-lg-0 " data-bs-toggle="modal"
                        data-bs-target="#quoteModal">Get a Quote</a>
                </div>
            </div>
        </nav>
    </header>
