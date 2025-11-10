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

    <!-- Project Detail Section -->
    <section id="gns-project-detail-section" class="py-5 py-lg-6">
        <div class="container">
            <div class="row gns-animate-on-scroll">
                <div class="col-12">
                    <div class="gns-heading-box">
                        <h2><span>Our</span> Project</h2>
                        <span class="gns-b-line l-left"></span>
                    </div>
                </div>
            </div>
            <div class="row gns-animate-on-scroll">
                <div class="col-12">
                    <div class="gns-project-detail-card">
                        <figure>
                            <img src="{{ asset('upload/sites/' . $site->image) }}"
                                alt="40 MW Upper Chameliya Hydropower Project" class="img-fluid">
                        </figure>
                        <div class="gns-project-info gns-animate-on-scroll">
                            <h3 class="text-white">Project Description</h3>
                            <ul>
                                <li>
                                    <strong>Location:</strong> {{ $site->location }}
                                </li>
                                <li>
                                    <strong>Project Area:</strong> {{ $site->project_area }}
                                </li>
                                <li>
                                    <strong>Year Completed:</strong>
                                    {{ \Carbon\Carbon::parse($site->end_date)->format('Y') }} ({{ $site->progress_status }})
                                </li>
                                <li>
                                    <strong>Value:</strong> NPR {{ $site->amount }}
                                </li>
                                <li>
                                    <strong>Contract ID:</strong> {{ $site->contract_id }}
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mt-5 gns-animate-on-scroll">
                <div class="col-lg-7">
                    <div class="gns-box-title mb-4">
                        <h3>Project Overview</h3>
                    </div>
                    <div class="gns-text-content">
                        <p>
                            {!! $site->overview !!}
                        </p>
                    </div>
                </div>

                <div class="col-lg-5 mt-4 mt-lg-0 gns-animate-on-scroll">
                    <div class="gns-box-title mb-4">
                        <h3>Key Features</h3>
                    </div>
                    <div class="card border-0 shadow-sm">
                        <div class="card-body">
                            <ul class="list-unstyled">
                                <li class="mb-3 d-flex align-items-start">
                                    {!! $site->key_features !!}
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mt-5 gns-animate-on-scroll">
                <div class="col-lg-7">
                    <div class="row">
                        <div class="col-md-6 mb-4 mb-md-0">
                            <div class="gns-box-title mb-3">
                                <h4>Technical Specifications</h4>
                            </div>
                            <div class="gns-text-content">
                                <p>
                                    {!! $site->technical_specifications !!}
                                </p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="gns-box-title mb-3">
                                <h4>Environmental Impact</h4>
                            </div>
                            <div class="gns-text-content">
                                <p>
                                    {!! $site->environmental_impact !!}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-5 mt-4 mt-lg-0">
                    @php
                        $validImages = $site->images->filter(fn($image) => !empty($image->image));
                    @endphp

                    <ul class="gns-project-gallery gns-animate-on-scroll list-unstyled d-flex flex-wrap gap-2">
                        @forelse($validImages as $image)
                            @php
                                $imagePath = public_path('upload/sites/' . $image->image);
                                [$width, $height] = file_exists($imagePath) ? getimagesize($imagePath) : [null, null];
                            @endphp
                            <li class="col-6 col-md-6 col-lg-3 p-1">
                                <a href="{{ asset('upload/sites/' . $image->image) }}" class="glightbox"
                                    data-gallery="project-{{ $site->id }}"
                                    data-title="{{ $image->caption ?? 'Project Image' }}">
                                    <img src="{{ asset('upload/sites/' . $image->image) }}"
                                        alt="{{ $image->caption ?? 'Project Image' }}"
                                        class="img-fluid project-img rounded shadow-sm"
                                        @if ($width && $height) width="{{ $width }}" height="{{ $height }}" @endif
                                        loading="lazy" decoding="async">
                                </a>
                            </li>
                        @empty
                            <li class="text-danger">No images available for this site.</li>
                        @endforelse
                    </ul>
                </div>


            </div>
        </div>
    </section>

    <!-- Related Projects Section with Auto-scroll -->
    <section class="gns-related-projects">
        <div class="container">
            <div class="row gns-animate-on-scroll">
                <div class="col-12">
                    <div class="gns-heading-box">
                        <h2><span>Related</span> Projects</h2>
                        <span class="gns-b-line l-left"></span>
                    </div>
                </div>
            </div>
            <div class="row gns-animate-on-scroll">
                <div class="col-12">
                    <div class="gns-related-carousel" id="gnsRelatedCarousel">
                        @forelse($site->relatedProjects as $project)
                            <div class="gns-project-item">
                                <div class="gns-about-block">
                                    <figure>
                                        <img src="{{ asset('upload/site/related_projects/' . $project->image) }}"
                                            alt="Hotel Raddison Project" class="img-fluid">
                                    </figure>
                                    <div class="gns-text-box">
                                        <div class="gns-box-title">
                                            <h3><a href="#">{{ $project->name }}</a></h3>
                                        </div>
                                        <div class="gns-text-content">
                                            <p>
                                                {!! $project->description !!}
                                            </p>
                                            {{-- <a href="#" class="gns-btn-text">Read More</a> --}}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <li class="text-danger">No Related Project.</li>
                        @endforelse
                        {{-- <div class="gns-project-item">
                            <div class="gns-about-block">
                                <figure>
                                    <img src="https://images.unsplash.com/photo-1600880292203-757bb62b4baf?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80"
                                        alt="Aadhar Trade Mall" class="img-fluid">
                                </figure>
                                <div class="gns-text-box">
                                    <div class="gns-box-title">
                                        <h3><a href="#">Aadhar Trade Mall, Balkhu</a></h3>
                                    </div>
                                    <div class="gns-text-content">
                                        <p>
                                            Development of a modern commercial complex with retail spaces, offices, and
                                            entertainment facilities in Balkhu.
                                        </p>
                                        <a href="#" class="gns-btn-text">Read More</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="gns-project-item">
                            <div class="gns-about-block">
                                <figure>
                                    <img src="/images/494756923_122127245048771242_4737378166829855890_n.jpg"
                                        class="img-fluid">
                                </figure>
                                <div class="gns-text-box">
                                    <div class="gns-box-title">
                                        <h3><a href="#">District Hospital Baitadi</a></h3>
                                    </div>
                                    <div class="gns-text-content">
                                        <p>
                                            Construction of a 50-bed district hospital with modern medical facilities and
                                            infrastructure in Baitadi.
                                        </p>
                                        <a href="#" class="gns-btn-text">Read More</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="gns-project-item">
                            <div class="gns-about-block">
                                <figure>
                                    <img src="https://images.unsplash.com/photo-1605152276897-4f618f831968?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80"
                                        alt="Hydropower Project" class="img-fluid">
                                </figure>
                                <div class="gns-text-box">
                                    <div class="gns-box-title">
                                        <h3><a href="#">Jurimba Hydropower Project</a></h3>
                                    </div>
                                    <div class="gns-text-content">
                                        <p>
                                            7 MW hydropower project in Sindhupalchowk with modern turbine technology and
                                            minimal environmental impact.
                                        </p>
                                        <a href="#" class="gns-btn-text">Read More</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="gns-project-item">
                            <div class="gns-about-block">
                                <figure>
                                    <img src="https://images.unsplash.com/photo-1604998103924-89e012e5265a?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80"
                                        alt="Road Project" class="img-fluid">
                                </figure>
                                <div class="gns-text-box">
                                    <div class="gns-box-title">
                                        <h3><a href="#">Khalanga-Dellekh Road</a></h3>
                                    </div>
                                    <div class="gns-text-content">
                                        <p>
                                            Construction and upgrading of Khalanga-Khar-Dethala-Paribagar Road in Darchula
                                            district.
                                        </p>
                                        <a href="#" class="gns-btn-text">Read More</a>
                                    </div>
                                </div>
                            </div>
                        </div> --}}
                    </div>
                    <div class="gns-carousel-nav" id="gnsCarouselDots">
                        <!-- Dots will be added by JavaScript -->
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonial Section -->
    <section class="gns-project-testimonial py-5 bg-light">
        <div class="container">
            <div class="row justify-content-center gns-animate-on-scroll">
                <div class="col-lg-8">
                    <div class="gns-box-title text-center mb-5">
                        <h3>Client Testimonial</h3>
                    </div>
                    <div class="gns-project-testimonial-card card border-0 shadow-sm">
                        <div class="card-body p-4 p-lg-5">
                            <div class="d-flex align-items-center mb-4">
                                <img src="https://randomuser.me/api/portraits/men/65.jpg" alt="Client"
                                    class="gns-testimonial-avatar rounded-circle me-4">
                                <div>
                                    <h5 class="mb-1">Rajesh Sharma</h5>
                                    <p class="text-muted mb-0">Project Director, DWSSM</p>
                                </div>
                            </div>
                            <div class="gns-testimonial-content">
                                <div class="gns-testimonial-quote mb-3">
                                    <i class="fas fa-quote-left text-secondary"></i>
                                </div>
                                <p class="gns-testimonial-text fs-5">
                                    "Gwallek Nirman Sewa has demonstrated exceptional professionalism in executing the
                                    Middle Chameliyya Hydropower Project. Their technical expertise in challenging terrain
                                    and commitment to quality standards has been impressive. Despite difficult working
                                    conditions in Darchula, they've maintained excellent progress while ensuring safety and
                                    environmental compliance."
                                </p>
                                <div class="gns-rating mt-3">
                                    <i class="fas fa-star text-warning"></i>
                                    <i class="fas fa-star text-warning"></i>
                                    <i class="fas fa-star text-warning"></i>
                                    <i class="fas fa-star text-warning"></i>
                                    <i class="fas fa-star text-warning"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script>
        // Animation on scroll
        document.addEventListener("DOMContentLoaded", function() {
            const timelineItems = document.querySelectorAll(
                ".sc-animate-on-scroll"
            );

            const animateOnScroll = function() {
                timelineItems.forEach((item) => {
                    const itemPosition = item.getBoundingClientRect().top;
                    const screenPosition = window.innerHeight / 1.3;

                    if (itemPosition < screenPosition) {
                        const delay = item.dataset.scDelay || 0;
                        setTimeout(() => {
                            item.classList.add("sc-animated");
                        }, delay * 1000);
                    }
                });
            };

            // Initial check
            animateOnScroll();

            // Check on scroll
            window.addEventListener("scroll", animateOnScroll);

            // Timeline progress animation
            const timelineProgress = document.querySelector(
                ".sc-timeline-progress"
            );
            const timelineSection = document.querySelector(".sc-timeline-section");

            const updateProgress = function() {
                const sectionPosition = timelineSection.getBoundingClientRect();
                const sectionHeight = timelineSection.offsetHeight;
                const scrollPosition = window.scrollY;
                const sectionTop = sectionPosition.top + window.scrollY;

                if (
                    scrollPosition > sectionTop - window.innerHeight &&
                    scrollPosition < sectionTop + sectionHeight
                ) {
                    const progress =
                        ((scrollPosition - sectionTop + window.innerHeight) /
                            sectionHeight) *
                        100;
                    timelineProgress.style.height =
                        Math.min(100, Math.max(0, progress)) + "%";
                }
            };

            window.addEventListener("scroll", updateProgress);
            window.addEventListener("resize", updateProgress);
        });
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const track = document.querySelector(
                ".gns-testimonial .carousel-track"
            );
            const cards = document.querySelectorAll(
                ".gns-testimonial .testimonial-card"
            );
            const nextBtn = document.querySelector(".gns-testimonial .next");
            const prevBtn = document.querySelector(".gns-testimonial .prev");

            let cardWidth = cards[0].offsetWidth + 30; // width + margin
            let currentPosition = 0;
            let autoScrollInterval;

            // Clone first few cards and append to end for infinite loop
            const firstCards = Array.from(cards).slice(0, 3);
            firstCards.forEach((card) => {
                const clone = card.cloneNode(true);
                track.appendChild(clone);
            });

            // Set total width of track
            const totalCards = document.querySelectorAll(
                ".gns-testimonial .testimonial-card"
            ).length;
            track.style.width = `${totalCards * cardWidth}px`;

            // Auto-scroll function
            function autoScroll() {
                currentPosition -= cardWidth;
                if (currentPosition <= -((totalCards - 3) * cardWidth)) {
                    // If we've scrolled to the clones, jump back to start without animation
                    track.style.transition = "none";
                    currentPosition = 0;
                    track.style.transform = `translateX(${currentPosition}px)`;
                    // Force reflow
                    track.offsetHeight;
                    // Restore transition
                    track.style.transition = "transform 0.5s ease";
                }
                track.style.transform = `translateX(${currentPosition}px)`;
            }

            // Start auto-scrolling
            function startAutoScroll() {
                autoScrollInterval = setInterval(autoScroll, 3000);
            }

            // Stop auto-scrolling when hovering
            function stopAutoScroll() {
                clearInterval(autoScrollInterval);
            }

            // Next button click
            nextBtn.addEventListener("click", function() {
                stopAutoScroll();
                currentPosition -= cardWidth * 3; // Move 3 cards at a time

                if (currentPosition <= -((totalCards - 3) * cardWidth)) {
                    // If we've scrolled to the clones, jump back to start without animation
                    track.style.transition = "none";
                    currentPosition = 0;
                    track.style.transform = `translateX(${currentPosition}px)`;
                    // Force reflow
                    track.offsetHeight;
                    // Restore transition
                    track.style.transition = "transform 0.5s ease";
                }

                track.style.transform = `translateX(${currentPosition}px)`;
                startAutoScroll();
            });

            // Previous button click
            prevBtn.addEventListener("click", function() {
                stopAutoScroll();
                currentPosition += cardWidth * 3; // Move 3 cards at a time

                if (currentPosition > 0) {
                    // If we're at the start, jump to the clones at the end
                    track.style.transition = "none";
                    currentPosition = -((totalCards - 6) * cardWidth);
                    track.style.transform = `translateX(${currentPosition}px)`;
                    // Force reflow
                    track.offsetHeight;
                    // Restore transition
                    track.style.transition = "transform 0.5s ease";
                }

                track.style.transform = `translateX(${currentPosition}px)`;
                startAutoScroll();
            });

            // Pause on hover
            track.addEventListener("mouseenter", stopAutoScroll);
            track.addEventListener("mouseleave", startAutoScroll);

            // Initialize auto-scroll
            startAutoScroll();

            // Animate cards on load
            setTimeout(() => {
                cards.forEach((card, index) => {
                    card.style.animationDelay = `${index * 0.1}s`;
                });
            }, 100);
        });
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const topNav = document.getElementById("top-nav");
            const mainNav = document.getElementById("main-nav");
            let lastScrollY = window.scrollY;

            window.addEventListener("scroll", () => {
                if (window.scrollY > lastScrollY) {
                    // Scrolling down
                    topNav.classList.add("hidden");
                    mainNav.style.top = "0";
                } else {
                    // Scrolling up
                    topNav.classList.remove("hidden");
                    mainNav.style.top = "40px";
                }
                lastScrollY = window.scrollY;
            });
        });
    </script>

    <!-- Fancybox JS -->
    <script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.umd.js"></script>
    <script>
        // Initialize Fancybox
        Fancybox.bind("[data-fancybox]", {
            // Your custom options
        });

        // Animation on scroll
        document.addEventListener("DOMContentLoaded", function() {
            const animateElements = document.querySelectorAll(
                ".gns-animate-on-scroll"
            );

            const animateOnScroll = function() {
                animateElements.forEach((element) => {
                    const elementPosition = element.getBoundingClientRect().top;
                    const windowHeight = window.innerHeight;

                    if (elementPosition < windowHeight - 100) {
                        element.classList.add("animated");
                    }
                });
            };

            // Initial check
            animateOnScroll();

            // Check on scroll
            window.addEventListener("scroll", animateOnScroll);

            // Auto-scrolling related projects carousel
            const carousel = document.getElementById("gnsRelatedCarousel");
            const dotsContainer = document.getElementById("gnsCarouselDots");
            const projects = document.querySelectorAll(".gns-project-item");
            const projectWidth = projects[0].offsetWidth + 30; // width + gap
            let currentIndex = 0;
            let autoScrollInterval;

            // Create dots
            projects.forEach((_, index) => {
                const dot = document.createElement("div");
                dot.className = "gns-carousel-dot";
                if (index === 0) dot.classList.add("active");
                dot.addEventListener("click", () => {
                    goToProject(index);
                });
                dotsContainer.appendChild(dot);
            });

            // Function to go to specific project
            function goToProject(index) {
                currentIndex = index;
                carousel.scrollTo({
                    left: index * projectWidth,
                    behavior: "smooth",
                });
                updateDots();
            }

            // Update active dot
            function updateDots() {
                document
                    .querySelectorAll(".gns-carousel-dot")
                    .forEach((dot, index) => {
                        dot.classList.toggle("active", index === currentIndex);
                    });
            }

            // Auto-scroll function
            function autoScroll() {
                currentIndex = (currentIndex + 1) % projects.length;
                goToProject(currentIndex);
            }

            // Start auto-scrolling
            function startAutoScroll() {
                autoScrollInterval = setInterval(autoScroll, 5000);
            }

            // Pause auto-scrolling on hover
            carousel.addEventListener("mouseenter", () => {
                clearInterval(autoScrollInterval);
            });

            // Resume auto-scrolling when mouse leaves
            carousel.addEventListener("mouseleave", startAutoScroll);

            // Handle scroll events to update dots
            carousel.addEventListener("scroll", () => {
                const scrollPos = carousel.scrollLeft;
                currentIndex = Math.round(scrollPos / projectWidth);
                updateDots();
            });

            // Initialize
            startAutoScroll();
        });
    </script>
@endsection
