# Hướng dẫn chạy YUKI Gaming Store (Laravel)

## 1. Yêu cầu môi trường
- **PHP** 8.1 trở lên (kèm extension: pdo_mysql, mbstring, openssl, fileinfo)
- **MySQL** (hoặc MariaDB) đang chạy
- **Composer** (quản lý thư viện PHP)

## 2. Cài đặt lần đầu (chỉ làm 1 lần)
```bash
# 1) Cài thư viện PHP
composer install

# 2) Tạo file cấu hình .env (nếu chưa có) và sinh khóa ứng dụng
copy .env.example .env        # Windows  (Linux/Mac: cp .env.example .env)
php artisan key:generate

# 3) Mở .env, sửa thông tin database cho đúng máy bạn:
#    DB_DATABASE=yuki_gaming_store
#    DB_USERNAME=root
#    DB_PASSWORD=

# 4) Tạo bảng + nạp dữ liệu mẫu (sản phẩm, biến thể màu, blog, tài khoản demo...)
php artisan migrate --seed
```

## 3. Mở server (mỗi lần muốn chạy)
Mở **1 cửa sổ terminal** tại thư mục dự án và chạy:
```bash
php artisan serve --host=127.0.0.1 --port=8001
```
- Truy cập: **http://127.0.0.1:8001**
- Cửa sổ terminal phải **để mở** suốt khi dùng. Bấm `Ctrl + C` để tắt server.

> Nếu máy có nhiều bản PHP, gọi thẳng đường dẫn PHP 8.1, ví dụ:
> ```bash
> "E:\nam3hk1\php\php\php-8.1.33-nts-Win32-vs16-x64\php.exe" artisan serve --host=127.0.0.1 --port=8001
> ```

## 4. Tài khoản demo (sau khi seed)
| Vai trò | Email | Mật khẩu |
|---|---|---|
| Admin | `admin@skt.test` | `Admin@12345` |
| Khách hàng | `khach@skt.test` | `User@12345` |
- Trang quản trị: **http://127.0.0.1:8001/admin** (đăng nhập bằng tài khoản admin)

## 5. Lệnh hữu ích
```bash
php artisan migrate:fresh --seed   # Xóa sạch DB & tạo lại + nạp dữ liệu mẫu
php artisan db:seed                # Nạp lại dữ liệu mẫu (không xóa bảng)
php artisan optimize:clear         # Xóa cache route/view/config khi sửa code mà không thấy đổi
php artisan route:list             # Liệt kê toàn bộ route
```

## 6. Lỗi thường gặp
- **Trang trắng / lỗi 500 sau khi sửa code:** chạy `php artisan optimize:clear`.
- **Lỗi kết nối database:** kiểm tra MySQL đã bật chưa và thông tin trong `.env`.
- **Đăng nhập báo "Email không tồn tại":** chưa seed dữ liệu → chạy `php artisan migrate --seed`.
- **Cổng 8001 đang bận:** đổi sang cổng khác, ví dụ `--port=8080`.

## 7. Cấu trúc route (tham khảo nhanh)
- `routes/web.php` — điểm vào, chỉ require 2 file dưới (không code trực tiếp).
- `routes/site.php` — phần Khách: sản phẩm, đăng nhập/đăng ký, trang cá nhân, blog, trang tĩnh.
- `routes/shop.php` — phần Mua bán & Quản trị: giỏ hàng, thanh toán, đơn hàng, khu admin.

> Mỗi dòng route trong `site.php` và `shop.php` đều có comment mô tả công dụng.
