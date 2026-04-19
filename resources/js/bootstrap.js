/**
 * Bootstrap file - sets up global utilities
 */

// CSRF token for fetch
const token = document.querySelector('meta[name="csrf-token"]');
if (token) {
    window.csrfToken = token.content;
}
