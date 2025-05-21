// Main JavaScript file for Dental Clinic
document.addEventListener('DOMContentLoaded', function() {
    // Animación al cargar la página
    setTimeout(function() {
        const pageElements = document.querySelectorAll('.page-transition');
        pageElements.forEach(element => {
            element.classList.add('visible');
        });
    }, 100);
    
    // Form validation
    const forms = document.querySelectorAll('.needs-validation');
    
    Array.from(forms).forEach(form => {
        form.addEventListener('submit', event => {
            let isValid = true;
            
            // Check all required inputs
            const requiredInputs = form.querySelectorAll('[required]');
            requiredInputs.forEach(input => {
                if (!input.value.trim()) {
                    input.classList.add('is-invalid');
                    isValid = false;
                } else {
                    input.classList.remove('is-invalid');
                    
                    // Email validation
                    if (input.type === 'email' && !validateEmail(input.value)) {
                        input.classList.add('is-invalid');
                        isValid = false;
                    }
                    
                    // Password confirmation
                    if (input.id === 'password_confirm') {
                        const password = form.querySelector('#password');
                        if (password && input.value !== password.value) {
                            input.classList.add('is-invalid');
                            isValid = false;
                        }
                    }
                }
            });
            
            if (!isValid) {
                event.preventDefault();
                event.stopPropagation();
            }
        });
        
        // Real-time validation on input
        const inputs = form.querySelectorAll('input, select, textarea');
        inputs.forEach(input => {
            input.addEventListener('input', function() {
                if (this.required && this.value.trim()) {
                    this.classList.remove('is-invalid');
                }
            });
        });
    });
    
    // Appointment date validation - prevent past dates
    const dateInputs = document.querySelectorAll('input[type="date"]');
    Array.from(dateInputs).forEach(input => {
        const today = new Date().toISOString().split('T')[0];
        input.setAttribute('min', today);
    });
    
    // Smooth scroll for anchors
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            if (this.getAttribute('href').length > 1) {
                e.preventDefault();
                
                const targetId = this.getAttribute('href');
                const targetElement = document.querySelector(targetId);
                
                if (targetElement) {
                    // Get the navbar height to offset scrolling
                    const navHeight = document.querySelector('.main-nav').offsetHeight;
                    
                    // Calculate position
                    const targetPosition = targetElement.getBoundingClientRect().top + window.scrollY;
                    const offsetPosition = targetPosition - navHeight;
                    
                    // Scroll smoothly
                    window.scrollTo({
                        top: offsetPosition,
                        behavior: 'smooth'
                    });
                }
            }
        });
    });
    
    // Botón volver arriba
    const btnBackToTop = document.getElementById('btn-back-to-top');
    
    // Mostrar/ocultar el botón en función del scroll
    window.addEventListener('scroll', function() {
        if (window.scrollY > 300) {
            btnBackToTop.classList.add('show');
        } else {
            btnBackToTop.classList.remove('show');
        }
    });
    
    // Scroll hacia arriba al hacer clic en el botón
    btnBackToTop.addEventListener('click', function() {
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
    });
    
    // Animate elements on scroll
    const animateElements = document.querySelectorAll('.animate-on-scroll');
    
    function checkScroll() {
        animateElements.forEach(el => {
            const elementTop = el.getBoundingClientRect().top;
            const windowHeight = window.innerHeight;
            
            if (elementTop < windowHeight * 0.8) {
                el.classList.add('animated');
            }
        });
    }
    
    // Check elements on load
    checkScroll();
    
    // Check elements on scroll
    window.addEventListener('scroll', checkScroll);
    
    // Helper function to validate email format
    function validateEmail(email) {
        const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return re.test(email);
    }
}); 