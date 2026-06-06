# 🗂️ KẾ HOẠCH MODULE — DỰ ÁN YUKI GAMING STORE (Laravel)

> Tài liệu phân tích hệ thống: chia dự án thành các **module** để dựng backend Laravel từ bộ giao diện đã thiết kế (`design-v1.0`).
> Đọc kèm `HIEN-PHAP-CODE.md` (quy tắc code, bảo mật, tôn trọng thiết kế).

---

## 1. Tổng quan hệ thống

- **Loại:** Website thương mại điện tử (gaming gear) + trang quản trị.
- **Kiến trúc:** Laravel MVC — `Controller → Service → Model`, Blade + bộ giao diện tĩnh sẵn có.
- **2 khu vực:** Khách hàng (frontend) & Quản trị (admin, có phân quyền).
- **Đã có:** 14 trang frontend + 9 trang admin (HTML/CSS/JS chuẩn) → chỉ cần "thổi hồn" dữ liệu + nghiệp vụ.

---

## 2. Bản đồ Module (tổng thể)

| # | Module | Khu vực | Ưu tiên | Phụ thuộc |
|---|--------|---------|---------|-----------|
| M0 | **Core & Layout** (nền tảng, component dùng chung) | Cả hai | 🔴 Cao nhất | — |
| M1 | **Auth & Tài khoản** (đăng nhập/ký, profile, phân quyền) | Cả hai | 🔴 Cao | M0 |
| M2 | **Danh mục** (categories) | Admin + FE | 🔴 Cao | M0 |
| M3 | **Sản phẩm** (danh sách, chi tiết, lọc, tìm kiếm) | Admin + FE | 🔴 Cao | M0, M2 |
| M4 | **Giỏ hàng & Thanh toán** (cart, checkout) | FE | 🟠 TB | M3, M1 |
| M5 | **Đơn hàng** (lịch sử, chi tiết, quản lý đơn) | Cả hai | 🟠 TB | M4 |
| M6 | **Mã giảm giá** (coupons) | Admin + FE | 🟡 Thấp | M4 |
| M7 | **Nhà phân phối** (suppliers, nhập kho) | Admin | 🟡 Thấp | M3 |
| M8 | **Dashboard & Doanh thu** (thống kê, báo cáo) | Admin | 🟡 Thấp | M3, M5 |
| M9 | **Nội dung tĩnh** (trang chủ banner, giới thiệu, liên hệ, setup) | FE | 🟡 Thấp | M0 |

---

## 3. Chi tiết từng Module

### M0 — Core & Layout 🧱
> Nền tảng kỹ thuật, làm TRƯỚC để các module khác cắm vào.
- **Việc:** cài Laravel, cấu hình `.env`/DB, layout master (`layouts/app.blade.php`, `layouts/admin.blade.php`), cắt **navbar/footer** thành component (`<x-navbar/>`, `<x-footer/>`), nạp asset (`style.css`, `script.js`, bootstrap/owl/jquery local), middleware nền, helper format tiền/ngày.
- **Trang nền:** toàn site + `404.html`.
- **DB:** bảng `migrations` mặc định.
- **Route mẫu:** `/`, fallback 404.
- **Done khi:** mở được trang chủ tĩnh chạy qua Laravel, navbar/footer là component, asset load đúng.

### M1 — Auth & Tài khoản 🔐
- **Việc:** đăng nhập / đăng ký / quên mật khẩu (giữ **1 trang** double-slider, submit AJAX); trang `profile`; **phân quyền** `Admin/Staff/Khach`; admin login riêng + middleware.
- **Trang:** `login.html` (gộp), `profile.html`, `admin/login.html`.
- **DB:** `tai_khoans` (id, ho_ten, email, password, sdt, role, trang_thai, avatar, remember_token, timestamps, SoftDeletes), `password_reset_tokens`.
- **Route:** `GET/POST /auth/login`, `/auth/register`, `/auth/forgot`, `/logout`, `GET /profile`, `/admin/login`.
- **Bảo mật:** hash bcrypt, middleware `auth` + Gate `access-admin` (mục 6 Hiến pháp).
- **Done khi:** đăng nhập đúng role vào đúng khu vực; khách không vào được `/admin`.

### M2 — Danh mục 🏷️
- **Việc:** CRUD danh mục (modal sẵn ở admin); FE: menu danh mục + lọc theo `?cat=`.
- **Trang:** `admin/categories.html`, dropdown navbar.
- **DB:** `danh_mucs` (id, ten, slug, icon, mo_ta, trang_thai, timestamps, SoftDeletes).
- **Route:** `resource /admin/categories`, FE `GET /products?cat={slug}`.
- **Done khi:** thêm/sửa/xoá danh mục; FE lọc sản phẩm theo danh mục.

### M3 — Sản phẩm 🖱️
- **Việc:** CRUD sản phẩm + upload nhiều ảnh (modal sẵn); FE danh sách (lọc giá/danh mục/sắp xếp), chi tiết, tìm kiếm, sản phẩm liên quan.
- **Trang:** `products.html`, `detail.html`, `admin/products.html`.
- **DB:** `san_phams` (id, danh_muc_id, ten, slug, thuong_hieu, mo_ta, gia_nhap, gia_ban, ton_kho, trang_thai, hashtag, timestamps, SoftDeletes); `hinh_anh_san_phams` (id, san_pham_id, duong_dan, thu_tu). Seed từ `info.txt` (mục 7 Hiến pháp).
- **Route:** `resource /admin/products`, FE `GET /products`, `GET /products/{slug}`, `GET /search`.
- **Done khi:** quản lý sản phẩm + ảnh; FE hiển thị/lọc/tìm/chi tiết đúng.

### M4 — Giỏ hàng & Thanh toán 🛒
- **Việc:** thêm/sửa/xoá giỏ (cart drawer + trang cart), áp mã giảm, tính phí ship, đặt hàng → trang thành công.
- **Trang:** `cart.html`, `checkout.html`, `order-success.html`.
- **DB:** giỏ dùng session (hoặc `gio_hangs`/`chi_tiet_gio_hangs` nếu lưu DB).
- **Route:** `GET /cart`, `POST /cart/add|update|remove`, `GET /checkout`, `POST /checkout` → tạo đơn.
- **Done khi:** đặt hàng tạo đơn thật, trừ tồn kho, ra trang success.

### M5 — Đơn hàng 📦
- **Việc:** FE lịch sử + chi tiết đơn của khách; Admin quản lý tất cả đơn, đổi trạng thái (modal sẵn).
- **Trang:** `order-history.html`, `order-detail.html`, `admin/orders.html`.
- **DB:** `don_hangs` (id, ma_don, tai_khoan_id, tong_tien, phi_ship, ma_giam_id, thanh_toan, trang_thai, dia_chi, ghi_chu, timestamps, SoftDeletes); `chi_tiet_don_hangs` (id, don_hang_id, san_pham_id, so_luong, don_gia).
- **Route:** FE `GET /orders`, `/orders/{ma_don}`; Admin `resource /admin/orders`, `PATCH /admin/orders/{id}/status`.
- **Done khi:** khách xem đơn của mình; admin đổi trạng thái đơn.

### M6 — Mã giảm giá 🎟️
- **Việc:** CRUD coupon (modal sẵn); kiểm tra & áp mã ở checkout.
- **Trang:** `admin/coupons.html` + ô nhập mã ở `checkout`.
- **DB:** `ma_giam_gias` (id, code, loai (phan_tram/so_tien), gia_tri, don_toi_thieu, so_luot, da_dung, han, trang_thai, timestamps).
- **Route:** `resource /admin/coupons`, `POST /checkout/apply-coupon`.
- **Done khi:** tạo mã; checkout áp mã đúng (kiểm tra hạn/lượt/đơn tối thiểu).

### M7 — Nhà phân phối 🚚
- **Việc:** CRUD nhà phân phối (modal sẵn); (tuỳ chọn) phiếu nhập kho cộng tồn.
- **Trang:** `admin/suppliers.html`.
- **DB:** `nha_phan_phois` (id, ten, email, sdt, quoc_gia, trang_thai, timestamps, SoftDeletes); (tuỳ chọn `phieu_nhaps`).
- **Route:** `resource /admin/suppliers`.
- **Done khi:** quản lý nhà phân phối.

### M8 — Dashboard & Doanh thu 📊
- **Việc:** thẻ thống kê (doanh thu, đơn, khách), biểu đồ doanh thu theo tháng, bảng chi tiết, lọc tháng/năm.
- **Trang:** `admin/dashboard.html`, `admin/revenue.html`.
- **DB:** truy vấn tổng hợp từ `don_hangs`, `tai_khoans`, `san_phams` (không thêm bảng).
- **Route:** `GET /admin/dashboard`, `GET /admin/revenue`.
- **Done khi:** số liệu thật, biểu đồ đúng dữ liệu.

### M9 — Nội dung tĩnh 📄
- **Việc:** hero slider trang chủ (bind banner/sản phẩm nổi bật), khối "sale trong ngày", "hãng hợp tác", trang giới thiệu/liên hệ (form gửi), góc game thủ, 404.
- **Trang:** `index.html`, `about.html`, `contact.html`, `setups.html`, `404.html`.
- **DB:** (tuỳ) `banners`, `lien_hes` (lưu form liên hệ).
- **Route:** `/`, `/about`, `/contact` (POST), `/setups`.
- **Done khi:** trang chủ + trang tĩnh chạy dữ liệu động, form liên hệ lưu được.

---

## 4. CSDL tổng thể (quan hệ chính)

```
tai_khoans 1───∞ don_hangs 1───∞ chi_tiet_don_hangs ∞───1 san_phams
danh_mucs  1───∞ san_phams  1───∞ hinh_anh_san_phams
nha_phan_phois 1───∞ san_phams (tuỳ chọn)
ma_giam_gias 1───∞ don_hangs
```
> Quy ước đặt tên & SoftDeletes: theo mục 2 & 3 Hiến pháp Code.

---

## 5. Phân chia công việc nhóm (gợi ý — 1 người 1 module chính)

| Thành viên | Module phụ trách |
|-----------|------------------|
| Bạn A (lead) | **M0 Core/Layout** + **M1 Auth/Phân quyền** |
| Bạn B | **M3 Sản phẩm** + **M2 Danh mục** |
| Bạn C | **M4 Giỏ hàng/Thanh toán** + **M6 Mã giảm giá** |
| Bạn D | **M5 Đơn hàng** + **M8 Dashboard/Doanh thu** |
| Bạn E | **M7 Nhà phân phối** + **M9 Nội dung tĩnh** |

> Mỗi người làm trên **nhánh riêng** `feature/<module>` (mục 4 Hiến pháp), không code thẳng `main`.

---

## 6. Lộ trình triển khai (theo phụ thuộc)

- **Giai đoạn 1 — Nền móng:** M0 → M1 → M2 (phải xong trước, các module khác phụ thuộc).
- **Giai đoạn 2 — Lõi bán hàng:** M3 → M4 → M5 (luồng mua hàng end-to-end).
- **Giai đoạn 3 — Bổ trợ:** M6, M7, M8, M9 (làm song song được).
- **Giai đoạn 4 — Hoàn thiện:** kiểm thử, đối chiếu giao diện (mục 8.3), bảo mật (mục 6), tối ưu.

---

## 7. Definition of Done cho MỖI module

- [ ] Chức năng CRUD/nghiệp vụ chạy đúng, validate bằng Form Request.
- [ ] Logic nằm ở Service, không nhồi Controller/Blade (mục 1).
- [ ] Giao diện **khớp bản thiết kế tĩnh**, hiệu ứng/animation còn chạy (mục 8.3).
- [ ] Bảo mật server-side: middleware/Gate, CSRF, không tin client (mục 6).
- [ ] Test responsive mobile, console không lỗi.
- [ ] Code review + merge qua Pull Request, không push thẳng `main`.

---
*Phân tích & lập kế hoạch — nhóm 10 · YUKI Gaming Store. Mốc thiết kế: tag `design-v1.0`.*
