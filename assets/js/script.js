/* =========================================
   AUTH MODULE (LOGIN & REGISTER)
========================================= */

function initTogglePassword() {
    // Lấy tất cả các nút toggle (chạy tốt cho cả 1 ô bên Login và 2 ô bên Register)
    const togglePasswordBtns = document.querySelectorAll('.toggle-password');

    togglePasswordBtns.forEach(function(btn) {
        btn.addEventListener('click', function() {
            // Tìm ô input nằm ngay trước nút bấm
            const inputField = this.previousElementSibling;
            const icon = this.querySelector('i');

            if (inputField && inputField.tagName === 'INPUT') {
                // Đảo chiều trạng thái text / password
                const type = inputField.getAttribute('type') === 'password' ? 'text' : 'password';
                inputField.setAttribute('type', type);
                
                // Đổi icon tương ứng
                if (type === 'text') {
                    icon.classList.remove('fa-eye');
                    icon.classList.add('fa-eye-slash');
                } else {
                    icon.classList.remove('fa-eye-slash');
                    icon.classList.add('fa-eye');
                }
            }
        });
    });
}

/* =========================================
   INITIALIZATION (GLOBAL)
========================================= */

document.addEventListener('DOMContentLoaded', function() {
    // Gọi hàm khởi tạo khi trang đã load xong HTML
    initTogglePassword();
    
    // Bạn có thể gọi thêm các hàm khác ở đây (ví dụ: initHeroSlider, initProductFilter...)
});