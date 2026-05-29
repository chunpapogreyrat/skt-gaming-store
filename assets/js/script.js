/* =========================================
   AUTH MODULE
========================================= */

// Hàm ẩn hiện mật khẩu
function initTogglePassword() {
    const togglePassword = document.querySelector('#togglePassword');
    const passwordInput = document.querySelector('#password');

    if (togglePassword && passwordInput) {
        togglePassword.addEventListener('click', function () {
            // Thay đổi type input
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            
            // Thay đổi icon mắt
            const icon = this.querySelector('i');
            if(type === 'text') {
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            } else {
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            }
        });
    }
}

// Khởi chạy khi DOM load xong
document.addEventListener('DOMContentLoaded', function() {
    initTogglePassword();
});