# 📜 HIẾN PHÁP CODE — DỰ ÁN SKT GAMING STORE (v2.0)

> Bộ quy tắc bắt buộc cho toàn nhóm. Đọc kỹ trước khi code & trước mỗi lần commit.

---

## 1. Công nghệ & Kiến trúc

**Frontend Stack**
- Dùng **HTML5 + CSS3 + JS thuần** kết hợp **Bootstrap 5**.
- KHÔNG mix các framework CSS khác (Tailwind, Bulma...).

**Kiến trúc Backend (Laravel)** — tuân thủ `Controller → Service → Model`
- Tránh "Fat Controller": đẩy toàn bộ **business logic** vào `app/Services`.
- KHÔNG viết logic nghiệp vụ hoặc query Database trực tiếp tại Controller hoặc Blade View.

**Section Block Architecture**
- Tách nhỏ các thành phần giao diện tái sử dụng (Navbar, Footer, Product Card...) vào `resources/views/components/`.
- Trong code dùng `/* #region TÊN-KHU-VỰC */ ... /* #endregion */` để bọc từng khối CSS/HTML → dễ cắt sang Blade Component sau này.

---

## 2. Tiêu chuẩn Đặt tên (Naming Convention)

| Đối tượng | Quy tắc | Ví dụ |
|---|---|---|
| Thư mục, Framework | Tiếng Anh (PascalCase / camelCase) | `Controller`, `Service`, `Middleware` |
| Nghiệp vụ (Domain) | Tiếng Việt **không dấu** | `SanPham`, `DonHang`, `ChiTietDonHang` |
| Biến (Variables) | camelCase | `$sanPham`, `$danhSachSanPham` |
| URL Routes | Tiếng Anh, **kebab-case, số nhiều** | `/products`, `/categories`, `/orders` |
| Tên File / Ảnh | **kebab-case, không dấu** | `chuot-logitech-g502.jpg` |
| Class CSS | **BEM-lite** | `.product-card`, `.product-card__image`, `.product-card--sale` |

---

## 3. Cơ sở dữ liệu (Database Rules)

- **Tên Bảng**: `snake_case` số nhiều → `san_phams`, `danh_mucs`.
- **Khóa ngoại (FK)**: chuẩn Laravel `tên_bảng_số_ít_id` → `san_pham_id`, `danh_muc_id` (tối ưu Eloquent Relationship).
- **Bảo vệ dữ liệu**: bắt buộc **SoftDeletes** (xóa mềm) cho các bảng quan trọng (`san_phams`, `don_hangs`, `tai_khoans`).
- **Validation**: KHÔNG validate trong Controller → bắt buộc dùng **Form Request**.
- **API Response**: thống nhất 3 trường → `{ "success": true, "message": "...", "data": [] }`.

---

## 4. Quy tắc làm việc nhóm (Git & Workflow)

- **Chia việc**: 1 người 1 Module chính để tránh conflict file.
- **Nhánh (Branching)**: KHÔNG code trực tiếp trên `main`. Tạo nhánh:
  - `feature/ten-chuc-nang` hoặc `bugfix/ten-loi`
- **Commit Message**: viết rõ ràng bằng **tiếng Anh** về hành động đã làm.
  - ✅ `Create product CRUD`, `Fix cart quantity bug`
  - ❌ Cấm: `fix`, `update`, `aaaa`...
- **Bảo vệ code**: luôn chạy `git diff` để rà soát trước khi commit.
- **Cập nhật hằng ngày**: `git pull origin main` vào đầu mỗi buổi làm việc.

---

## 5. Quy tắc khác

- **HTML/CSS**: dùng thẻ semantic (`<nav>`, `<header>`, `<footer>`, `<section>`...).
- **Debug**: KHÔNG để `console.log` (JS) hoặc `dd()` (PHP) ở môi trường production.
- **Comment động trong Blade**: dùng `{{-- Product List --}}` thay vì comment HTML thường (`<!-- -->`) để không lộ ra trình duyệt.

---

## 6. Quy ước thực tế đã áp dụng cho phần Front-end

> Phần này ghi lại cách nhóm đã triển khai để giữ nhất quán.

**Design System (biến CSS gốc trong `assets/css/style.css`)**
- Màu: `--red:#ff003c` (chủ đạo), `--cyber-cyan:#00e5ff` (phụ), `--bg-dark:#0a0c10`, `--bg-panel:#16181f`.
- Font: `--font-h: Orbitron` (tiêu đề), `--font-b: Poppins` (nội dung).
- Bo góc/chuyển động: `--radius`, `--trans`.

**Thư viện (CDN, không cài đặt)**
- Bootstrap 5.3, Font Awesome 6.4, Owl Carousel 2.3, AOS 2.3, Animate.css 4.1, tsParticles (slim) 3.

**Cấu trúc ảnh `assets/images/`** (đã chuẩn hóa kebab-case)
- `Products/<category>/<product-slug>/` → `1.webp, 2.webp, ...` + `info.txt`
  - category: `keyboard / mice / mousepad / accessory`
- `banners/`, `brands/`, `setups/`, `avatars/`, `icons/`, `slider/`, `users/`, `library/`.

**Schema `info.txt` mỗi sản phẩm** (chuẩn bị nhập DB, theo phong cách Phong Cách Xanh)
```
<TÊN SẢN PHẨM IN HOA>
p1 - Tên thương hiệu: ...
p2 - Tên sản phẩm: ...
p3 - Tóm tắt mô tả ngắn gọn: ...
p4 - Số lượng sao: x / 5 sao
p5 - Giá nhập và giá bán: (Giá bán + ghi chú giá nhập)
p6 - Số lượng sản phẩm: ...
p7 - Hashtag: #... #GamingGear #PhongCachXanh
p8 - Màu sắc: ...
[Dữ liệu hệ thống] slug=... | category=... | images=...
```
→ Khi seed DB: mỗi `info.txt` = 1 row bảng `san_phams`; ảnh map theo thứ tự `1.webp, 2.webp...`.

**Tài khoản demo**: `admin` / `12456`.

---
*Cập nhật bởi nhóm 10 — SKT Gaming Store.*
