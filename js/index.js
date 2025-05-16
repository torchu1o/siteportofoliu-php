document.addEventListener('DOMContentLoaded', function() {
    // Hero slider functionality
    const slides = document.querySelectorAll('.slide');
    const dotsContainer = document.querySelector('.slider-dots');
    const prevButton = document.querySelector('.prev-slide');
    const nextButton = document.querySelector('.next-slide');
    
    let currentSlide = 0;
    let slideInterval;
    const intervalTime = 5000;
    
    // Initialize slider
    function initSlider() {
        if (slides.length === 0) return;
        
        // Create dots
        slides.forEach((_, index) => {
            const dot = document.createElement('div');
            dot.classList.add('slider-dot');
            if (index === 0) dot.classList.add('active');
            dot.addEventListener('click', () => goToSlide(index));
            dotsContainer.appendChild(dot);
        });
        
        // Set first slide as active
        slides[0].classList.add('active');
        
        // Start autoplay
        startSlideShow();
        
        // Add event listeners for controls
        if (prevButton) prevButton.addEventListener('click', prevSlide);
        if (nextButton) nextButton.addEventListener('click', nextSlide);
    }
    
    // Go to specific slide
    function goToSlide(n) {
        // Remove active class from current slide and dot
        slides[currentSlide].classList.remove('active');
        document.querySelectorAll('.slider-dot')[currentSlide].classList.remove('active');
        
        // Set new current slide
        currentSlide = (n + slides.length) % slides.length;
        
        // Add active class to new slide and dot
        slides[currentSlide].classList.add('active');
        document.querySelectorAll('.slider-dot')[currentSlide].classList.add('active');
        
        // Reset timer
        resetTimer();
    }
    
    // Go to next slide
    function nextSlide() {
        goToSlide(currentSlide + 1);
    }
    
    // Go to previous slide
    function prevSlide() {
        goToSlide(currentSlide - 1);
    }
    
    // Start automatic slideshow
    function startSlideShow() {
        if (slides.length > 1) {
            slideInterval = setInterval(nextSlide, intervalTime);
        }
    }
    
    // Reset timer for automatic slideshow
    function resetTimer() {
        clearInterval(slideInterval);
        startSlideShow();
    }
    
    // Initialize the slider if we have slides
    if (slides.length > 0) {
        initSlider();
    }
    
    // Testimonials slider
    const testimonialSlides = document.querySelectorAll('.testimonial-slide');
    let currentTestimonial = 0;
    const testimonialInterval = 4000;
    let testimonialTimer;
    
    function initTestimonialSlider() {
        if (testimonialSlides.length === 0) return;
        
        // Set first testimonial as active
        testimonialSlides[0].classList.add('active');
        
        // Start autoplay
        startTestimonialSlideShow();
    }
    
    function nextTestimonial() {
        // Remove active class from current testimonial
        testimonialSlides[currentTestimonial].classList.remove('active');
        
        // Set new current testimonial
        currentTestimonial = (currentTestimonial + 1) % testimonialSlides.length;
        
        // Add active class to new testimonial
        testimonialSlides[currentTestimonial].classList.add('active');
    }
    
    function startTestimonialSlideShow() {
        if (testimonialSlides.length > 1) {
            testimonialTimer = setInterval(nextTestimonial, testimonialInterval);
        }
    }
    
    // Initialize the testimonial slider if we have testimonials
    if (testimonialSlides.length > 0) {
        initTestimonialSlider();
    }
}); 