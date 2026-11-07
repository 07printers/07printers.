// 07 Printers - Main JavaScript

document.addEventListener('DOMContentLoaded', function() {
    
    // Preloader
    const preloader = document.getElementById('preloader');
    if (preloader) {
        window.addEventListener('load', () => {
            setTimeout(() => {
                preloader.classList.add('hidden');
            }, 600);
        });
        // Fallback
        setTimeout(() => preloader.classList.add('hidden'), 2500);
    }

    // AOS Init
    if (typeof AOS !== 'undefined') {
        AOS.init({
            duration: 700,
            easing: 'ease-out-cubic',
            once: true,
            offset: 60
        });
    }

    // Header Scroll
    const header = document.getElementById('header');
    window.addEventListener('scroll', () => {
        if (window.scrollY > 50) {
            header.classList.add('scrolled');
        } else {
            header.classList.remove('scrolled');
        }
    });

    // Mobile Menu
    const menuToggle = document.getElementById('menuToggle');
    const nav = document.getElementById('nav');
    if (menuToggle && nav) {
        menuToggle.addEventListener('click', () => {
            nav.classList.toggle('active');
            menuToggle.classList.toggle('active');
        });
        // Close on link click
        nav.querySelectorAll('.nav-link').forEach(link => {
            link.addEventListener('click', () => {
                nav.classList.remove('active');
            });
        });
    }

    // Back to Top
    const backToTop = document.getElementById('backToTop');
    if (backToTop) {
        window.addEventListener('scroll', () => {
            if (window.scrollY > 400) {
                backToTop.classList.add('show');
            } else {
                backToTop.classList.remove('show');
            }
        });
        backToTop.addEventListener('click', () => {
            window.scrollTo({ top: 0, behavior: 'smooth' });
        });
    }

    // Category Tabs (Products page)
    const catTabs = document.querySelectorAll('.cat-tab');
    const productCards = document.querySelectorAll('.product-card');
    
    catTabs.forEach(tab => {
        tab.addEventListener('click', () => {
            catTabs.forEach(t => t.classList.remove('active'));
            tab.classList.add('active');
            
            const cat = tab.dataset.cat;
            
            productCards.forEach(card => {
                if (cat === 'all' || card.dataset.cat === cat) {
                    card.style.display = 'flex';
                    card.style.animation = 'fadeIn 0.4s';
                } else {
                    card.style.display = 'none';
                }
            });
        });
    });

    // Payment Option Toggle
    const paymentOptions = document.querySelectorAll('.payment-option');
    const paymentDetails = document.querySelectorAll('.payment-details');
    
    paymentOptions.forEach(opt => {
        opt.addEventListener('click', () => {
            paymentOptions.forEach(o => o.classList.remove('active'));
            opt.classList.add('active');
            
            const method = opt.dataset.method;
            paymentDetails.forEach(d => {
                d.classList.remove('show');
                if (d.dataset.method === method) {
                    d.classList.add('show');
                }
            });
            
            // Update hidden input
            const methodInput = document.getElementById('payment_method');
            if (methodInput) methodInput.value = method;
        });
    });

    // Add to Cart AJAX-like feedback
    document.querySelectorAll('.add-to-cart-form').forEach(form => {
        form.addEventListener('submit', function(e) {
            const btn = this.querySelector('button[type="submit"]');
            if (btn) {
                const original = btn.innerHTML;
                btn.innerHTML = '<i class="fas fa-check"></i> Added';
                btn.disabled = true;
                setTimeout(() => {
                    btn.innerHTML = original;
                    btn.disabled = false;
                }, 1500);
            }
        });
    });

    // Smooth number counter (optional)
    const counters = document.querySelectorAll('[data-count]');
    const observerOptions = { threshold: 0.5 };
    
    const counterObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const el = entry.target;
                const target = parseInt(el.dataset.count);
                let current = 0;
                const increment = target / 40;
                const timer = setInterval(() => {
                    current += increment;
                    if (current >= target) {
                        el.textContent = target + (el.dataset.suffix || '');
                        clearInterval(timer);
                    } else {
                        el.textContent = Math.floor(current) + (el.dataset.suffix || '');
                    }
                }, 30);
                counterObserver.unobserve(el);
            }
        });
    }, observerOptions);
    
    counters.forEach(c => counterObserver.observe(c));
});

// Cart quantity update
function updateQty(id, change) {
    const form = document.getElementById('qty-form-' + id);
    if (form) {
        const input = form.querySelector('input[name="qty"]');
        let val = parseInt(input.value) + change;
        if (val < 1) val = 1;
        input.value = val;
        form.submit();
    }
}