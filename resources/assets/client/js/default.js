// Identificar bg so footer e adicionar class foote-light ou footer-dark
document.addEventListener('DOMContentLoaded', function () {
    const footer = document.querySelector('.bg-footer');

    if (!footer) return;

    const bgColor = getComputedStyle(footer).backgroundColor;

    const rgb = bgColor.match(/\d+/g);

    if (!rgb || rgb.length < 3) return;

    const [r, g, b] = rgb.map(Number);

    const luminance = (0.299 * r) + (0.587 * g) + (0.114 * b);

    if (luminance < 150) {
        footer.classList.add('footer-dark');
    } else {
        footer.classList.add('footer-light');
    }
});