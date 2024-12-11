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
        })
    }

    const scrollPage = () => {
        const grid = document.querySelector('.columns');
        const columns = [...grid.querySelectorAll('.column')];
        const items = columns.map((column, pos) => {
            return [...column.querySelectorAll('.column__item')].map((item) => {
                return {
                    element: item,
                    column: pos,
                    wrapper: item.querySelector('.column__item-imgwrap'),
                    image: item.querySelector('.column__item-img'),
                }
            })
        })

        const mergedItems = items.flat();

        gsap.to(columns[1], {
            ease: 'none',
            scrollTrigger: {
                trigger: grid,
                start: 'clamp(top bottom)',
                end: 'clamp(bottom top)',
                scrub: true,
            },
            yPercent: -20
        })

        mergedItems.forEach((item) => {
            if (item.column === 1) {
                return;
            }

            gsap.to(item.wrapper, {
                ease: 'none',
                startAt: {
                    transformOrigin: item.column === 0 ? '0% 100%' : '100% 100%'
                },
                scrollTrigger: {
                    trigger: item.element,
                    start: 'clamp(top bottom)',
                    end: 'clamp(bottom top)',
                    scrub: true,
                },
                rotation: item.column === 0 ? -6 : 6,
                xPercent: item.column === 0 ? -10 : 10
            })
        })
    }

    initSmoothScrolling();
    scrollPage();
});