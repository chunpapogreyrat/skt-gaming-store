# 📜 HIẾN PHÁP CODE — DỰ ÁN YUKI GAMING STORE (v2.0)

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

## 6. Bảo mật (Security Rules) ⚠️

> **Nguyên tắc vàng: KHÔNG BAO GIỜ tin tưởng phía client.** Mọi kiểm tra phía JS/HTML chỉ là lớp UX — bảo vệ thật **bắt buộc** nằm ở server (Laravel).

**6.1. Phân tách & phân quyền Admin**
- Khu vực admin (`/admin`) phải **tách biệt** khỏi khu khách: session/guard riêng, **không dùng chung** đăng nhập với khách.
- Phân quyền bằng cột `role` trong bảng `tai_khoans` (`Admin` / `Staff` / `Khach`).
- Gom toàn bộ route admin dưới prefix `/admin` + **Middleware** chặn server-side:
  ```php
  Route::middleware(['auth', 'can:access-admin'])->prefix('admin')->group(function () { ... });
  // Gate::define('access-admin', fn($u) => in_array($u->role, ['Admin','Staff']));
  ```
- Nhân viên (`Staff`) chỉ thấy/đụng được các module được cấp quyền (kiểm tra bằng Gate/Policy, **không chỉ ẩn link**).
- ❌ TUYỆT ĐỐI không "bảo vệ" admin chỉ bằng cách ẩn link hay redirect ở JS — client luôn bypass được.

**6.2. Tài khoản & mật khẩu**
- Mật khẩu **luôn hash** bằng `bcrypt`/`Hash::make()` — KHÔNG lưu plaintext, KHÔNG tự mã hóa thủ công.
- KHÔNG commit thông tin nhạy cảm: `.env`, key, mật khẩu DB, token → phải nằm trong `.gitignore`.
- Mật khẩu demo chỉ dùng môi trường dev, đổi ngay khi lên thật.

**6.3. Chống tấn công cơ bản (bắt buộc)**
- **CSRF**: mọi form `POST/PUT/DELETE` phải có `@csrf`.
- **SQL Injection**: chỉ dùng Eloquent / Query Builder (đã bind sẵn) — KHÔNG nối chuỗi `DB::raw()` với input người dùng.
- **XSS**: Blade dùng `{{ $var }}` (tự escape); chỉ dùng `{!! !!}` khi chắc chắn nội dung an toàn.
- **Mass Assignment**: khai báo `$fillable` rõ ràng trong Model, không dùng `$guarded = []`.
- **Validation**: mọi input qua **Form Request**, không tin dữ liệu gửi lên (kể cả field ẩn, id, giá...).

**6.4. Hiện trạng bản tĩnh (prototype)**
- Session tách: `yuki_user` (khách) ≠ `yuki_admin` (quản trị) — lưu localStorage.
- `admin/guard.js` gắn trong `<head>` mọi trang admin → chưa có `yuki_admin` thì đá về `admin/login.html`.
- ⚠️ Đây **chỉ là rào UX**. Khi lên Laravel phải thay bằng Middleware (mục 6.1).

---

## 7. Quy ước thực tế đã áp dụng cho phần Front-end

> Phần này ghi lại cách nhóm đã triển khai để giữ nhất quán.

**Design System (biến CSS gốc trong `assets/css/style.css`)**
- Màu: `--red:#ff003c` (chủ đạo), `--cyber-cyan:#00e5ff` (phụ), `--bg-dark:#0a0c10`, `--bg-panel:#16181f`.
- Font: `--font-h: Orbitron` (tiêu đề), `--font-b: Poppins` (nội dung).
- Bo góc/chuyển động: `--radius`, `--trans`.

**Thư viện**
- Dùng bản **local trong `assets/`** nếu có: Bootstrap 5.3, Owl Carousel 2.3, jQuery 3.7 (bản `.min`).
- Còn lại dùng CDN (chưa có bản local): Font Awesome 6.4, AOS 2.3, Animate.css 4.1, tsParticles (slim) 3.
- Quy tắc: **có file local thì ưu tiên local**, không gọi CDN trùng lặp.

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

**Tài khoản demo** (chỉ dev — xem mục 6 Bảo mật)
- Khách: `admin` / `12456` (trang `login.html`, session `yuki_user`).
- Quản trị: `admin` / `admin123` (trang `admin/login.html`, session `yuki_admin`).

---

## 8. Tôn trọng thiết kế (Design Fidelity) 🎨

> **Giao diện đã thiết kế là "bản hợp đồng".** Khi dựng backend Laravel, code phải phục vụ thiết kế — KHÔNG được tự ý phá vỡ công sức của người làm giao diện.

**8.1. Nguyên tắc**
- Bản HTML/CSS/JS tĩnh trong dự án này là **thiết kế chuẩn (source of truth)** về giao diện.
- Khi chuyển sang Blade/Laravel: **giữ nguyên** cấu trúc HTML, class CSS (BEM), biến màu, font, hiệu ứng. Chỉ thay phần dữ liệu tĩnh bằng `{{ $bien }}` / `@foreach`.
- ❌ KHÔNG sửa layout, đổi màu, bỏ animation, hay "code lại cho nhanh" làm khác thiết kế gốc.
- Cần thay đổi giao diện → **bàn với người thiết kế trước**, không tự quyết.

**8.2. Cách chuyển HTML → Blade đúng**
- Mỗi khối `/* #region */` → tách thành **Blade Component** (`resources/views/components/`), giữ y nguyên markup.
- Vòng lặp dữ liệu: thay 1 card mẫu bằng `@foreach`, **không đổi class/cấu trúc** của card.
- Giữ nguyên đường dẫn asset & tên class để CSS/JS hiện có chạy đúng.

**8.3. Bắt buộc check lại sau khi code (Definition of Done)**
- Sau khi gắn dữ liệu động, **mở trình duyệt so sánh trực tiếp** trang Laravel với bản thiết kế tĩnh.
- Checklist trước khi báo "xong":
  - [ ] Layout, khoảng cách, bố cục **khớp** bản thiết kế (so trên cả desktop & mobile).
  - [ ] Màu sắc, font, bo góc, đổ bóng đúng Design System (mục 7).
  - [ ] Hiệu ứng hover/animation/slider/modal **vẫn chạy** như bản tĩnh.
  - [ ] Không vỡ giao diện khi dữ liệu thật dài/ngắn/thiếu (tên dài, hết hàng, ảnh lỗi...).
  - [ ] Console **không có lỗi** JS/CSS 404.
- Nếu lệch so với thiết kế → **sửa cho khớp**, không để "tạm vậy".

---

## 9. Lời nhắn Thiết kế → Dev (Handoff) 🤝

> Gửi bạn dev sẽ dựng backend Laravel. Thiết kế đã xong & nhất quán — dưới đây là những điểm **bắt buộc nắm** để bê lên Laravel không vỡ. Đọc kèm mục 6 (Bảo mật) và mục 8 (Tôn trọng thiết kế).

**9.1. Component dùng chung — cắt 1 lần, dùng mọi nơi**
- Navbar & site-footer đã **giống hệt nhau byte-for-byte** trên 13 trang → cắt thành `<x-navbar/>` và `<x-footer/>` rồi `@include`/component. Đừng copy-paste mỗi trang.
- **Active menu**: bản tĩnh xử lý bằng JS (`initNavActive` theo tên trang). Lên Laravel nên đổi sang server-side cho chuẩn SEO: `{{ request()->routeIs('products.*') ? 'navbar__link--active' : '' }}`.
- Link danh mục đang dùng `products.html?cat=keyboard|mice|accessory|mousepad` → map sang route `route('products.index', ['cat' => 'keyboard'])`, controller lọc theo `cat`.

**9.2. JS hành vi — phải giữ chạy sau khi render động**
- `assets/js/script.js` & `admin.js` chạy dựa trên **class/id sẵn có**. Giữ nguyên `id`/class thì JS chạy tiếp, KHÔNG cần viết lại: hero slider, owl carousel (sale), AOS, tsParticles, đếm ngược, toggle mật khẩu, cart drawer, search overlay, fly-to-cart, auth double-slider, dropdown user.
- Phần tử render bằng `@foreach` vẫn phải có đúng class JS đang hook (vd `.p-card`, `.deal-card`, `.hero-card`, `.toggle-password`).

**9.3. Auth — KHÔNG tách 3 trang**
- Login/Register/Forgot nằm CHUNG 1 trang (`login.html`, hiệu ứng double-slider). Lên Laravel **giữ 1 route view**, submit bằng **AJAX/fetch** trả JSON — đừng tách 3 route redirect (sẽ mất hiệu ứng + bị delay, đúng lỗi nhóm muốn tránh).
- Admin login tách riêng (`admin/login.html`), session/guard riêng (mục 6.1).

**9.4. Dữ liệu tĩnh → động (các điểm cần bind)**
- Hero slider: `data-title` / `data-desc` / `background-image` mỗi `.hero-card` → từ bảng banner/sản phẩm nổi bật.
- Card sản phẩm, sale carousel, "CÁC HÃNG HỢP TÁC", grid featured → `@foreach` từ DB.
- Admin: bảng + modal (sản phẩm/đơn/user/coupon/danh mục/NPP/doanh thu) → CRUD thật; phân quyền nhân viên theo module (mục 6.1).
- Logo thương hiệu đối tác: **giữ màu tự nhiên** (đã bỏ grayscale) — tôn trọng nhận diện đối tác.

**9.5. Đừng đụng (trừ khi bàn với thiết kế)**
- Biến CSS gốc (`--red`, `--cyber-cyan`, `--font-h`, `--font-b`...), tên class BEM, đường dẫn `assets/`, bộ font (Rajdhani + Be Vietnam Pro), các `@keyframes`/hiệu ứng.
- Asset ưu tiên **bản local** trong `assets/` (mục 7), chỉ CDN khi không có local.

**9.6. Trước khi báo "xong" 1 trang**
- Làm theo checklist mục 8.3 (so trực tiếp với bản tĩnh, test cả mobile, console sạch lỗi).
- Mình (thiết kế) đã test responsive 375px: không trang nào tràn ngang, navbar/sidebar gập đúng, bảng cuộn trong khung. Giữ được như vậy là đạt.

> TL;DR: **Giữ markup + class + id + asset y nguyên, chỉ thay data tĩnh bằng dữ liệu DB, chặn bảo mật ở server.** Làm đúng vậy là giao diện tự khớp, JS tự chạy. Cảm ơn bạn dev! 🙌

---
*Cập nhật bởi nhóm 10 — YUKI Gaming Store.*
