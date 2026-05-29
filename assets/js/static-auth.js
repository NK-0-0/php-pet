/**
 * Client-side auth fallback for the static GitHub Pages build.
 * Matches the mock credentials in includes/config.php.
 */
(function () {
    const DEMO_EMAIL = 'demo@petpal.com';
    const DEMO_PASSWORD = 'pets123';
    const AUTH_KEY = 'petpal_authenticated';

    const form = document.querySelector('.login-form');
    if (!form) {
        return;
    }

    form.addEventListener('submit', function (event) {
        event.preventDefault();

        const email = form.querySelector('#email')?.value?.trim() ?? '';
        const password = form.querySelector('#password')?.value ?? '';
        const errorBox = document.querySelector('.alert-error');

        if (email === DEMO_EMAIL && password === DEMO_PASSWORD) {
            localStorage.setItem(AUTH_KEY, 'true');
            window.location.href = 'pets.html';
            return;
        }

        if (errorBox) {
            errorBox.textContent = 'Invalid email or password. Try the demo credentials below.';
            errorBox.style.display = 'block';
        } else {
            alert('Invalid email or password. Try the demo credentials below.');
        }
    });
})();
