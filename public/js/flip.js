document.querySelectorAll('.card-container').forEach(card => {
    const inner = card.querySelector('.card-inner');
    card.addEventListener('mouseenter', () => {
        gsap.to(inner, { rotateY: 180, duration: 0.7, ease: "power2.inOut" });
    });
    card.addEventListener('mouseleave', () => {
        gsap.to(inner, { rotateY: 0, duration: 0.7, ease: "power2.inOut" });
    });
});