
<!-- Footer -->
<footer class="text-white-50">
    <div class="container">
        <div class="row g-5">
            <!-- Company Info Section -->
            <div class="col-lg-4 col-md-12">
                <div class="d-flex flex-column align-items-md-start align-items-center">
                    <img src="https://placehold.co/180x60/3e4c62/ffffff?text=GNS+Logo"
                        alt="Gwallek Nirman Sewa Logo" class="footer-logo mb-4">
                    <p class="text-center text-md-start">Gwallek Nirman Sewa Pvt. Ltd. has been one of Nepal's leading
                        construction companies since 1999, committed to excellence and national development.</p>
                    <div class="social-icons-footer mt-4">
                        <a href="#"><i class="fab fa-facebook-f"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                        <a href="#"><i class="fab fa-linkedin-in"></i></a>
                        <a href="#"><i class="fab fa-instagram"></i></a>
                    </div>
                </div>
            </div>

            <!-- Quick Links Section -->
            <div class="col-lg-2 col-md-6">
                <div class="footer-links">
                    <h5>Quick Links</h5>
                    <ul class="d-flex flex-column align-items-center align-items-md-start">
                        <li><a href="#home">Home</a></li>
                        <li><a href="#about">About Us</a></li>
                        <li><a href="#services">Services</a></li>
                        <li><a href="#projects">Projects</a></li>
                    </ul>
                </div>
            </div>

            <!-- Services Section -->
            <div class="col-lg-3 col-md-6">
                <div class="footer-links">
                    <h5>Our Services</h5>
                    <ul class="d-flex flex-column align-items-center align-items-md-start">
                        <li><a href="#">Hydropower Projects</a></li>
                        <li><a href="#">Road & Bridge Projects</a></li>
                        <li><a href="#">Building Development</a></li>
                        <li><a href="#">Water Supply & Sanitation</a></li>
                        <li><a href="#">Irrigation Projects</a></li>
                        <li><a href="#">River Training Projects</a></li>
                    </ul>
                </div>
            </div>

            <!-- Contact Info Section -->
            <div class="col-lg-3 col-md-12">
                <div class="footer-contact">
                    <h5>Contact Info</h5>
                    <p><i class="icon fas fa-map-marker-alt"></i> Jawlakhel, Lalitpur, Nepal</p>
                    <p><i class="icon fas fa-phone-alt"></i> +977-9764638130</p>
                    <p><i class="icon fas fa-envelope"></i> gwallekpvt.ltd@gmail.com</p>
                    <p class="mt-4 text-center text-md-start">Our business hours are Monday to Friday, 9:00 AM to 5:00
                        PM. Feel free to contact us with any inquiries during this time.</p>

                </div>
            </div>
        </div>

        <!-- Copyright Section -->
        <div class="row">
            <div class="col-12 text-center copyright">
                <p class="mb-0">&copy; 2025 Gwallek Nirman Sewa Pvt. Ltd. All Rights Reserved.</p>
            </div>
        </div>
    </div>
</footer>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Owl Carousel JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
<!-- Add these scripts before your closing body tag -->
<script>
    $(document).ready(function() {
        $('.testimonial-owlCarousel-gwallek').owlCarousel({
            loop: true,
            margin: 10,
            dots: false,
            nav: true,
            autoplay: true, // Auto-scrolling enabled
            smartSpeed: 3000,
            autoplayTimeout: 4000,
            responsive: {
                0: {
                    items: 1,
                    nav: true
                },
                600: {
                    items: 1,
                    nav: true
                },
                1000: {
                    items: 1,
                    nav: true
                }
            }
        });
    });
</script>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<!-- jQuery -->

<script src="{{ asset('frontend/js/script.js') }}"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize equipment card animations
        const equipmentCards = document.querySelectorAll('.equipment-card');

        // Animate numbers counting up
        function animateNumbers() {
            const statNumbers = document.querySelectorAll('.stat-number');
            statNumbers.forEach(number => {
                const target = parseInt(number.getAttribute('data-count'));
                const duration = 2000;
                const start = 0;
                const increment = target / (duration / 16);

                let current = start;
                const timer = setInterval(() => {
                    current += increment;
                    if (current >= target) {
                        clearInterval(timer);
                        current = target;
                    }
                    number.textContent = Math.floor(current);
                }, 16);
            });
        }

        // Toggle details visibility
        equipmentCards.forEach(card => {
            const btn = card.querySelector('.btn-details');
            btn.addEventListener('click', function() {
                card.classList.toggle('active');
            });
        });

        // Intersection Observer for scroll animations
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const delay = entry.target.getAttribute('data-delay') || 0;
                    const animation = entry.target.getAttribute('data-animation') || 'fadeInUp';

                    setTimeout(() => {
                        entry.target.classList.add('animated', animation);

                        // Only animate numbers once when first card comes into view
                        if (entry.target === document.querySelector(
                                '.animate-on-scroll')) {
                            animateNumbers();
                        }
                    }, delay * 1000);
                }
            });
        }, {
            threshold: 0.1
        });

        document.querySelectorAll('.animate-on-scroll').forEach(el => observer.observe(el));
    });
</script>

<script>
    // Animation on scroll
    document.addEventListener('DOMContentLoaded', function() {
        const timelineItems = document.querySelectorAll('.sc-animate-on-scroll');

        const animateOnScroll = function() {
            timelineItems.forEach(item => {
                const itemPosition = item.getBoundingClientRect().top;
                const screenPosition = window.innerHeight / 1.3;

                if (itemPosition < screenPosition) {
                    const delay = item.dataset.scDelay || 0;
                    setTimeout(() => {
                        item.classList.add('sc-animated');
                    }, delay * 1000);
                }
            });
        };

        // Initial check
        animateOnScroll();

        // Check on scroll
        window.addEventListener('scroll', animateOnScroll);

        // Timeline progress animation
        const timelineProgress = document.querySelector('.sc-timeline-progress');
        const timelineSection = document.querySelector('.sc-timeline-section');

        const updateProgress = function() {
            const sectionPosition = timelineSection.getBoundingClientRect();
            const sectionHeight = timelineSection.offsetHeight;
            const scrollPosition = window.scrollY;
            const sectionTop = sectionPosition.top + window.scrollY;

            if (scrollPosition > sectionTop - window.innerHeight && scrollPosition < sectionTop +
                sectionHeight) {
                const progress = (scrollPosition - sectionTop + window.innerHeight) / sectionHeight * 100;
                timelineProgress.style.height = Math.min(100, Math.max(0, progress)) + '%';
            }
        };

        window.addEventListener('scroll', updateProgress);
        window.addEventListener('resize', updateProgress);
    });
</script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const track = document.querySelector('.gns-testimonial .carousel-track');
        const cards = document.querySelectorAll('.gns-testimonial .testimonial-card');
        const nextBtn = document.querySelector('.gns-testimonial .next');
        const prevBtn = document.querySelector('.gns-testimonial .prev');

        let cardWidth = cards[0].offsetWidth + 30; // width + margin
        let currentPosition = 0;
        let autoScrollInterval;

        // Clone first few cards and append to end for infinite loop
        const firstCards = Array.from(cards).slice(0, 3);
        firstCards.forEach(card => {
            const clone = card.cloneNode(true);
            track.appendChild(clone);
        });

        // Set total width of track
        const totalCards = document.querySelectorAll('.gns-testimonial .testimonial-card').length;
        track.style.width = `${totalCards * cardWidth}px`;

        // Auto-scroll function
        function autoScroll() {
            currentPosition -= cardWidth;
            if (currentPosition <= -((totalCards - 3) * cardWidth)) {
                // If we've scrolled to the clones, jump back to start without animation
                track.style.transition = 'none';
                currentPosition = 0;
                track.style.transform = `translateX(${currentPosition}px)`;
                // Force reflow
                track.offsetHeight;
                // Restore transition
                track.style.transition = 'transform 0.5s ease';
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
        nextBtn.addEventListener('click', function() {
            stopAutoScroll();
            currentPosition -= cardWidth * 3; // Move 3 cards at a time

            if (currentPosition <= -((totalCards - 3) * cardWidth)) {
                // If we've scrolled to the clones, jump back to start without animation
                track.style.transition = 'none';
                currentPosition = 0;
                track.style.transform = `translateX(${currentPosition}px)`;
                // Force reflow
                track.offsetHeight;
                // Restore transition
                track.style.transition = 'transform 0.5s ease';
            }

            track.style.transform = `translateX(${currentPosition}px)`;
            startAutoScroll();
        });

        // Previous button click
        prevBtn.addEventListener('click', function() {
            stopAutoScroll();
            currentPosition += cardWidth * 3; // Move 3 cards at a time

            if (currentPosition > 0) {
                // If we're at the start, jump to the clones at the end
                track.style.transition = 'none';
                currentPosition = -((totalCards - 6) * cardWidth);
                track.style.transform = `translateX(${currentPosition}px)`;
                // Force reflow
                track.offsetHeight;
                // Restore transition
                track.style.transition = 'transform 0.5s ease';
            }

            track.style.transform = `translateX(${currentPosition}px)`;
            startAutoScroll();
        });

        // Pause on hover
        track.addEventListener('mouseenter', stopAutoScroll);
        track.addEventListener('mouseleave', startAutoScroll);

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
    document.addEventListener('DOMContentLoaded', function() {
        const topNav = document.getElementById('top-nav');
        const mainNav = document.getElementById('main-nav');
        let lastScrollY = window.scrollY;

        window.addEventListener('scroll', () => {
            if (window.scrollY > lastScrollY) {
                // Scrolling down
                topNav.classList.add('hidden');
                mainNav.style.top = '0';
            } else {
                // Scrolling up
                topNav.classList.remove('hidden');
                mainNav.style.top = '40px';
            }
            lastScrollY = window.scrollY;
        });
    });
</script>

<script>
    // Self-invoking function to prevent global scope pollution
    (() => {
        'use strict'

        // Fetch the form we want to apply custom Bootstrap validation styles to
        const form = document.getElementById('contactForm');
        const successMessage = document.getElementById('success-message');

        form.addEventListener('submit', event => {
            // Prevent default form submission
            event.preventDefault();
            event.stopPropagation();

            if (form.checkValidity()) {
                // If form is valid, show success message
                successMessage.style.display = 'block';
                form.style.display = 'none'; // Hide the form

                // Optional: Reset form after a few seconds
                setTimeout(() => {
                    successMessage.style.display = 'none';
                    form.style.display = 'block';
                    form.classList.remove('was-validated');
                    form.reset();
                }, 6000);

            } else {
                // If form is invalid, add Bootstrap's validation class
                form.classList.add('was-validated');
            }
        }, false);
    })();
</script>


<script>
    // Add this to your existing JavaScript
    document.addEventListener('DOMContentLoaded', function() {
        // ... your existing animation code ...

        // Auto-scrolling blog carousel
        const blogCarousel = document.getElementById('gnsBlogCarousel');
        const dotsContainer = document.getElementById('gnsBlogDots');
        const blogCards = document.querySelectorAll('.gns-blog-card');
        const prevBtn = document.querySelector('.gns-prev-btn');
        const nextBtn = document.querySelector('.gns-next-btn');

        const cardWidth = blogCards[0].offsetWidth + 30; // width + gap
        let currentIndex = 0;
        let autoScrollInterval;

        // Create dots
        blogCards.forEach((_, index) => {
            const dot = document.createElement('div');
            dot.className = 'gns-carousel-dot';
            if (index === 0) dot.classList.add('active');
            dot.addEventListener('click', () => {
                goToCard(index);
            });
            dotsContainer.appendChild(dot);
        });

        // Function to go to specific card
        function goToCard(index) {
            currentIndex = index;
            blogCarousel.scrollTo({
                left: index * cardWidth,
                behavior: 'smooth'
            });
            updateDots();
        }

        // Update active dot
        function updateDots() {
            document.querySelectorAll('.gns-carousel-dot').forEach((dot, index) => {
                dot.classList.toggle('active', index === currentIndex);
            });
        }

        // Auto-scroll function
        function autoScroll() {
            currentIndex = (currentIndex + 1) % blogCards.length;
            goToCard(currentIndex);
        }

        // Start auto-scrolling
        function startAutoScroll() {
            autoScrollInterval = setInterval(autoScroll, 5000);
        }

        // Navigation buttons
        prevBtn.addEventListener('click', () => {
            currentIndex = (currentIndex - 1 + blogCards.length) % blogCards.length;
            goToCard(currentIndex);
            resetAutoScroll();
        });

        nextBtn.addEventListener('click', () => {
            currentIndex = (currentIndex + 1) % blogCards.length;
            goToCard(currentIndex);
            resetAutoScroll();
        });

        // Reset auto-scroll timer on interaction
        function resetAutoScroll() {
            clearInterval(autoScrollInterval);
            startAutoScroll();
        }

        // Handle scroll events to update dots
        blogCarousel.addEventListener('scroll', () => {
            const scrollPos = blogCarousel.scrollLeft;
            currentIndex = Math.round(scrollPos / cardWidth);
            updateDots();
        });

        // Initialize
        startAutoScroll();
    });
</script>


<script>
    window.addEventListener('load', function() {
        setTimeout(function() {
            document.querySelector('#overview').scrollIntoView({
                behavior: 'smooth'
            });
        }, 2000);
    });

    window.addEventListener('scroll', function() {
        document.querySelectorAll('.gws-fade').forEach(function(el) {
            if (el.getBoundingClientRect().top < window.innerHeight - 100) {
                el.classList.add('visible');
            }
        });
    });
</script>


<script>
    document.addEventListener('DOMContentLoaded', function() {
        const filterButtons = document.querySelectorAll('.project-filters .nav-link');
        const projectItems = document.querySelectorAll('.project-item');

        // Function to filter projects
        function filterProjects(filter) {
            projectItems.forEach(item => {
                const categories = item.getAttribute('data-category');

                if (filter === 'all') {
                    item.style.display = 'block';
                } else {
                    // Check if the item has the filter category
                    if (categories.includes(filter)) {
                        item.style.display = 'block';
                    } else {
                        item.style.display = 'none';
                    }
                }

                // Add animation
                setTimeout(() => {
                    item.style.opacity = item.style.display === 'block' ? '1' : '0';
                }, 50);
            });
        }

        // Set up button click handlers
        filterButtons.forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();

                // Remove active class from all buttons
                filterButtons.forEach(btn => btn.classList.remove('active'));

                // Add active class to clicked button
                this.classList.add('active');

                // Get filter value
                const filter = this.getAttribute('data-bs-target').replace('#', '');

                // Apply filter
                filterProjects(filter);
            });
        });

        // Initialize with all projects shown
        filterProjects('all');
    });
</script>


<script>
    document.getElementById('quoteForm').addEventListener('submit', function(e) {
        e.preventDefault();
        // Add form submission logic here (AJAX or form action)
        alert('Thank you! We will contact you shortly.');
        var modal = bootstrap.Modal.getInstance(document.getElementById('quoteModal'));
        modal.hide();
    });
</script>

</body>

</html>
