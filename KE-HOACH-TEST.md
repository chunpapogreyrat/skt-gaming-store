# 🧪 KẾ HOẠCH KIỂM THỬ — DỰ ÁN YUKI GAMING STORE

> Tài liệu QA: chiến lược + kịch bản test cho website YUKI (Laravel) theo các module M0–M9.
> Đọc kèm `KE-HOACH-MODULE.md` (module) và `HIEN-PHAP-CODE.md` (mục 6 bảo mật, mục 8.3 đối chiếu thiết kế).

---

## 1. Mục tiêu & Phạm vi

- **Mục tiêu:** đảm bảo hệ thống chạy đúng nghiệp vụ, khớp thiết kế, an toàn, mượt trên nhiều thiết bị.
- **Trong phạm vi:** chức năng frontend + admin, phân quyền, luồng mua hàng, giao diện/responsive, bảo mật cơ bản.
- **Ngoài phạm vi:** tải cao (load test quy mô lớn), thanh toán cổng thật (chỉ test giả lập COD/demo).

---

## 2. Loại kiểm thử áp dụng

| Loại | Nội dung | Công cụ |
|------|----------|---------|
| **Functional** | CRUD, luồng nghiệp vụ, validate | Thủ công + checklist |
| **UI / Đối chiếu thiết kế** | So Laravel vs `design-v1.0` | Mắt + DevTools |
| **Responsive** | 375px (mobile), 768px (tablet), 1280px (desktop) | DevTools device mode |
| **Bảo mật** | Phân quyền, CSRF, XSS, SQLi, đoán URL | Thủ công + DevTools |
| **Tương thích** | Chrome, Edge, Firefox, Safari/mobile | Nhiều trình duyệt |
| **Khả dụng (UX)** | Thông báo lỗi rõ, hiệu ứng, điều hướng | Thủ công |
| **Hồi quy (Regression)** | Chạy lại checklist sau mỗi lần sửa | Checklist mục 8 |

---

## 3. Môi trường & Dữ liệu test

- **Môi trường:** Local (`php artisan serve` + MySQL), DB seed từ `info.txt`/`import_products.sql`.
- **Trình duyệt:** Chrome (chính), Edge, Firefox, 1 thiết bị mobile thật.
- **Tài khoản demo:**
  - Khách: `admin` / `12456`
  - Quản trị: `admin` / `admin123`
  - Nên tạo thêm: 1 tài khoản **Staff** (quyền giới hạn) + 1 khách thường để test phân quyền.
- **Dữ liệu biên:** tên sản phẩm rất dài, giá = 0, tồn kho = 0, ảnh lỗi, giỏ rỗng, mã giảm hết hạn.

---

## 4. Mức độ nghiêm trọng lỗi (Severity)

| Mức | Ý nghĩa | Ví dụ |
|-----|---------|-------|
| 🔴 Critical | Chặn luồng chính / lộ bảo mật | Không đặt được hàng; khách vào được `/admin` |
| 🟠 Major | Sai nghiệp vụ quan trọng | Tính sai tổng tiền; áp mã giảm sai |
| 🟡 Minor | Lỗi nhỏ, vẫn dùng được | Lệch khoảng cách, chữ tràn nhẹ |
| ⚪ Trivial | Mỹ thuật/chính tả | Sai chính tả, icon lệch 1px |

**Quy trình báo lỗi:** Mã lỗi · Module · Bước tái hiện · Kết quả thực tế · Kết quả mong đợi · Severity · Ảnh chụp.

---

## 5. Kịch bản test theo Module

### M1 — Auth & Phân quyền 🔐
| ID | Kịch bản | Mong đợi |
|----|----------|----------|
| AUTH-01 | Đăng nhập đúng tài khoản/mật khẩu | Vào được, hiện modal chào, lưu session |
| AUTH-02 | Đăng nhập sai mật khẩu | Báo lỗi + rung form, không vào |
| AUTH-03 | Đăng ký mật khẩu ≠ xác nhận | Báo "mật khẩu không khớp" |
| AUTH-04 | Quên mật khẩu nhập email | Báo đã gửi link |
| AUTH-05 | Chuyển login↔register↔forgot | Hiệu ứng trượt/lật mượt, không reload |
| AUTH-06 | **Khách gõ thẳng `/admin/dashboard`** | **Bị đá về trang đăng nhập admin** 🔴 |
| AUTH-07 | Staff truy cập module ngoài quyền | Bị chặn (server-side) |
| AUTH-08 | Đăng xuất | Xoá session, không vào lại được trang cần đăng nhập |

### M2/M3 — Danh mục & Sản phẩm 🖱️
| ID | Kịch bản | Mong đợi |
|----|----------|----------|
| PROD-01 | Thêm sản phẩm + upload nhiều ảnh | Lưu thành công, hiện ở danh sách |
| PROD-02 | Sửa qua bấm ảnh/tên (modal) | Mở modal điền sẵn, lưu đúng |
| PROD-03 | Xoá sản phẩm | Xoá mềm, biến mất khỏi danh sách |
| PROD-04 | Lọc theo danh mục `?cat=` | Chỉ hiện đúng danh mục |
| PROD-05 | Lọc giá + sắp xếp | Kết quả đúng tiêu chí |
| PROD-06 | Tìm kiếm từ khoá có/không kết quả | Hiện kết quả / báo "không tìm thấy" |
| PROD-07 | Mở chi tiết sản phẩm | Đúng ảnh/giá/mô tả, sản phẩm liên quan |
| PROD-08 | Validate bỏ trống tên/giá | Chặn lưu, báo lỗi từng field |

### M4 — Giỏ hàng & Thanh toán 🛒
| ID | Kịch bản | Mong đợi |
|----|----------|----------|
| CART-01 | Thêm sản phẩm vào giỏ | Badge tăng, hiện trong drawer/giỏ |
| CART-02 | Tăng/giảm/xoá số lượng | Tổng tiền cập nhật đúng |
| CART-03 | Giỏ rỗng vào checkout | Chặn hoặc báo giỏ trống |
| CART-04 | Đặt hàng đầy đủ thông tin | Tạo đơn, trừ tồn kho, ra trang success |
| CART-05 | Tồn kho = 0 | Không cho mua / báo hết hàng |
| CART-06 | Bấm màn hình ở modal success | Modal đóng (không tự tắt) |

### M5 — Đơn hàng 📦
| ID | Kịch bản | Mong đợi |
|----|----------|----------|
| ORD-01 | Khách xem lịch sử đơn | Chỉ thấy đơn CỦA MÌNH |
| ORD-02 | Xem chi tiết đơn | Đúng sản phẩm/giá/trạng thái |
| ORD-03 | Admin đổi trạng thái đơn | Lưu, hiển thị trạng thái mới |
| ORD-04 | Khách A xem đơn của khách B (đổi id trên URL) | **Bị chặn** 🔴 |

### M6 — Mã giảm giá 🎟️
| ID | Kịch bản | Mong đợi |
|----|----------|----------|
| COUP-01 | Áp mã hợp lệ | Giảm đúng số tiền/% |
| COUP-02 | Mã hết hạn / hết lượt | Báo không hợp lệ |
| COUP-03 | Đơn dưới mức tối thiểu | Báo chưa đủ điều kiện |
| COUP-04 | Mã sai/không tồn tại | Báo lỗi, không giảm |

### M7/M8 — Nhà phân phối & Dashboard 📊
| ID | Kịch bản | Mong đợi |
|----|----------|----------|
| SUP-01 | CRUD nhà phân phối | Thêm/sửa/xoá đúng |
| DASH-01 | Số liệu thẻ thống kê | Khớp dữ liệu DB thật |
| DASH-02 | Lọc doanh thu theo tháng/năm | Biểu đồ + bảng đổi đúng |

### M9 — Nội dung tĩnh 📄
| ID | Kịch bản | Mong đợi |
|----|----------|----------|
| CMS-01 | Hero slider trang chủ | Ảnh ↔ nội dung khớp, tự chạy |
| CMS-02 | Gửi form liên hệ | Lưu/được xác nhận, validate email |
| CMS-03 | Truy cập URL không tồn tại | Hiện trang 404 |

---

## 6. Kiểm thử Bảo mật (bắt buộc — theo mục 6 Hiến pháp)

- [ ] Khách KHÔNG vào được `/admin/*` (chặn ở **server**, không chỉ ẩn link).
- [ ] Staff chỉ thao tác được module được cấp quyền.
- [ ] Mọi form POST có **CSRF token**.
- [ ] Nhập `<script>alert(1)</script>` vào ô input → **không bị XSS** (Blade escape).
- [ ] Nhập `' OR 1=1 --` vào tìm kiếm/login → **không SQLi** (Eloquent bind).
- [ ] Sửa `id`/`giá`/field ẩn khi submit → server **validate lại**, không tin client.
- [ ] Mật khẩu lưu DB đã **hash** (không plaintext).
- [ ] Không lộ `.env`, không in `dd()`/`console.log` ở production.

---

## 7. Kiểm thử Giao diện & Responsive

- [ ] Đối chiếu từng trang Laravel với bản tĩnh `design-v1.0` (layout, màu, font, bo góc).
- [ ] Hiệu ứng còn chạy: hero slider, owl carousel, auth slider, modal Tarik/TenZ, dropdown, hover card.
- [ ] Responsive 375 / 768 / 1280px: **không tràn ngang**, navbar gập hamburger, sidebar admin gập, bảng cuộn trong khung.
- [ ] Dữ liệu thật dài/ngắn/thiếu không vỡ layout (tên dài, hết hàng, ảnh lỗi → ảnh mặc định).
- [ ] Console không có lỗi JS / 404 asset.

---

## 8. Checklist Hồi quy (chạy lại sau mỗi lần sửa lớn)

- [ ] Đăng nhập/đăng xuất (khách + admin) OK.
- [ ] Luồng mua hàng end-to-end: xem SP → giỏ → checkout → đơn → lịch sử.
- [ ] Phân quyền admin/staff/khách còn đúng.
- [ ] Trang chủ, danh sách, chi tiết, profile hiển thị đúng.
- [ ] Responsive mobile còn ổn.
- [ ] Không phát sinh lỗi console mới.

---

## 9. Tiêu chí Vào / Ra (Entry / Exit)

- **Vào test 1 module:** code đã merge, chạy được local, có dữ liệu seed.
- **Ra (đạt):** 0 lỗi 🔴 Critical, 0 lỗi 🟠 Major chưa xử lý; lỗi 🟡/⚪ có log lại; checklist hồi quy + bảo mật PASS; giao diện khớp thiết kế.

---
*Kế hoạch kiểm thử — nhóm 10 · YUKI Gaming Store. Áp cho bản dựng từ mốc `design-v1.0`.*
