-- ============================================================
--  YUKI Gaming Store — Database Schema
--  Chạy trong phpMyAdmin (XAMPP) hoặc MySQL Workbench
--  Encoding: UTF-8 | Engine: InnoDB
-- ============================================================

CREATE DATABASE IF NOT EXISTS yuki_gaming_store
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;

USE yuki_gaming_store;

-- ============================================================
--  #region 1. DANH MỤC SẢN PHẨM
-- ============================================================
CREATE TABLE danh_mucs (
    id          INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    ten         VARCHAR(100)        NOT NULL,
    slug        VARCHAR(110)        NOT NULL UNIQUE,
    hinh_anh    VARCHAR(255)        DEFAULT NULL,
    thu_tu      TINYINT UNSIGNED    DEFAULT 0,
    is_active   TINYINT(1)          DEFAULT 1,
    ngay_tao    TIMESTAMP           DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

INSERT INTO danh_mucs (ten, slug, thu_tu) VALUES
    ('Bàn phím',    'keyboard',  1),
    ('Chuột',       'mice',      2),
    ('Mousepad',    'mousepad',  3),
    ('Phụ kiện',    'accessory', 4);
-- #endregion

-- ============================================================
--  #region 2. THƯƠNG HIỆU
-- ============================================================
CREATE TABLE thuong_hieu (
    id          INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    ten         VARCHAR(100)    NOT NULL,
    slug        VARCHAR(110)    NOT NULL UNIQUE,
    logo        VARCHAR(255)    DEFAULT NULL,
    is_active   TINYINT(1)      DEFAULT 1
) ENGINE=InnoDB;

INSERT INTO thuong_hieu (ten, slug) VALUES
    ('Logitech',        'logitech'),
    ('Razer',           'razer'),
    ('Finalmouse',      'finalmouse'),
    ('Wooting',         'wooting'),
    ('Akko',            'akko'),
    ('Zowie',           'zowie'),
    ('Pulsar',          'pulsar'),
    ('Endgame Gear',    'endgame-gear'),
    ('Artisan',         'artisan'),
    ('Keychron',        'keychron');
-- #endregion

-- ============================================================
--  #region 3. SẢN PHẨM
-- ============================================================
CREATE TABLE san_phams (
    id                  INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    danh_muc_id         INT UNSIGNED        NOT NULL,
    thuong_hieu_id      INT UNSIGNED        NOT NULL,
    ten                 VARCHAR(200)        NOT NULL,
    slug                VARCHAR(220)        NOT NULL UNIQUE,
    mo_ta_ngan          VARCHAR(300)        DEFAULT NULL,
    mo_ta_day_du        TEXT                DEFAULT NULL,
    gia_ban             DECIMAL(12,0)       NOT NULL,
    gia_goc             DECIMAL(12,0)       DEFAULT NULL,
    so_luong_ton        INT UNSIGNED        DEFAULT 0,
    luot_xem            INT UNSIGNED        DEFAULT 0,
    luot_ban            INT UNSIGNED        DEFAULT 0,
    diem_danh_gia       DECIMAL(2,1)        DEFAULT 0.0,
    so_luong_danh_gia   INT UNSIGNED        DEFAULT 0,
    is_hot              TINYINT(1)          DEFAULT 0,
    is_sale             TINYINT(1)          DEFAULT 0,
    is_active           TINYINT(1)          DEFAULT 1,
    ngay_tao            TIMESTAMP           DEFAULT CURRENT_TIMESTAMP,
    ngay_cap_nhat       TIMESTAMP           DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    deleted_at          TIMESTAMP           NULL DEFAULT NULL,

    FOREIGN KEY (danh_muc_id)    REFERENCES danh_mucs (id),
    FOREIGN KEY (thuong_hieu_id) REFERENCES thuong_hieu (id)
) ENGINE=InnoDB;

-- Dữ liệu mẫu
INSERT INTO san_phams
    (danh_muc_id, thuong_hieu_id, ten, slug, mo_ta_ngan, gia_ban, gia_goc, so_luong_ton, is_hot, is_sale)
VALUES
    (2, 3, 'Finalmouse Starlight-12',   'finalmouse-starlight-12',  'Chuột siêu nhẹ huyền thoại',       4990000, 5490000, 15, 1, 1),
    (2, 2, 'Razer Viper V3 Pro',        'razer-viper-v3-pro',       'Flagship không dây của Razer',      3890000, NULL,    30, 1, 0),
    (1, 4, 'Wooting 60HE+',             'wooting-60he-plus',        'Bàn phím Hall Effect tốt nhất',     4290000, NULL,    20, 1, 0),
    (2, 1, 'Logitech G Pro X Superlight 2', 'logitech-gpx-sl2',     'Nhẹ nhất của Logitech',             3490000, 3890000, 45, 0, 1),
    (3, 9, 'Artisan Zero XL',           'artisan-zero-xl',          'Mousepad cao cấp từ Nhật',           890000, NULL,    50, 0, 0);
-- #endregion

-- ============================================================
--  #region 4. HÌNH ẢNH SẢN PHẨM
-- ============================================================
CREATE TABLE hinh_anh_san_pham (
    id          INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    san_pham_id INT UNSIGNED    NOT NULL,
    duong_dan   VARCHAR(255)    NOT NULL,
    thu_tu      TINYINT UNSIGNED DEFAULT 0,
    is_main     TINYINT(1)       DEFAULT 0,

    FOREIGN KEY (san_pham_id) REFERENCES san_phams (id) ON DELETE CASCADE
) ENGINE=InnoDB;
-- #endregion

-- ============================================================
--  #region 5. BIẾN THỂ SẢN PHẨM (màu sắc / phiên bản)
-- ============================================================
CREATE TABLE bien_the_san_pham (
    id              INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    san_pham_id     INT UNSIGNED        NOT NULL,
    ten_bien_the    VARCHAR(100)        NOT NULL,  -- VD: Đen, Trắng, Pink
    ma_hex          VARCHAR(7)          DEFAULT NULL,
    gia_chenh_lech  DECIMAL(12,0)       DEFAULT 0,
    so_luong_ton    INT UNSIGNED        DEFAULT 0,
    is_active       TINYINT(1)          DEFAULT 1,

    FOREIGN KEY (san_pham_id) REFERENCES san_phams (id) ON DELETE CASCADE
) ENGINE=InnoDB;

INSERT INTO bien_the_san_pham (san_pham_id, ten_bien_the, ma_hex, so_luong_ton) VALUES
    (1, 'Đen',   '#1a1a1a', 8),
    (1, 'Trắng', '#ffffff', 7),
    (2, 'Đen',   '#1a1a1a', 20),
    (2, 'Trắng', '#f5f5f5', 10),
    (4, 'Trắng', '#ffffff', 25),
    (4, 'Đen',   '#1a1a1a', 20);
-- #endregion

-- ============================================================
--  #region 6. THÔNG SỐ KỸ THUẬT
-- ============================================================
CREATE TABLE thong_so_san_pham (
    id          INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    san_pham_id INT UNSIGNED    NOT NULL,
    ten         VARCHAR(100)    NOT NULL,   -- VD: Sensor, Polling Rate
    gia_tri     VARCHAR(200)    NOT NULL,   -- VD: PAW3395, 8000Hz
    thu_tu      TINYINT UNSIGNED DEFAULT 0,

    FOREIGN KEY (san_pham_id) REFERENCES san_phams (id) ON DELETE CASCADE
) ENGINE=InnoDB;

INSERT INTO thong_so_san_pham (san_pham_id, ten, gia_tri, thu_tu) VALUES
    (1, 'Trọng lượng',   '42g',          1),
    (1, 'Sensor',        'Optical',      2),
    (1, 'Kết nối',       'Wireless 2.4G',3),
    (2, 'Sensor',        'Focus Pro 30K',1),
    (2, 'Polling Rate',  '8000Hz',       2),
    (2, 'Trọng lượng',   '54g',          3),
    (3, 'Switch',        'Hall Effect',  1),
    (3, 'Polling Rate',  '8000Hz',       2),
    (3, 'Layout',        '60%',          3);
-- #endregion

-- ============================================================
--  #region 7. TÀI KHOẢN NGƯỜI DÙNG
-- ============================================================
CREATE TABLE tai_khoans (
    id                  INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    ho_ten              VARCHAR(100)        NOT NULL,
    email               VARCHAR(150)        NOT NULL UNIQUE,
    mat_khau            VARCHAR(255)        NOT NULL,  -- bcrypt
    so_dien_thoai       VARCHAR(15)         DEFAULT NULL,
    ngay_sinh           DATE                DEFAULT NULL,
    gioi_tinh           ENUM('nam','nu','khac') DEFAULT NULL,
    avatar              VARCHAR(255)        DEFAULT NULL,
    hang_thanh_vien     ENUM('bronze','silver','gold','diamond') DEFAULT 'bronze',
    diem_tich_luy       INT UNSIGNED        DEFAULT 0,
    email_verified_at   TIMESTAMP           NULL DEFAULT NULL,
    remember_token      VARCHAR(100)        DEFAULT NULL,
    role                ENUM('customer','admin') DEFAULT 'customer',
    is_active           TINYINT(1)          DEFAULT 1,
    ngay_tao            TIMESTAMP           DEFAULT CURRENT_TIMESTAMP,
    lan_dang_nhap_cuoi  TIMESTAMP           NULL DEFAULT NULL,
    deleted_at          TIMESTAMP           NULL DEFAULT NULL
) ENGINE=InnoDB;

-- Tài khoản demo (mật khẩu: 123456 — đã hash bcrypt)
INSERT INTO tai_khoans (ho_ten, email, mat_khau, role, hang_thanh_vien, diem_tich_luy) VALUES
    ('Admin YUKI',   'admin@yuki.vn',   '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin',    'diamond', 9999),
    ('Nguyễn Văn A', 'user@yuki.vn',    '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'customer', 'gold',    1250);
-- #endregion

-- ============================================================
--  #region 8. ĐỊA CHỈ GIAO HÀNG
-- ============================================================
CREATE TABLE dia_chi (
    id              INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    tai_khoan_id    INT UNSIGNED    NOT NULL,
    ten_nguoi_nhan  VARCHAR(100)    NOT NULL,
    so_dien_thoai   VARCHAR(15)     NOT NULL,
    tinh_thanh      VARCHAR(100)    NOT NULL,
    quan_huyen      VARCHAR(100)    NOT NULL,
    phuong_xa       VARCHAR(100)    DEFAULT NULL,
    dia_chi_cu_the  VARCHAR(255)    NOT NULL,
    loai_dia_chi    ENUM('nha','cong_ty','khac') DEFAULT 'nha',
    is_mac_dinh     TINYINT(1)      DEFAULT 0,

    FOREIGN KEY (tai_khoan_id) REFERENCES tai_khoans (id) ON DELETE CASCADE
) ENGINE=InnoDB;
-- #endregion

-- ============================================================
--  #region 9. GIỎ HÀNG
-- ============================================================
CREATE TABLE gio_hang (
    id              INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    tai_khoan_id    INT UNSIGNED    NULL DEFAULT NULL,
    session_id      VARCHAR(100)    NULL DEFAULT NULL,   -- cho khách chưa đăng nhập
    ngay_tao        TIMESTAMP       DEFAULT CURRENT_TIMESTAMP,
    ngay_cap_nhat   TIMESTAMP       DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

    FOREIGN KEY (tai_khoan_id) REFERENCES tai_khoans (id) ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE chi_tiet_gio_hang (
    id              INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    gio_hang_id     INT UNSIGNED    NOT NULL,
    san_pham_id     INT UNSIGNED    NOT NULL,
    bien_the_id     INT UNSIGNED    NULL DEFAULT NULL,
    so_luong        TINYINT UNSIGNED NOT NULL DEFAULT 1,
    gia_tai_thoi_diem DECIMAL(12,0) NOT NULL,  -- snapshot giá lúc thêm vào

    FOREIGN KEY (gio_hang_id)  REFERENCES gio_hang (id) ON DELETE CASCADE,
    FOREIGN KEY (san_pham_id)  REFERENCES san_phams (id),
    FOREIGN KEY (bien_the_id)  REFERENCES bien_the_san_pham (id),
    UNIQUE KEY uq_cart_item (gio_hang_id, san_pham_id, bien_the_id)
) ENGINE=InnoDB;
-- #endregion

-- ============================================================
--  #region 10. MÃ GIẢM GIÁ
-- ============================================================
CREATE TABLE ma_giam_gia (
    id                      INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    ma_code                 VARCHAR(50)     NOT NULL UNIQUE,
    loai                    ENUM('percent','fixed') NOT NULL DEFAULT 'percent',
    gia_tri                 DECIMAL(12,0)   NOT NULL,   -- % hoặc VNĐ
    don_hang_toi_thieu      DECIMAL(12,0)   DEFAULT 0,
    giam_toi_da             DECIMAL(12,0)   DEFAULT NULL, -- giới hạn khi loại = percent
    so_lan_su_dung_toi_da   INT UNSIGNED    DEFAULT NULL, -- NULL = không giới hạn
    da_su_dung              INT UNSIGNED    DEFAULT 0,
    ngay_bat_dau            TIMESTAMP       NULL DEFAULT NULL,
    ngay_ket_thuc           TIMESTAMP       NULL DEFAULT NULL,
    is_active               TINYINT(1)      DEFAULT 1
) ENGINE=InnoDB;

INSERT INTO ma_giam_gia (ma_code, loai, gia_tri, don_hang_toi_thieu, so_lan_su_dung_toi_da) VALUES
    ('YUKISALE', 'percent', 10, 500000,  100),
    ('YUKI50',   'percent', 50, 2000000, 20),
    ('GAMING5',  'percent', 5,  0,       NULL),
    ('NEWUSER',  'fixed',   100000, 300000, 500);
-- #endregion

-- ============================================================
--  #region 11. ĐƠN HÀNG
-- ============================================================
CREATE TABLE don_hangs (
    id                      INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    ma_don                  VARCHAR(20)     NOT NULL UNIQUE,  -- #YUKI-XXXXXX
    tai_khoan_id            INT UNSIGNED    NOT NULL,
    ten_nguoi_nhan          VARCHAR(100)    NOT NULL,
    so_dien_thoai           VARCHAR(15)     NOT NULL,
    dia_chi_giao_hang       TEXT            NOT NULL,         -- snapshot địa chỉ
    trang_thai              ENUM(
                                'cho_xac_nhan',
                                'dang_dong_goi',
                                'dang_van_chuyen',
                                'da_giao',
                                'da_huy',
                                'tra_hang',
                                'hoan_tien'
                            ) DEFAULT 'cho_xac_nhan',
    phuong_thuc_giao_hang   ENUM('standard','express') DEFAULT 'standard',
    phi_giao_hang           DECIMAL(12,0)   DEFAULT 0,
    phuong_thuc_thanh_toan  ENUM('cod','momo','vnpay','bank_transfer') DEFAULT 'cod',
    trang_thai_thanh_toan   ENUM('chua_thanh_toan','da_thanh_toan','hoan_tien') DEFAULT 'chua_thanh_toan',
    ma_giam_gia_id          INT UNSIGNED    NULL DEFAULT NULL,
    tien_giam               DECIMAL(12,0)   DEFAULT 0,
    tam_tinh                DECIMAL(12,0)   NOT NULL,
    tong_tien               DECIMAL(12,0)   NOT NULL,
    ghi_chu                 TEXT            DEFAULT NULL,
    ngay_tao                TIMESTAMP       DEFAULT CURRENT_TIMESTAMP,
    ngay_cap_nhat           TIMESTAMP       DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    deleted_at              TIMESTAMP       NULL DEFAULT NULL,

    FOREIGN KEY (tai_khoan_id)   REFERENCES tai_khoans (id),
    FOREIGN KEY (ma_giam_gia_id) REFERENCES ma_giam_gia (id)
) ENGINE=InnoDB;
-- #endregion

-- ============================================================
--  #region 12. CHI TIẾT ĐƠN HÀNG
-- ============================================================
CREATE TABLE chi_tiet_don_hang (
    id              INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    don_hang_id     INT UNSIGNED    NOT NULL,
    san_pham_id     INT UNSIGNED    NOT NULL,
    bien_the_id     INT UNSIGNED    NULL DEFAULT NULL,
    ten_san_pham    VARCHAR(200)    NOT NULL,  -- snapshot tên lúc mua
    hinh_anh        VARCHAR(255)    DEFAULT NULL,
    bien_the_text   VARCHAR(100)    DEFAULT NULL,  -- snapshot "Màu Đen"
    so_luong        TINYINT UNSIGNED NOT NULL,
    don_gia         DECIMAL(12,0)   NOT NULL,
    thanh_tien      DECIMAL(12,0)   NOT NULL,

    FOREIGN KEY (don_hang_id) REFERENCES don_hangs (id) ON DELETE CASCADE,
    FOREIGN KEY (san_pham_id) REFERENCES san_phams (id)
) ENGINE=InnoDB;
-- #endregion

-- ============================================================
--  #region 13. LỊCH SỬ TRẠNG THÁI ĐƠN HÀNG
-- ============================================================
CREATE TABLE lich_su_don_hang (
    id              INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    don_hang_id     INT UNSIGNED    NOT NULL,
    trang_thai      VARCHAR(50)     NOT NULL,
    ghi_chu         VARCHAR(255)    DEFAULT NULL,
    nguoi_thay_doi  INT UNSIGNED    NULL DEFAULT NULL,  -- tai_khoan_id (admin)
    ngay_tao        TIMESTAMP       DEFAULT CURRENT_TIMESTAMP,

    FOREIGN KEY (don_hang_id)   REFERENCES don_hangs (id) ON DELETE CASCADE,
    FOREIGN KEY (nguoi_thay_doi) REFERENCES tai_khoans (id)
) ENGINE=InnoDB;
-- #endregion

-- ============================================================
--  #region 14. ĐÁNH GIÁ SẢN PHẨM
-- ============================================================
CREATE TABLE danh_gia_san_pham (
    id                      INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    san_pham_id             INT UNSIGNED        NOT NULL,
    tai_khoan_id            INT UNSIGNED        NOT NULL,
    don_hang_id             INT UNSIGNED        NULL DEFAULT NULL,  -- đã mua mới được đánh giá
    so_sao                  TINYINT UNSIGNED    NOT NULL CHECK (so_sao BETWEEN 1 AND 5),
    noi_dung                TEXT                DEFAULT NULL,
    hinh_anh                VARCHAR(255)        DEFAULT NULL,
    is_verified_purchase    TINYINT(1)          DEFAULT 0,
    is_active               TINYINT(1)          DEFAULT 1,
    ngay_tao                TIMESTAMP           DEFAULT CURRENT_TIMESTAMP,

    FOREIGN KEY (san_pham_id)  REFERENCES san_phams (id),
    FOREIGN KEY (tai_khoan_id) REFERENCES tai_khoans (id),
    FOREIGN KEY (don_hang_id)  REFERENCES don_hangs (id),
    UNIQUE KEY uq_one_review (san_pham_id, tai_khoan_id)  -- 1 người 1 đánh giá
) ENGINE=InnoDB;
-- #endregion

-- ============================================================
--  #region 15. DANH SÁCH YÊU THÍCH
-- ============================================================
CREATE TABLE danh_sach_yeu_thich (
    id              INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    tai_khoan_id    INT UNSIGNED    NOT NULL,
    san_pham_id     INT UNSIGNED    NOT NULL,
    ngay_them       TIMESTAMP       DEFAULT CURRENT_TIMESTAMP,

    FOREIGN KEY (tai_khoan_id) REFERENCES tai_khoans (id) ON DELETE CASCADE,
    FOREIGN KEY (san_pham_id)  REFERENCES san_phams (id)  ON DELETE CASCADE,
    UNIQUE KEY uq_wishlist (tai_khoan_id, san_pham_id)
) ENGINE=InnoDB;
-- #endregion

-- ============================================================
--  #region 16. TIN NHẮN LIÊN HỆ
-- ============================================================
CREATE TABLE tin_nhan_lien_he (
    id          INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    ho_ten      VARCHAR(100)    NOT NULL,
    email       VARCHAR(150)    NOT NULL,
    chu_de      ENUM(
                    'ho_tro_ky_thuat',
                    'bao_hanh',
                    'thong_tin_don_hang',
                    'hop_tac_kinh_doanh',
                    'khac'
                ) DEFAULT 'khac',
    noi_dung    TEXT            NOT NULL,
    trang_thai  ENUM('chua_xu_ly','dang_xu_ly','da_xu_ly') DEFAULT 'chua_xu_ly',
    ghi_chu_xu_ly VARCHAR(255)  DEFAULT NULL,
    ngay_gui    TIMESTAMP       DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;
-- #endregion

-- ============================================================
--  #region 17. SETUPS TRƯNG BÀY
-- ============================================================
CREATE TABLE setups_trung_bay (
    id          INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    tieu_de     VARCHAR(150)    NOT NULL,
    danh_muc    ENUM('cyberpunk','minimalist','white_build','hardcore','other') DEFAULT 'other',
    hinh_anh    VARCHAR(255)    NOT NULL,
    thu_tu      TINYINT UNSIGNED DEFAULT 0,
    is_active   TINYINT(1)      DEFAULT 1
) ENGINE=InnoDB;

CREATE TABLE hotspot_setup (
    id              INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    setup_id        INT UNSIGNED        NOT NULL,
    san_pham_id     INT UNSIGNED        NOT NULL,
    vi_tri_trai     DECIMAL(5,2)        NOT NULL,  -- % từ trái
    vi_tri_tren     DECIMAL(5,2)        NOT NULL,  -- % từ trên

    FOREIGN KEY (setup_id)    REFERENCES setups_trung_bay (id) ON DELETE CASCADE,
    FOREIGN KEY (san_pham_id) REFERENCES san_phams (id)
) ENGINE=InnoDB;
-- #endregion

-- ============================================================
--  #region 18. TRIGGERS — tự động cập nhật điểm đánh giá
-- ============================================================
DELIMITER $$

-- Cập nhật diem_danh_gia sau khi thêm đánh giá
CREATE TRIGGER after_insert_danh_gia
AFTER INSERT ON danh_gia_san_pham
FOR EACH ROW
BEGIN
    UPDATE san_phams
    SET
        diem_danh_gia     = (SELECT ROUND(AVG(so_sao), 1) FROM danh_gia_san_pham WHERE san_pham_id = NEW.san_pham_id AND is_active = 1),
        so_luong_danh_gia = (SELECT COUNT(*) FROM danh_gia_san_pham WHERE san_pham_id = NEW.san_pham_id AND is_active = 1)
    WHERE id = NEW.san_pham_id;
END$$

-- Tự tạo mã đơn hàng #YUKI-XXXXXX
CREATE TRIGGER before_insert_don_hang
BEFORE INSERT ON don_hangs
FOR EACH ROW
BEGIN
    IF NEW.ma_don IS NULL OR NEW.ma_don = '' THEN
        SET NEW.ma_don = CONCAT('#YUKI-', LPAD(FLOOR(RAND() * 999999) + 1, 6, '0'));
    END IF;
END$$

-- Trừ tồn kho khi đơn hàng được xác nhận
CREATE TRIGGER after_confirm_don_hang
AFTER UPDATE ON don_hangs
FOR EACH ROW
BEGIN
    IF OLD.trang_thai = 'cho_xac_nhan' AND NEW.trang_thai = 'dang_dong_goi' THEN
        UPDATE san_phams sp
        JOIN chi_tiet_don_hang ct ON ct.san_pham_id = sp.id
        SET sp.so_luong_ton = sp.so_luong_ton - ct.so_luong,
            sp.luot_ban     = sp.luot_ban + ct.so_luong
        WHERE ct.don_hang_id = NEW.id;
    END IF;
END$$

DELIMITER ;
-- #endregion

-- ============================================================
--  #region 19. INDEXES — tối ưu truy vấn
-- ============================================================
ALTER TABLE san_phams      ADD INDEX idx_danh_muc   (danh_muc_id);
ALTER TABLE san_phams      ADD INDEX idx_thuong_hieu (thuong_hieu_id);
ALTER TABLE san_phams      ADD INDEX idx_is_active   (is_active, deleted_at);
ALTER TABLE san_phams      ADD INDEX idx_is_hot_sale (is_hot, is_sale);
ALTER TABLE don_hangs      ADD INDEX idx_tai_khoan   (tai_khoan_id);
ALTER TABLE don_hangs      ADD INDEX idx_trang_thai  (trang_thai);
ALTER TABLE chi_tiet_gio_hang ADD INDEX idx_gio_hang (gio_hang_id);
ALTER TABLE danh_gia_san_pham ADD INDEX idx_sp_active (san_pham_id, is_active);
-- #endregion
