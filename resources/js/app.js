import './bootstrap';
import Alpine from 'alpinejs';
import AOS from 'aos';
import 'aos/dist/aos.css';

// Alpine.js
window.Alpine = Alpine;

// Toast notification system
Alpine.data('toast', () => ({
    toasts: [],
    add(message, type = 'success', duration = 3000) {
        const id = Date.now();
        this.toasts.push({ id, message, type });
        setTimeout(() => this.remove(id), duration);
    },
    remove(id) {
        this.toasts = this.toasts.filter(t => t.id !== id);
    }
}));

// Cart counter
Alpine.store('cart', {
    count: 0,
    async refresh() {
        try {
            const res = await fetch('/api/cart/count');
            if (res.ok) {
                const data = await res.json();
                this.count = data.count;
            }
        } catch (e) { /* ignore */ }
    }
});

Alpine.start();

// AOS (Animate On Scroll)
AOS.init({
    duration: 500,
    easing: 'ease-out',
    once: true,
    offset: 60,
});

// CSRF token for fetch requests
window.csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;

window.fetchWithCsrf = async function(url, options = {}) {
    const defaults = {
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'X-CSRF-TOKEN': window.csrfToken,
            'X-Requested-With': 'XMLHttpRequest',
        },
    };
    return fetch(url, { ...defaults, ...options, headers: { ...defaults.headers, ...options.headers } });
};
