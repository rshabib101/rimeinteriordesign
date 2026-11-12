import './bootstrap';
import Lenis from 'lenis';
import gsap from 'gsap';
import { ScrollTrigger } from 'gsap/ScrollTrigger';
import GLightbox from 'glightbox';
import Swiper from 'swiper';
import { Navigation, Pagination, Autoplay, EffectFade } from 'swiper/modules';
import '@google/model-viewer';

// Register GSAP plugins
gsap.registerPlugin(ScrollTrigger);

// Global app state
window.Rime = {
    lenis: null,
    lightbox: null,
    gsap: gsap,
    ScrollTrigger: ScrollTrigger,
    cleanupHero3D: null,
};

// 1. Initialize Lenis Smooth Scrolling
function initSmoothScroll() {
    if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
        return;
    }

    const lenis = new Lenis({
        duration: 1.15,
        easing: (t) => Math.min(1, 1.001 - Math.pow(2, -10 * t)),
        orientation: 'vertical',
        gestureOrientation: 'vertical',
        smoothWheel: true,
        wheelMultiplier: 0.9,
        touchMultiplier: 1.5,
    });

    window.Rime.lenis = lenis;

    lenis.on('scroll', ScrollTrigger.update);

    gsap.ticker.add((time) => {
        lenis.raf(time * 1000);
    });

    gsap.ticker.lagSmoothing(0);
}

// 2. Custom Luxury Cursor
function initCustomCursor() {
    if (window.matchMedia('(pointer: coarse)').matches || window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
        return;
    }

    let dot = document.querySelector('.custom-cursor-dot');
    let outline = document.querySelector('.custom-cursor-outline');

    if (!dot || !outline) {
        dot = document.createElement('div');
        dot.className = 'custom-cursor custom-cursor-dot';
        outline = document.createElement('div');
        outline.className = 'custom-cursor custom-cursor-outline';
        document.body.appendChild(dot);
        document.body.appendChild(outline);
    }

    let mouseX = -100;
    let mouseY = -100;
    let outlineX = -100;
    let outlineY = -100;

    window.addEventListener('mousemove', (e) => {
        mouseX = e.clientX;
        mouseY = e.clientY;
        dot.style.transform = `translate3d(${mouseX}px, ${mouseY}px, 0)`;
    }, { passive: true });

    function animateCursor() {
        outlineX += (mouseX - outlineX) * 0.15;
        outlineY += (mouseY - outlineY) * 0.15;
        outline.style.transform = `translate3d(${outlineX}px, ${outlineY}px, 0)`;
        requestAnimationFrame(animateCursor);
    }
    animateCursor();

    const updateHoverListeners = () => {
        const hoverTargets = document.querySelectorAll('a, button, input, select, textarea, [data-cursor-hover], .tilt-card');
        hoverTargets.forEach((el) => {
            el.addEventListener('mouseenter', () => document.body.classList.add('cursor-hover'));
            el.addEventListener('mouseleave', () => document.body.classList.remove('cursor-hover'));
        });
    };

    updateHoverListeners();
    document.addEventListener('livewire:navigated', updateHoverListeners);
}

// 3. Interactive 3D Tilt Cards
function init3DTiltCards() {
    if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
        return;
    }

    const cards = document.querySelectorAll('.tilt-card');

    cards.forEach((card) => {
        if (card.dataset.tiltBound === '1') return;
        card.dataset.tiltBound = '1';

        let bounds;

        function rotateToMouse(e) {
            bounds = card.getBoundingClientRect();
            const leftX = e.clientX - bounds.x;
            const topY = e.clientY - bounds.y;
            const center = {
                x: leftX - bounds.width / 2,
                y: topY - bounds.height / 2,
            };

            const distance = Math.max(1, Math.sqrt(center.x ** 2 + center.y ** 2));

            card.style.transform = `
                scale3d(1.02, 1.02, 1.02)
                rotate3d(
                    ${-center.y / 110},
                    ${center.x / 110},
                    0,
                    ${Math.min(Math.log(distance) * 1.8, 10)}deg
                )
            `;
        }

        function removeListener() {
            card.style.transform = 'scale3d(1, 1, 1) rotate3d(0, 0, 0, 0deg)';
            card.removeEventListener('mousemove', rotateToMouse);
        }

        card.addEventListener('mouseenter', () => {
            bounds = card.getBoundingClientRect();
            card.addEventListener('mousemove', rotateToMouse);
        });

        card.addEventListener('mouseleave', removeListener);
    });
}

// 4. GSAP Scroll Reveals & Counters
function initScrollAnimations() {
    if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
        return;
    }

    const revealElements = document.querySelectorAll('[data-reveal]');
    revealElements.forEach((el) => {
        if (el.dataset.revealBound === '1') return;
        el.dataset.revealBound = '1';

        const direction = el.getAttribute('data-reveal') || 'up';
        let yOffset = 36;
        let xOffset = 0;

        if (direction === 'down') yOffset = -36;
        if (direction === 'left') { yOffset = 0; xOffset = 36; }
        if (direction === 'right') { yOffset = 0; xOffset = -36; }

        gsap.fromTo(
            el,
            { opacity: 0, y: yOffset, x: xOffset },
            {
                opacity: 1,
                y: 0,
                x: 0,
                duration: 0.9,
                ease: 'power3.out',
                scrollTrigger: {
                    trigger: el,
                    start: 'top 88%',
                    toggleActions: 'play none none none',
                },
            }
        );
    });

    // Animated Counters
    document.querySelectorAll('[data-counter]').forEach((el) => {
        if (el.dataset.counterBound === '1') return;
        el.dataset.counterBound = '1';

        const raw = (el.dataset.counter || el.textContent || '').trim();
        const match = raw.match(/^([^\d]*)(\d+(?:\.\d+)?)(.*)$/);
        if (!match) return;

        const [, prefix, numStr, suffix] = match;
        const target = parseFloat(numStr);
        const state = { val: 0 };

        gsap.to(state, {
            val: target,
            duration: 1.6,
            ease: 'power2.out',
            scrollTrigger: {
                trigger: el,
                start: 'top 90%',
                once: true,
            },
            onUpdate: () => {
                el.textContent = `${prefix}${Math.round(state.val)}${suffix}`;
            },
        });
    });
}

// 5. GLightbox helper
function initLightbox() {
    if (document.querySelector('.glightbox')) {
        window.Rime.lightbox = GLightbox({
            selector: '.glightbox',
            touchNavigation: true,
            loop: true,
            autoplayVideos: true,
        });
    }
}

// 6. Swiper Carousels (Testimonials & Featured Galleries)
function initSwipers() {
    document.querySelectorAll('.testimonials-swiper').forEach((el) => {
        if (el.swiper) return;
        new Swiper(el, {
            modules: [Navigation, Pagination, Autoplay],
            slidesPerView: 1,
            spaceBetween: 24,
            loop: el.querySelectorAll('.swiper-slide').length > 1,
            autoplay: {
                delay: 5500,
                disableOnInteraction: false,
            },
            pagination: {
                el: el.querySelector('.swiper-pagination'),
                clickable: true,
            },
            navigation: {
                nextEl: el.querySelector('.swiper-button-next'),
                prevEl: el.querySelector('.swiper-button-prev'),
            },
            breakpoints: {
                768: { slidesPerView: 2 },
                1024: { slidesPerView: 3 },
            },
        });
    });

    document.querySelectorAll('.gallery-swiper').forEach((el) => {
        if (el.swiper) return;
        new Swiper(el, {
            modules: [Navigation, Pagination, EffectFade],
            slidesPerView: 1,
            spaceBetween: 16,
            pagination: {
                el: el.querySelector('.swiper-pagination'),
                clickable: true,
            },
            navigation: {
                nextEl: el.querySelector('.swiper-button-next'),
                prevEl: el.querySelector('.swiper-button-prev'),
            },
        });
    });
}

// 7. Lazy-load Three.js Hero 3D Scene
async function initHeroCanvas() {
    if (window.Rime.cleanupHero3D) {
        window.Rime.cleanupHero3D();
        window.Rime.cleanupHero3D = null;
    }

    const canvasContainer = document.getElementById('hero-3d-canvas');
    if (!canvasContainer) return;

    try {
        const { initHero3D } = await import('./hero3d');
        window.Rime.cleanupHero3D = initHero3D('hero-3d-canvas');
    } catch (err) {
        console.warn('3D Hero fallback engaged:', err);
    }
}

// Master init
function initAll() {
    initSmoothScroll();
    initCustomCursor();
    init3DTiltCards();
    initScrollAnimations();
    initLightbox();
    initSwipers();
    initHeroCanvas();
}

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initAll);
} else {
    initAll();
}

document.addEventListener('livewire:navigated', () => {
    init3DTiltCards();
    initScrollAnimations();
    initLightbox();
    initSwipers();
    initHeroCanvas();
    if (window.Rime.lenis) {
        window.Rime.lenis.resize();
    }
});
