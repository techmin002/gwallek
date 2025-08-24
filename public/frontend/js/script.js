
        // timeline js 
        document.addEventListener('DOMContentLoaded', function() {
    // Initialize timeline animation
    const timelineItems = document.querySelectorAll('.timeline-item');
    const timelineProgress = document.querySelector('.timeline-progress');
    const timelineDot = document.querySelector('.timeline-dot');
    
    function animateTimeline() {
        let totalHeight = document.querySelector('.modern-timeline-v2').offsetHeight;
        let scrollPosition = window.scrollY;
        let timelineOffset = document.querySelector('.modern-timeline-v2').offsetTop;
        let timelineHeight = totalHeight;
        let scrollPercent = (scrollPosition - timelineOffset) / timelineHeight;
        
        scrollPercent = Math.min(Math.max(scrollPercent, 0), 1);
        
        // Animate progress bar
        timelineProgress.style.height = (scrollPercent * 100) + '%';
        
        // Animate dot position
        timelineDot.style.top = (scrollPercent * 100) + '%';
        
        // Animate items
        timelineItems.forEach((item, index) => {
            let itemOffset = item.offsetTop;
            let itemScrollPercent = (scrollPosition - itemOffset + 300) / window.innerHeight;
            
            if (itemScrollPercent > 0.2) {
                item.classList.add('animated');
            }
        });
    }
    
    // Initial animation
    animateTimeline();
    
    // Animate on scroll
    window.addEventListener('scroll', animateTimeline);
    
    // Trigger animations when elements come into view
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const delay = entry.target.getAttribute('data-delay') || 0;
                setTimeout(() => {
                    entry.target.classList.add('animated');
                }, delay * 1000);
            }
        });
    }, { threshold: 0.1 });
    
    timelineItems.forEach(item => observer.observe(item));
});
// script.js

// Wait until DOM is loaded
document.addEventListener('DOMContentLoaded', function () {
    /** =========================
     * Animation on Scroll
     ========================== */
    const animateElements = document.querySelectorAll('.animate-on-scroll');

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const delay = entry.target.getAttribute('data-delay') || 0;
                const animation = entry.target.getAttribute('data-animation') || 'fadeInUp';

                setTimeout(() => {
                    entry.target.classList.add('animated', animation);

                    // Marker dot animation
                    const markerDot = entry.target.querySelector('.marker-dot');
                    if (markerDot) markerDot.classList.add('active');

                    // Start counter animation if available
                    if (entry.target.querySelector('.counter')) {
                        startCounterAnimation(entry.target);
                    }
                }, delay * 1000);
            }
        });
    }, { threshold: 0.2 });

    animateElements.forEach(el => observer.observe(el));

    /** =========================
     * Counter Animation
     ========================== */
    function startCounterAnimation(element) {
        const counters = element.querySelectorAll('.counter');
        const speed = 200;

        counters.forEach(counter => {
            const target = +counter.getAttribute('data-count');
            const updateCount = () => {
                const count = +counter.innerText;
                const increment = target / speed;

                if (count < target) {
                    counter.innerText = Math.ceil(count + increment);
                    setTimeout(updateCount, 20);
                } else {
                    counter.innerText = target.toLocaleString();
                }
            };
            updateCount();
        });
    }

    /** =========================
     * Timeline Progress Dot Animation
     ========================== */
    const timeline = document.querySelector('.modern-timeline');
    if (timeline) {
        const progressObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                const progressDot = document.querySelector('.progress-dot');
                if (progressDot) {
                    progressDot.style.animationPlayState = entry.isIntersecting ? 'running' : 'paused';
                }
            });
        });
        progressObserver.observe(timeline);
    }

    /** =========================pr
     * Project Filtering
     ========================== */
    const filterButtons = document.querySelectorAll('.project-filters .nav-link');
    const projectItems = document.querySelectorAll('.project-item');

    filterButtons.forEach(button => {
        button.addEventListener('click', function () {
            const filter = this.getAttribute('data-bs-target').replace('#', '');
            projectItems.forEach(item => {
                item.style.display = (filter === 'all' || item.getAttribute('data-category').includes(filter))
                    ? 'block'
                    : 'none';
            });
        });
    });
});

// jQuery-specific scripts
$(document).ready(function () {
    /** =========================
     * Navbar Scroll Effect & Back-to-Top Button
     ========================== */
    $(window).scroll(function () {
        if ($(this).scrollTop() > 100) {
            $('.navbar').addClass('scrolled');
        } else {
            $('.navbar').removeClass('scrolled');
        }

        if ($(this).scrollTop() > 300) {
            $('.back-to-top').addClass('active');
        } else {
            $('.back-to-top').removeClass('active');
        }
    });

    /** =========================
     * Smooth Scroll for Anchors
     ========================== */
    $('a[href*="#"]').on('click', function (e) {
        e.preventDefault();
        $('html, body').animate({
            scrollTop: $($(this).attr('href')).offset().top - 70
        }, 500, 'linear');
    });

    /** =========================
     * Back to Top Button Click
     ========================== */
    $('.back-to-top').click(function () {
        $('html, body').animate({ scrollTop: 0 }, 500);
        return false;
    });

    /** =========================
     * Carousel Auto-Rotate & Animation
     ========================== */
    $('#heroCarousel').carousel({
        interval: 6000,
        pause: "hover"
    });

    $('#heroCarousel').on('slide.bs.carousel', function (e) {
        var $next = $(e.relatedTarget);
        var direction = e.direction;

        $next.find('.carousel-caption').removeClass().addClass('carousel-caption');

        if (direction === 'left') {
            $next.find('.carousel-caption').addClass('animate__animated animate__fadeInRight');
        } else {
            $next.find('.carousel-caption').addClass('animate__animated animate__fadeInLeft');
        }

        if ($next.index() === 0) {
            $next.find('.carousel-caption').removeClass().addClass('carousel-caption animate__animated animate__fadeInUp');
        }
    });
});
 // Initialize Team Carousel
    document.addEventListener('DOMContentLoaded', function() {
        $('.team-carousel').owlCarousel({
            loop: true,
            margin: 20,
            nav: true,
            dots: false,
            autoplay: true,
            autoplayTimeout: 3000,
            autoplayHoverPause: true,
            responsive: {
                0: {
                    items: 1
                },
                576: {
                    items: 2
                },
                992: {
                    items: 3
                },
                1200: {
                    items: 4
                }
            }
        });
        
        // Animation on scroll
        const animateElements = document.querySelectorAll('.animate-on-scroll');
        
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const animation = entry.target.getAttribute('data-animation') || 'fadeInUp';
                    entry.target.classList.add('animated', animation);
                }
            });
        }, {
            threshold: 0.1
        });
        
        animateElements.forEach(el => observer.observe(el));
    });

       // Auto-scroll functionality
    let scrollPosition = 0;
    const scrollSpeed = 1; // pixels per interval
    const scrollInterval = 30; // milliseconds
    const scroller = document.getElementById('teamScroller');
    
    // Start auto-scrolling
    const autoScroll = setInterval(() => {
        scrollPosition += scrollSpeed;
        
        // Reset to start when reaching end
        if (scrollPosition >= scroller.scrollWidth - scroller.clientWidth) {
            scrollPosition = 0;
        }
        
        scroller.scrollLeft = scrollPosition;
    }, scrollInterval);
    
    // Pause on hover
    scroller.addEventListener('mouseenter', () => {
        clearInterval(autoScroll);
    });
    
    // Resume when mouse leaves
    scroller.addEventListener('mouseleave', () => {
        autoScroll = setInterval(() => {
            scrollPosition += scrollSpeed;
            
            // Reset to start when reaching end
            if (scrollPosition >= scroller.scrollWidth - scroller.clientWidth) {
                scrollPosition = 0;
            }
            
            scroller.scrollLeft = scrollPosition;
        }, scrollInterval);
    });
    
    // Manual scroll with buttons
    function scrollTeam(direction) {
        scrollPosition += direction * 300; // Scroll by 300px
        if (scrollPosition < 0) scrollPosition = 0;
        if (scrollPosition > scroller.scrollWidth - scroller.clientWidth) {
            scrollPosition = scroller.scrollWidth - scroller.clientWidth;
        }
        scroller.scrollLeft = scrollPosition;
    }

    
    document.addEventListener('DOMContentLoaded', function() {
    // Initialize advisor card animations
    const advisorCards = document.querySelectorAll('.advisor-card');
    
    advisorCards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.querySelector('.advisor-card-inner').style.transform = 'translateY(-10px)';
        });
        
        card.addEventListener('mouseleave', function() {
            this.querySelector('.advisor-card-inner').style.transform = '';
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
                }, delay * 1000);
            }
        });
    }, { threshold: 0.1 });
    
    document.querySelectorAll('.animate-on-scroll').forEach(el => observer.observe(el));
});

document.addEventListener('DOMContentLoaded', function() {
    // Clone logos for infinite loop
    const scroller = document.getElementById('clientScroller');
    if (scroller) {
        // Pause animation on hover
        scroller.addEventListener('mouseenter', function() {
            this.style.animationPlayState = 'paused';
        });
        
        scroller.addEventListener('mouseleave', function() {
            this.style.animationPlayState = 'running';
        });
        
        // Make it responsive - adjust speed based on screen size
        function adjustScrollSpeed() {
            if (window.innerWidth < 768) {
                scroller.style.animationDuration = '20s';
            } else {
                scroller.style.animationDuration = '30s';
            }
        }
        
        window.addEventListener('resize', adjustScrollSpeed);
        adjustScrollSpeed();
    }
});


document.getElementById('gnsQuoteForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    // Simple form validation
    const inputs = this.querySelectorAll('[required]');
    let isValid = true;
    
    inputs.forEach(input => {
        if (!input.value) {
            input.classList.add('is-invalid');
            isValid = false;
        } else {
            input.classList.remove('is-invalid');
        }
    });
    
    if (isValid) {
        // Here you would typically send the form data
        alert('Thank you! We will contact you shortly.');
        bootstrap.Modal.getInstance(document.getElementById('quoteModal')).hide();
        this.reset();
    }
});