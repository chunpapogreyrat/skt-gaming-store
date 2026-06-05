/* ==========================================
   ADMIN GUARD — chặn truy cập trang quản trị
   Đặt trong <head> mỗi trang admin (TRỪ login.html).
   Chưa đăng nhập admin → đá ngay về admin/login.html
   Lưu ý: đây là rào phía client cho bản tĩnh. Khi lên Laravel
   PHẢI chặn bằng middleware ở server (xem cuối file).
========================================== */
(function () {
    var ok = false;
    try { ok = !!localStorage.getItem('yuki_admin'); } catch (e) { ok = false; }
    if (!ok) {
        // ẩn nội dung tránh nháy rồi chuyển hướng
        document.documentElement.style.visibility = 'hidden';
        location.replace('login.html');
    }
})();
