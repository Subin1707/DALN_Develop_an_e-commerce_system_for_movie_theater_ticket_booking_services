// Custom JavaScript for Q&H Cinema

document.addEventListener('DOMContentLoaded', function() {
    // Initialize any custom functionality here
    
    // Navbar sticky effect
    const navbar = document.getElementById('navbar_sticky');
    if (navbar) {
        window.addEventListener('scroll', function() {
            if (window.scrollY > 100) {
                navbar.classList.add('sticky-top');
            } else {
                navbar.classList.remove('sticky-top');
            }
        });
    }
});
