const passwordInput = document.getElementById('password');
const eyeIcon = document.querySelector('.input-group-text');

eyeIcon.addEventListener('click', function() {
    if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        eyeIcon.innerHTML = '<i class="icon-base ri ri-eye-line icon-20px"></i>';
    } else {
        passwordInput.type = 'password';
        eyeIcon.innerHTML = '<i class="icon-base ri ri-eye-off-line icon-20px"></i>';
    }
});