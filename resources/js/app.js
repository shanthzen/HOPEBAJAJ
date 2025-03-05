import './bootstrap';

// Handle page loading states
document.addEventListener('DOMContentLoaded', () => {
    // Stop any loading indicators
    if (document.readyState === 'complete') {
        document.documentElement.classList.remove('loading');
    }
});

// Handle AJAX loading states
let loadingTimeout;
document.addEventListener('turbolinks:request-start', () => {
    clearTimeout(loadingTimeout);
    loadingTimeout = setTimeout(() => {
        document.documentElement.classList.add('loading');
    }, 100);
});

document.addEventListener('turbolinks:request-end', () => {
    clearTimeout(loadingTimeout);
    document.documentElement.classList.remove('loading');
});
