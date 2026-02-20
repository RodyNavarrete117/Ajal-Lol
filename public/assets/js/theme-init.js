/**
 * theme-init.js
 * Este script se carga en TODAS las páginas (en el <head> del dashboard layout).
 * Se ejecuta inmediatamente para evitar parpadeo (FOUC) al cargar la página.
 * NO necesita esperar al DOMContentLoaded.
 */

(function () {
    // ── Modo oscuro ──────────────────────────────────────────────────
    const darkPref = localStorage.getItem('darkMode') || 'light';

    if (darkPref === 'dark') {
        document.documentElement.setAttribute('data-theme', 'dark');
    } else if (darkPref === 'auto') {
        const systemDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
        document.documentElement.setAttribute('data-theme', systemDark ? 'dark' : 'light');
    } else {
        document.documentElement.setAttribute('data-theme', 'light');
    }

    // ── Escuchar cambios del sistema (solo cuando está en "auto") ────
    window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', function (e) {
        if (localStorage.getItem('darkMode') === 'auto') {
            document.documentElement.setAttribute('data-theme', e.matches ? 'dark' : 'light');
        }
    });

    // ── Reducir animaciones ──────────────────────────────────────────
    if (localStorage.getItem('reduceAnimations') === 'true') {
        // Agregar clase al <html> para que esté disponible desde el inicio
        document.documentElement.classList.add('reduce-animations');
        // También al body cuando esté listo
        document.addEventListener('DOMContentLoaded', function () {
            document.body.classList.add('reduce-animations');
        });
    }
})();