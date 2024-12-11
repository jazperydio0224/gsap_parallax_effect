document.addEventListener('DOMContentLoaded', () => {
    'use strict';

    const initSmoothScrolling = () => {
        const lenis = new Lenis({
            duration: 1.2,
            lerp: 0.15,
            smoothWheel: true,
        });

        function raf(time) {
            lenis.raf(time);
            requestAnimationFrame(raf);
        }

        requestAnimationFrame(raf);

        lenis.on('scroll', ScrollTrigger.update);

        gsap.ticker.add((time) => {
            lenis.raf(time * 1000);
        });
    };

    const scrollPage = () => {
        const grid = document.querySelector('.gallery-columns');
        const columns = [...grid.querySelectorAll('.gallery-column')];
        const items = columns.map((column, pos) => {
            return [...column.querySelectorAll('.gallery-column__item')].map((item) => {
                return {
                    element: item,
                    column: pos,
                    wrapper: item.querySelector('.gallery-column__item-imgwrap'),
                    image: item.querySelector('.gallery-column__item-img'),
                };
            });
        });

        const mergedItems = items.flat();

        // Parallax effect for columns
        columns.forEach((column, index) => {
            const speed = (index + 1) * -15; // Vary speed by index
            gsap.to(column, {
                yPercent: speed,
                ease: 'none',
                scrollTrigger: {
                    trigger: grid,
                    start: 'top bottom',
                    end: 'bottom top',
                    scrub: true,
                },
            });
        });

        
        // Parallax effect for individual items
        mergedItems.forEach((item) => {
            const baseSpeed = -5; // Base speed
            const speedFactor = item.column === 0 ? 1 : item.column === 1 ? 2.5 : 4; // Adjust speed factor per column
            const speed = baseSpeed * speedFactor;

            gsap.to(item.wrapper, {
                yPercent: speed,
                ease: 'none',
                scrollTrigger: {
                    trigger: item.element,
                    start: 'top bottom',
                    end: 'bottom top',
                    scrub: true,
                },
            });
        });
    };

    initSmoothScrolling();
    // scrollPage();
});
