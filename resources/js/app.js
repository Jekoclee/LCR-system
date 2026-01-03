import './bootstrap';

document.addEventListener('DOMContentLoaded', () => {
    const observer = new IntersectionObserver(
        (entries) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('in-view');
                }
            });
        },
        { threshold: 0.2, rootMargin: '0px 0px -10% 0px' }
    );

    const targets = document.querySelectorAll('.reveal, .reveal-up, .reveal-left, .reveal-right');
    targets.forEach((el) => observer.observe(el));
});
