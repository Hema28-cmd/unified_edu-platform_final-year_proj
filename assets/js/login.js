// login.js
document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('form');
    form.addEventListener('submit', function(e) {
        const email = document.getElementById('email').value.trim();
        const password = document.getElementById('password').value.trim();

        if (email === '' || password === '') {
            e.preventDefault();
            alert('Please fill in both email and password fields.');
        }
    });
});
