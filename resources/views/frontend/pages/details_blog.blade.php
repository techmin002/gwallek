@extends('frontend.layouts.master')
@section('title', 'Gwallek Nirman Sewa')
<script type='text/javascript'
    src='https://platform-api.sharethis.com/js/sharethis.js#property=68c7ba596bd80d4bd2a04da2&product=sop'
    async='async'></script>
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
            <h1 class="py-5 mt-5">Our Blogs</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb justify-content-center mb-0">
                    <li class="breadcrumb-item"><a href="/"><i class="bi bi-house-door-fill"></i> Home</a></li>
                    <!-- <li class="breadcrumb-item"><a href="#"><i class="bi bi-gear-fill"></i> About Us</a></li> -->
                    <li class="breadcrumb-item active" aria-current="page"><i class="bi bi-code-slash"></i>Our Blogs</li>
                </ol>
            </nav>
        </div>
    </section>

    <!-- detail blog section start  -->

    <!-- Blog Detail Section -->
    <section class="py-5 py-lg-6">
        <div class="container">
            <div class="row g-4">
                <!-- Main Content -->
                <div class="col-lg-9">
                    <article class="gns-blog-main">
                        <!-- Blog Meta -->
                        <div class="gns-blog-meta">
                            <span><i class="fas fa-user"></i> by <a href="#">Admin</a></span>
                            <span><i class="fas fa-comment"></i> <a href="#">25 Comments</a></span>
                            <span><i class="fas fa-heart"></i> <a href="#">57 Likes</a></span>
                            <div class="gns-social-share ms-auto">
                                <!-- ShareThis BEGIN -->
                                <div class="sharethis-inline-share-buttons"></div><!-- ShareThis END -->
                            </div>
                        </div>

                        <!-- Blog Title -->
                        <h1 class="gns-blog-title1">{{ $blogs->title }}</h1>
                        <!-- Featured Image -->
                        <div class="gns-blog-image">
                            <img src="{{ asset('upload/images/blogs/' . $blogs->image) }}" alt="Hydropower Construction">
                            <div class="gns-blog-date">
                                <span>21</span> June
                            </div>
                        </div>

                        <!-- Blog Content -->
                        <div class="gns-blog-content">
                            {!! $blogs->description !!}
                        </div>

                        <!-- Tags -->
                        <div class="gns-blog-tags">
                            <i class="fas fa-tags"></i>
                            <a href="#" class="badge bg-secondary text-white me-2">Hydropower</a>
                            <a href="#" class="badge bg-secondary text-white me-2">Construction</a>
                            <a href="#" class="badge bg-secondary text-white">Innovation</a>
                        </div>
                    </article>

                    {{-- <!-- Author Bio -->
                    <div class="gns-blog-author">
                        <div class="gns-author-img">
                            <img src="https://randomuser.me/api/portraits/men/32.jpg" alt="Author">
                        </div>
                        <div class="gns-author-info">
                            <h5>Suresh Chand</h5>
                            <p>Mr. Chand is the Managing Director of Gwallek Nirman Sewa Pvt. Ltd. With over 20 years of
                                experience in civil engineering and construction management, he has led numerous hydropower
                                and infrastructure projects across Nepal.</p>
                        </div>
                    </div> --}}

                    <!-- Comments Section -->
                    <div class="gns-comments-section">
                        <h3 class="gns-comment-title">Comments ({{ $total }})</h3>
                        <ul class="gns-comment-list">
                            @foreach ($comments as $comment)
                                @if ($comment->status === 'accept')
                                    <li class="gns-comment-item">
                                        <div class="gns-comment-avatar">
                                            <!-- Generic user icon -->
                                            <i class="fas fa-user fa-2x"></i>
                                        </div>
                                        <div class="gns-comment-content">
                                            <div class="gns-comment-meta">
                                                <h6>{{ $comment->name }}</h6>
                                                <span
                                                    class="gns-comment-date">{{ $comment->created_at->format('F d, Y') }}</span>
                                            </div>
                                            <p>{{ $comment->comment }}</p>
                                        </div>
                                    </li>
                                @endif
                            @endforeach
                        </ul>

                    </div>

                    <!-- Comment Form -->
                    <div class="gns-comment-form">
                        <h4>Leave a Comment</h4>
                        <form action="{{ route('blogscomment.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="blog_id" value="{{ $blogs->id }}">
                            <!-- Pass current blog ID -->
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <input type="text" name="name" class="gns-form-control"
                                        placeholder="Your Name" required>
                                </div>
                                <div class="col-md-4">
                                    <input type="email" name="email" class="gns-form-control"
                                        placeholder="Your Email" required>
                                </div>
                                <div class="col-md-4">
                                    <input type="text" name="website" class="gns-form-control"
                                        placeholder="Your Website">
                                </div>
                                <div class="col-12">
                                    <textarea name="comment" class="gns-form-control gns-form-textarea" placeholder="Your Comment" required></textarea>
                                </div>
                                <div class="col-12">
                                    <button type="submit" class="gns-submit-btn">Post Comment</button>
                                </div>
                            </div>
                        </form>

                    </div>

                    <!-- Navigation -->
                    <div class="gns-blog-navigation">
                        <a href="{{ route('frontend.blog') }}" class="gns-nav-btn gns-prev-btn">
                            <i class="fas fa-arrow-left"></i> Previous Post
                        </a>
                        <a href="#" class="gns-nav-btn gns-next-btn">
                            Next Post <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="col-lg-3">
                    <!-- Search Widget -->
                    <div class="gns-sidebar-widget">
                        <h5 class="gns-widget-title">Search</h5>
                        <form class="gns-search-form">
                            <input type="text" class="gns-search-input" placeholder="Search...">
                            <button type="submit" class="gns-search-btn">
                                <i class="fas fa-search"></i>
                            </button>
                        </form>
                    </div>

                    <!-- Categories Widget -->
                    <div class="gns-sidebar-widget">
                        <h5 class="gns-widget-title">Categories</h5>
                        <ul class="gns-categories-list">
                            <li><a href="#">Hydropower Projects</a></li>
                            <li><a href="#">Road Construction</a></li>
                            <li><a href="#">Building Development</a></li>
                            <li><a href="#">Bridge Engineering</a></li>
                            <li><a href="#">Water Supply</a></li>
                            <li><a href="#">Company News</a></li>
                        </ul>
                    </div>

                    <!-- Recent Posts Widget -->
                    <div class="gns-sidebar-widget">
                        <h5 class="gns-widget-title">Recent Posts</h5>
                        <div class="gns-recent-post">
                            <div class="gns-recent-img">
                                <img src="https://images.unsplash.com/photo-1604998103924-89e012e5265a?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80"
                                    alt="Recent Post">
                            </div>
                            <div>
                                <h6 class="gns-recent-title"><a href="#">Modern Road Construction Techniques</a>
                                </h6>
                                <div class="gns-recent-meta">
                                    <span><i class="fas fa-calendar"></i> June 15, 2023</span>
                                </div>
                            </div>
                        </div>
                        <div class="gns-recent-post">
                            <div class="gns-recent-img">
                                <img src="https://images.unsplash.com/photo-1581093450021-4a7360e9a7d0?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80"
                                    alt="Recent Post">
                            </div>
                            <div>
                                <h6 class="gns-recent-title"><a href="#">Healthcare Infrastructure Development</a>
                                </h6>
                                <div class="gns-recent-meta">
                                    <span><i class="fas fa-calendar"></i> June 5, 2023</span>
                                </div>
                            </div>
                        </div>
                        <div class="gns-recent-post">
                            <div class="gns-recent-img">
                                <img src="https://images.unsplash.com/photo-1600585154340-be6161a56a0c?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80"
                                    alt="Recent Post">
                            </div>
                            <div>
                                <h6 class="gns-recent-title"><a href="#">Hotel Raddison Construction Update</a></h6>
                                <div class="gns-recent-meta">
                                    <span><i class="fas fa-calendar"></i> May 28, 2023</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tags Widget -->
                    <div class="gns-sidebar-widget">
                        <h5 class="gns-widget-title">Popular Tags</h5>
                        <div class="gns-tag-cloud">
                            <a href="#">Construction</a>
                            <a href="#">Engineering</a>
                            <a href="#">Infrastructure</a>
                            <a href="#">Nepal</a>
                            <a href="#">Development</a>
                            <a href="#">Technology</a>
                            <a href="#">Sustainability</a>
                            <a href="#">Design</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
