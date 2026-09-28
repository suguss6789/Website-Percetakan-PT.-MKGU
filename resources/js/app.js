import Alpine from 'alpinejs';

/** Galeri produk: gambar utama + thumbnail + geser di HP */
Alpine.data('gallery', (images = []) => ({
    images,
    active: 0,
    zoom: false,
    startX: null,
    go(i) { this.active = (i + this.images.length) % this.images.length; },
    touchStart(e) { this.startX = e.touches[0].clientX; },
    touchEnd(e) {
        if (this.startX === null) return;
        const dx = e.changedTouches[0].clientX - this.startX;
        if (Math.abs(dx) > 40) this.go(this.active + (dx < 0 ? 1 : -1));
        this.startX = null;
    },
}));

/** Pemilih ukuran: ukuran yang dipilih ikut masuk ke pesan WhatsApp */
Alpine.data('sizePicker', (config) => ({
    selected: null,
    get waUrl() {
        let text = `Halo MKGU, saya ingin tanya harga *${config.product}*`;
        if (this.selected) text += ` ukuran *${this.selected}*`;
        text += `.\nJumlah: \nBahan: \n\n(dari website: ${config.url})`;
        return `https://wa.me/${config.number}?text=${encodeURIComponent(text)}`;
    },
}));

window.Alpine = Alpine;
Alpine.start();

// Header mengecil saat di-scroll
const header = document.querySelector('[data-header]');
if (header) {
    const onScroll = () => header.toggleAttribute('data-scrolled', window.scrollY > 24);
    onScroll();
    window.addEventListener('scroll', onScroll, { passive: true });
}

// Fade-in sekali saat elemen pertama kali terlihat
const reveals = document.querySelectorAll('.reveal');
if ('IntersectionObserver' in window && !window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
    const io = new IntersectionObserver((entries) => {
        entries.forEach((entry) => {
            if (entry.isIntersecting) {
                entry.target.classList.add('is-visible');
                io.unobserve(entry.target);
            }
        });
    }, { rootMargin: '0px 0px -8% 0px' });
    reveals.forEach((el) => io.observe(el));
} else {
    reveals.forEach((el) => el.classList.add('is-visible'));
}
