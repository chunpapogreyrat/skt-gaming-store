/* =========================================
   AUTH MODULE (LOGIN & REGISTER)
========================================= */

function initTogglePassword() {
    // Tìm tất cả các nút có class .toggle-password
    const togglePasswordBtns = document.querySelectorAll('.toggle-password');

    togglePasswordBtns.forEach(function(btn) {
        btn.addEventListener('click', function() {
            // CÁCH MỚI: Tìm thẻ cha .input-group gần nhất
            const container = this.closest('.input-group');
            if (!container) return; // Nếu không tìm thấy cha thì dừng lại
            
            // Tìm ô input và thẻ icon <i> nằm bên trong cụm đó
            const inputField = container.querySelector('input');
            const icon = this.querySelector('i');

            // Kiểm tra nếu có đủ cả input lẫn icon thì mới xử lý
            if (inputField && icon) {
                if (inputField.type === 'password') {
                    inputField.type = 'text'; // Hiện mật khẩu
                    icon.classList.remove('fa-eye');
                    icon.classList.add('fa-eye-slash'); // Đổi thành mắt gạch chéo
                } else {
                    inputField.type = 'password'; // Ẩn mật khẩu
                    icon.classList.remove('fa-eye-slash');
                    icon.classList.add('fa-eye'); // Đổi thành mắt mở
                }
            }
        });
    });
}

/* =========================================
   INITIALIZATION (GLOBAL)
========================================= */
document.addEventListener('DOMContentLoaded', function() {
    // Kích hoạt hàm khi trang đã load xong HTML
    initTogglePassword();
});