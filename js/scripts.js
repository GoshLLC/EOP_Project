/*!
 * Start Bootstrap - Grayscale v7.0.6 (https://startbootstrap.com/theme/grayscale)
 * Copyright 2013-2023 Start Bootstrap
 * Licensed under MIT (https://github.com/StartBootstrap/startbootstrap-grayscale/blob/master/LICENSE)
 */
/**
 * Global scripts: navbar behavior, scrollspy, Filters button (index search form).
 */
window.addEventListener('DOMContentLoaded', () => {
    const mainNavEl = document.body.querySelector('#mainNav');

    function navbarShrink() {
        if (!mainNavEl) return;
        mainNavEl.classList.toggle('navbar-shrink', window.scrollY > 0);
    }
    navbarShrink();
    document.addEventListener('scroll', navbarShrink);

    if (mainNavEl && typeof bootstrap !== 'undefined') {
        new bootstrap.ScrollSpy(document.body, { target: '#mainNav', rootMargin: '0px 0px -40%' });
    }

    const navbarToggler = document.body.querySelector('.navbar-toggler');
    document.querySelectorAll('#navbarResponsive .nav-link').forEach((link) => {
        link.addEventListener('click', () => {
            if (navbarToggler && window.getComputedStyle(navbarToggler).display !== 'none') {
                navbarToggler.click();
            }
        });
    });

    // Filters button (index.php): go to search page with full filter form, preserving search term
    const filtersBtn = document.getElementById('filters-button');
    if (filtersBtn) {
        filtersBtn.addEventListener('click', () => {
            const form = document.getElementById('main-search-form');
            const input = form && form.querySelector('input[name="q"]');
            const q = (input && input.value) ? input.value : '';
            window.location.href = q ? 'search.php?q=' + encodeURIComponent(q) : 'search.php';
        });
    }

});