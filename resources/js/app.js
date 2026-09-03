import Alpine from 'alpinejs';
import Echo from 'laravel-echo';
import Pusher from 'pusher-js';

window.Alpine = Alpine;
window.Pusher = Pusher;

window.Echo = new Echo({
    broadcaster: 'pusher',
    key: import.meta.env.VITE_PUSHER_APP_KEY,
    cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER,
    forceTLS: true,
    encrypted: true,
});

document.addEventListener('alpine:init', () => {
    // chatApp will be registered from Blade if needed
});

Alpine.start();

document.addEventListener("DOMContentLoaded", () => {
    initTheme();
    initReveal();
    initMobileMenu();
    initDropdowns();
});

function initTheme() {
    const saved = localStorage.getItem("azenion-theme") ?? "system";
    const light = saved === "light" || (saved === "system" && window.matchMedia("(prefers-color-scheme: light)").matches);
    document.documentElement.classList.toggle("light", false);
}

function initReveal() {
    const observer = new IntersectionObserver(
        (entries) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    entry.target.classList.add("revealed");
                    observer.unobserve(entry.target);
                }
            });
        },
        { threshold: 0.1 }
    );
    document.querySelectorAll(".reveal").forEach((el) => {
        const delay = el.dataset.delay ? parseInt(el.dataset.delay, 10) : 0;
        if (delay) {
            el.style.animationDelay = `${delay}ms`;
        }
        observer.observe(el);
    });
}

function initMobileMenu() {
    const toggle = document.querySelector("[data-mobile-menu-toggle]");
    const menu = document.querySelector("[data-mobile-menu]");
    if (!toggle || !menu) return;

    function setMenu(open) {
        menu.classList.toggle("hidden", !open);
        toggle.setAttribute("aria-expanded", String(open));
        document.body.style.overflow = open ? "hidden" : "";
        const icon = toggle.querySelector("[data-icon-open]");
        const close = toggle.querySelector("[data-icon-close]");
        if (icon && close) {
            icon.classList.toggle("hidden", open);
            close.classList.toggle("hidden", !open);
        }
    }

    toggle.addEventListener("click", (e) => {
        e.stopPropagation();
        setMenu(menu.classList.contains("hidden"));
    });

    menu.querySelectorAll("a").forEach((link) => {
        link.addEventListener("click", () => setMenu(false));
    });

    document.addEventListener("keydown", (e) => {
        if (e.key === "Escape") setMenu(false);
    });
}

function initDropdowns() {
    const dropdowns = document.querySelectorAll("[data-dropdown]");
    if (dropdowns.length === 0) return;

    dropdowns.forEach((dropdown) => {
        const menu = dropdown.querySelector("[data-dropdown-menu]");
        if (!menu) return;

        let closeTimer = null;

        const open = () => {
            clearTimeout(closeTimer);
            menu.classList.remove("opacity-0", "invisible", "pointer-events-none");
            menu.classList.add("opacity-100", "visible");
        };

        const close = () => {
            closeTimer = setTimeout(() => {
                menu.classList.add("opacity-0", "invisible", "pointer-events-none");
                menu.classList.remove("opacity-100", "visible");
            }, 80);
        };

        dropdown.addEventListener("mouseenter", open);
        dropdown.addEventListener("mouseleave", close);
        menu.addEventListener("mouseenter", open);
        menu.addEventListener("mouseleave", close);

        const link = dropdown.querySelector("a");
        if (link) {
            link.addEventListener("click", (e) => {
                if (menu.classList.contains("invisible")) {
                    e.preventDefault();
                    e.stopPropagation();
                    open();
                }
            });
        }
    });
}