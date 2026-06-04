-- ============================================================
-- SKT Gaming Store - Import 40 sản phẩm
-- Database: yuki_gaming_store
-- ============================================================
SET NAMES utf8mb4;
USE yuki_gaming_store;

-- ============================================================
-- 1. THƯƠNG HIỆU (INSERT IGNORE để không bị lỗi trùng slug)
-- ============================================================
INSERT IGNORE INTO thuong_hieu (ten, slug) VALUES
('WLMouse',       'wlmouse'),
('Incott',        'incott'),
('Lamzu',         'lamzu'),
('Fantech',       'fantech'),
('Sycrox',        'sycrox'),
('ARC',           'arc'),
('LUCE',          'luce'),
('MADE',          'made'),
('Filco',         'filco'),
('PCMK',          'pcmk'),
('Realforce',     'realforce'),
('Xpunk',         'xpunk'),
('Corepad',       'corepad'),
('ESPTiger',      'esptiger'),
('TJ Exclusives', 'tj-exclusives'),
('Unusual Way',   'unusual-way'),
('Moondrop',      'moondrop'),
('X-raypad',      'x-raypad'),
('Teevolution',   'teevolution'),
('Yuki Aim',      'yuki-aim');

-- ============================================================
-- 2. SẢN PHẨM
-- Dùng subquery để lấy danh_muc_id và thuong_hieu_id động
-- ============================================================

-- ---- CHUỘT (mice) ----
INSERT IGNORE INTO san_phams (danh_muc_id, thuong_hieu_id, ten, slug, mo_ta_ngan, gia_ban, so_luong_ton, diem_danh_gia, is_hot, is_active)
SELECT dm.id, th.id,
  'Chuột không dây WLMouse Akitsu', 'akitsu',
  'Khung magnesium siêu nhẹ, cảm biến PAW3950 hàng đầu. Kết nối không dây độ trễ cực thấp, polling cao, dáng cầm thoải mái cho những trận thi đấu kéo dài.',
  4180000, 14, 4.6, 1, 1
FROM danh_mucs dm, thuong_hieu th WHERE dm.slug='mice' AND th.slug='wlmouse';

INSERT IGNORE INTO san_phams (danh_muc_id, thuong_hieu_id, ten, slug, mo_ta_ngan, gia_ban, so_luong_ton, diem_danh_gia, is_hot, is_active)
SELECT dm.id, th.id,
  'Chuột không dây WLMouse Beast X Max (8K)', 'beast-x-max',
  'Chuột Esports siêu nhẹ với polling 8.000 Hz mượt mà. Cảm biến cao cấp, vỏ chắc chắn không ọp ẹp, dáng phù hợp nhiều kiểu cầm.',
  3750000, 20, 4.7, 1, 1
FROM danh_mucs dm, thuong_hieu th WHERE dm.slug='mice' AND th.slug='wlmouse';

INSERT IGNORE INTO san_phams (danh_muc_id, thuong_hieu_id, ten, slug, mo_ta_ngan, gia_ban, so_luong_ton, diem_danh_gia, is_hot, is_active)
SELECT dm.id, th.id,
  'Chuột Finalmouse ULX Pro (Limited)', 'finalmouse-ulx',
  'Flagship giới hạn toàn cầu của Finalmouse. Khung hợp kim magnesium siêu nhẹ, cảm biến tùy chỉnh độc quyền. Hàng cực hiếm được giới sưu tầm săn lùng.',
  5390000, 8, 4.8, 1, 1
FROM danh_mucs dm, thuong_hieu th WHERE dm.slug='mice' AND th.slug='finalmouse';

INSERT IGNORE INTO san_phams (danh_muc_id, thuong_hieu_id, ten, slug, mo_ta_ngan, gia_ban, so_luong_ton, diem_danh_gia, is_hot, is_active)
SELECT dm.id, th.id,
  'Chuột không dây Incott Frostlord', 'frostlord',
  'Chuột nhẹ, polling 8.000 Hz, cảm biến nhạy bén với mức giá hợp lý. Kết nối ổn định, lựa chọn đáng cân nhắc cho game thủ phong trào muốn nâng cấp.',
  2690000, 18, 4.4, 0, 1
FROM danh_mucs dm, thuong_hieu th WHERE dm.slug='mice' AND th.slug='incott';

INSERT IGNORE INTO san_phams (danh_muc_id, thuong_hieu_id, ten, slug, mo_ta_ngan, gia_ban, so_luong_ton, diem_danh_gia, is_hot, is_active)
SELECT dm.id, th.id,
  'Chuột không dây Lamzu Maya X (Siêu nhẹ 38g)', 'maya-x',
  'Trọng lượng chỉ khoảng 38g nhờ khung magnesium đục lỗ tinh tế. Cảm biến hàng đầu, kết nối không dây độ trễ cực thấp, dáng đối xứng.',
  2990000, 16, 4.7, 1, 1
FROM danh_mucs dm, thuong_hieu th WHERE dm.slug='mice' AND th.slug='lamzu';

INSERT IGNORE INTO san_phams (danh_muc_id, thuong_hieu_id, ten, slug, mo_ta_ngan, gia_ban, so_luong_ton, diem_danh_gia, is_hot, is_active)
SELECT dm.id, th.id,
  'Chuột Gaming Fantech Superstrike', 'superstrike',
  'Chuột gaming phổ thông giá tốt, trọng lượng nhẹ, LED RGB bắt mắt. Cảm biến ổn định, hoàn thiện chắc chắn — lý tưởng cho người mới bắt đầu.',
  890000, 45, 4.2, 0, 1
FROM danh_mucs dm, thuong_hieu th WHERE dm.slug='mice' AND th.slug='fantech';

INSERT IGNORE INTO san_phams (danh_muc_id, thuong_hieu_id, ten, slug, mo_ta_ngan, gia_ban, so_luong_ton, diem_danh_gia, is_hot, is_active)
SELECT dm.id, th.id,
  'Chuột không dây Sycrox V6', 'sycrox-v6',
  'Chuột Esports nhẹ, phản hồi nhanh, lớp phủ bám tay tốt. Kết nối ổn định, mức giá tầm trung dễ tiếp cận cho game thủ muốn lên đời không dây.',
  1450000, 30, 4.3, 0, 1
FROM danh_mucs dm, thuong_hieu th WHERE dm.slug='mice' AND th.slug='sycrox';

INSERT IGNORE INTO san_phams (danh_muc_id, thuong_hieu_id, ten, slug, mo_ta_ngan, gia_ban, so_luong_ton, diem_danh_gia, is_hot, is_active)
SELECT dm.id, th.id,
  'Chuột Finalmouse TenZ Signature', 'tenz',
  'Phiên bản chữ ký hợp tác cùng tuyển thủ TenZ huyền thoại. Bản giới hạn, kết nối không dây, thiết kế mang tính biểu tượng và cảm giác cầm cao cấp.',
  5280000, 12, 4.8, 1, 1
FROM danh_mucs dm, thuong_hieu th WHERE dm.slug='mice' AND th.slug='finalmouse';

INSERT IGNORE INTO san_phams (danh_muc_id, thuong_hieu_id, ten, slug, mo_ta_ngan, gia_ban, so_luong_ton, diem_danh_gia, is_hot, is_active)
SELECT dm.id, th.id,
  'Chuột không dây Razer Viper V4 Pro', 'viperv4pro',
  'Chuột Esports đối xứng đỉnh cao của Razer. Cảm biến Focus Pro 35K, polling 8.000 Hz, switch quang học Gen-3 — đạt chuẩn thi đấu chuyên nghiệp.',
  3990000, 24, 4.8, 1, 1
FROM danh_mucs dm, thuong_hieu th WHERE dm.slug='mice' AND th.slug='razer';

INSERT IGNORE INTO san_phams (danh_muc_id, thuong_hieu_id, ten, slug, mo_ta_ngan, gia_ban, so_luong_ton, diem_danh_gia, is_hot, is_active)
SELECT dm.id, th.id,
  'Chuột không dây Pulsar X2CL Pro (52g)', 'x2cl',
  'Trọng lượng khoảng 52g, cảm biến PAW3950, dáng đối xứng quen tay. Kết nối không dây độ trễ thấp — cân bằng hoàn hảo giữa hiệu năng và giá.',
  2490000, 28, 4.6, 1, 1
FROM danh_mucs dm, thuong_hieu th WHERE dm.slug='mice' AND th.slug='pulsar';

-- ---- BÀN PHÍM (keyboard) ----
INSERT IGNORE INTO san_phams (danh_muc_id, thuong_hieu_id, ten, slug, mo_ta_ngan, gia_ban, so_luong_ton, diem_danh_gia, is_hot, is_active)
SELECT dm.id, th.id,
  'Bàn phím cơ Custom ARC65 (Layout 65%)', 'arc65',
  'Bàn phím custom 65% gasket mount cảm giác gõ êm và nảy. Hỗ trợ hot-swap, foam tiêu âm cho tiếng gõ thock dễ chịu, LED RGB per-key rực rỡ.',
  1990000, 30, 4.5, 0, 1
FROM danh_mucs dm, thuong_hieu th WHERE dm.slug='keyboard' AND th.slug='arc';

INSERT IGNORE INTO san_phams (danh_muc_id, thuong_hieu_id, ten, slug, mo_ta_ngan, gia_ban, so_luong_ton, diem_danh_gia, is_hot, is_active)
SELECT dm.id, th.id,
  'Bàn phím cơ AKKO Centauri', 'centauri',
  'Kết nối tri-mode (có dây / Bluetooth / 2.4GHz) tiện lợi mọi thiết bị. Keycap PBT bền màu, hot-swap dễ nâng cấp, pin trâu, phối màu cá tính.',
  2490000, 40, 4.6, 1, 1
FROM danh_mucs dm, thuong_hieu th WHERE dm.slug='keyboard' AND th.slug='akko';

INSERT IGNORE INTO san_phams (danh_muc_id, thuong_hieu_id, ten, slug, mo_ta_ngan, gia_ban, so_luong_ton, diem_danh_gia, is_hot, is_active)
SELECT dm.id, th.id,
  'Bàn phím cơ Razer Huntsman Mini Niko Edition', 'huntsman-niko',
  'Phiên bản nghệ thuật giới hạn của Razer. Switch quang học Gen-2, layout 60% gọn gàng, đèn RGB Chroma rực rỡ — sản phẩm sưu tầm đáng giá.',
  2990000, 15, 4.7, 1, 1
FROM danh_mucs dm, thuong_hieu th WHERE dm.slug='keyboard' AND th.slug='razer';

INSERT IGNORE INTO san_phams (danh_muc_id, thuong_hieu_id, ten, slug, mo_ta_ngan, gia_ban, so_luong_ton, diem_danh_gia, is_hot, is_active)
SELECT dm.id, th.id,
  'Bàn phím Custom LUCE60 (Layout 60%)', 'luce60',
  'Khung nhôm CNC nguyên khối, gasket mount cho độ nảy êm ái, trọng lượng đầm tay sang trọng. Hỗ trợ hot-swap, build cao cấp cho dân chơi custom.',
  2500000, 20, 4.6, 1, 1
FROM danh_mucs dm, thuong_hieu th WHERE dm.slug='keyboard' AND th.slug='luce';

INSERT IGNORE INTO san_phams (danh_muc_id, thuong_hieu_id, ten, slug, mo_ta_ngan, gia_ban, so_luong_ton, diem_danh_gia, is_hot, is_active)
SELECT dm.id, th.id,
  'Bàn phím MADE68 Ultra V2 (Hall Effect)', 'made68-ultra-v2',
  'Layout 65% với công nghệ Hall Effect. Rapid Trigger và điều chỉnh actuation, polling 8.000 Hz, socket nam châm hot-swap. Giá tốt cho game thủ FPS.',
  2290000, 35, 4.5, 0, 1
FROM danh_mucs dm, thuong_hieu th WHERE dm.slug='keyboard' AND th.slug='made';

INSERT IGNORE INTO san_phams (danh_muc_id, thuong_hieu_id, ten, slug, mo_ta_ngan, gia_ban, so_luong_ton, diem_danh_gia, is_hot, is_active)
SELECT dm.id, th.id,
  'Bàn phím cơ Filco Majestouch 2 (TKL)', 'majestouch',
  'Tượng đài bàn phím cơ Cherry MX nguyên bản với độ bền huyền thoại. Layout TKL tiết kiệm không gian, cảm giác gõ chắc chắn và ổn định.',
  2990000, 18, 4.7, 1, 1
FROM danh_mucs dm, thuong_hieu th WHERE dm.slug='keyboard' AND th.slug='filco';

INSERT IGNORE INTO san_phams (danh_muc_id, thuong_hieu_id, ten, slug, mo_ta_ngan, gia_ban, so_luong_ton, diem_danh_gia, is_hot, is_active)
SELECT dm.id, th.id,
  'Bộ Barebone Bàn phím PCMK Custom (Layout 65%)', 'pcmk',
  'Bộ khung barebone gasket nhôm — nền tảng lý tưởng để tự build bàn phím. Hỗ trợ hot-swap, foam tiêu âm; cần lắp thêm switch và keycap.',
  3200000, 12, 4.4, 0, 1
FROM danh_mucs dm, thuong_hieu th WHERE dm.slug='keyboard' AND th.slug='pcmk';

INSERT IGNORE INTO san_phams (danh_muc_id, thuong_hieu_id, ten, slug, mo_ta_ngan, gia_ban, so_luong_ton, diem_danh_gia, is_hot, is_active)
SELECT dm.id, th.id,
  'Bàn phím Topre Realforce R4S TKL', 'realforce-r4',
  'Switch tĩnh điện Topre 45g cao cấp từ Nhật Bản, cảm giác gõ êm mượt không lẫn vào đâu. Công nghệ APC chỉnh điểm nhận phím, độ chính xác tuyệt đối.',
  4990000, 10, 4.9, 1, 1
FROM danh_mucs dm, thuong_hieu th WHERE dm.slug='keyboard' AND th.slug='realforce';

INSERT IGNORE INTO san_phams (danh_muc_id, thuong_hieu_id, ten, slug, mo_ta_ngan, gia_ban, so_luong_ton, diem_danh_gia, is_hot, is_active)
SELECT dm.id, th.id,
  'Bàn phím cơ Wooting 60HE Analog (Layout 60%)', 'wooting',
  'Dòng bàn phím Hall Effect huyền thoại dẫn đầu Esports. Rapid Trigger, polling 8.000 Hz gần như tức thời. Lý tưởng cho FPS như Valorant, CS2.',
  6710000, 25, 4.8, 1, 1
FROM danh_mucs dm, thuong_hieu th WHERE dm.slug='keyboard' AND th.slug='wooting';

INSERT IGNORE INTO san_phams (danh_muc_id, thuong_hieu_id, ten, slug, mo_ta_ngan, gia_ban, so_luong_ton, diem_danh_gia, is_hot, is_active)
SELECT dm.id, th.id,
  'Bàn phím cơ Xpunk Custom (Layout 75%)', 'xpunk',
  'Layout 75% kèm núm xoay (knob) tiện lợi. Gasket mount cảm giác gõ tốt, LED RGB sáng, thiết kế trẻ trung cá tính, hot-swap dễ nâng cấp.',
  2200000, 22, 4.5, 0, 1
FROM danh_mucs dm, thuong_hieu th WHERE dm.slug='keyboard' AND th.slug='xpunk';

-- ---- PHỤ KIỆN (accessory) ----
INSERT IGNORE INTO san_phams (danh_muc_id, thuong_hieu_id, ten, slug, mo_ta_ngan, gia_ban, so_luong_ton, diem_danh_gia, is_hot, is_active)
SELECT dm.id, th.id,
  'Feet chuột Corepad Skatez CTRL Dots (8.5mm - 9.5mm)', 'corepad-ctrl-dots',
  'Feet tròn PTFE nguyên chất 100% dòng CTRL từ Corepad Đức. Bề mặt xử lý nhiệt tăng ma sát, mang lại stopping power tối đa cho game thủ FPS.',
  250000, 30, 4.9, 1, 1
FROM danh_mucs dm, thuong_hieu th WHERE dm.slug='accessory' AND th.slug='corepad';

INSERT IGNORE INTO san_phams (danh_muc_id, thuong_hieu_id, ten, slug, mo_ta_ngan, gia_ban, so_luong_ton, diem_danh_gia, is_hot, is_active)
SELECT dm.id, th.id,
  'Grip chuột Corepad PXP Grips', 'corepad-pxp-grips',
  'Miếng dán grip chống trượt cao cấp của Corepad, tăng độ bám khi tay đổ mồ hôi. Chất liệu thấm hút tốt, cắt sẵn theo form chuột phổ biến.',
  258000, 50, 4.6, 1, 1
FROM danh_mucs dm, thuong_hieu th WHERE dm.slug='accessory' AND th.slug='corepad';

INSERT IGNORE INTO san_phams (danh_muc_id, thuong_hieu_id, ten, slug, mo_ta_ngan, gia_ban, so_luong_ton, diem_danh_gia, is_hot, is_active)
SELECT dm.id, th.id,
  'Feet chuột ESPTiger Oriole', 'esptiger-oriole',
  'Feet chuột PTFE cao cấp với bo cạnh được mài mịn, cảm giác lướt êm và độ bền ấn tượng. Nâng cấp đáng giá cho trải nghiệm di chuột trên mọi pad.',
  242000, 55, 4.5, 0, 1
FROM danh_mucs dm, thuong_hieu th WHERE dm.slug='accessory' AND th.slug='esptiger';

INSERT IGNORE INTO san_phams (danh_muc_id, thuong_hieu_id, ten, slug, mo_ta_ngan, gia_ban, so_luong_ton, diem_danh_gia, is_hot, is_active)
SELECT dm.id, th.id,
  'Feet chuột ESPTiger YanZi', 'esptiger-yanzi',
  'Feet chuột thiên tốc độ, glide nhanh nhờ PTFE nguyên chất, hoàn thiện tỉ mỉ. Lựa chọn cho game thủ yêu thích cảm giác lướt mượt và nhanh.',
  197000, 48, 4.6, 1, 1
FROM danh_mucs dm, thuong_hieu th WHERE dm.slug='accessory' AND th.slug='esptiger';

INSERT IGNORE INTO san_phams (danh_muc_id, thuong_hieu_id, ten, slug, mo_ta_ngan, gia_ban, so_luong_ton, diem_danh_gia, is_hot, is_active)
SELECT dm.id, th.id,
  'Tay áo Pulsar eS Arm Sleeve', 'pulsar-es-arm-sleeve',
  'Tay áo chống bám giúp cẳng tay di chuyển mượt mà trên mặt bàn, hạn chế ma sát khi aim. Chất liệu thoáng khí, co giãn ôm tay.',
  550000, 40, 4.4, 0, 1
FROM danh_mucs dm, thuong_hieu th WHERE dm.slug='accessory' AND th.slug='pulsar';

INSERT IGNORE INTO san_phams (danh_muc_id, thuong_hieu_id, ten, slug, mo_ta_ngan, gia_ban, so_luong_ton, diem_danh_gia, is_hot, is_active)
SELECT dm.id, th.id,
  'Grip chuột Pulsar Supergrip', 'pulsar-supergrip',
  'Grip tape pre-cut chống trượt của Pulsar, tăng độ bám rõ rệt. Cắt sẵn theo form, dễ dán, cải thiện kiểm soát mà không làm dày chuột.',
  258000, 50, 4.7, 1, 1
FROM danh_mucs dm, thuong_hieu th WHERE dm.slug='accessory' AND th.slug='pulsar';

INSERT IGNORE INTO san_phams (danh_muc_id, thuong_hieu_id, ten, slug, mo_ta_ngan, gia_ban, so_luong_ton, diem_danh_gia, is_hot, is_active)
SELECT dm.id, th.id,
  'Tay áo Pulsar x PRX Arm Sleeve (Collab)', 'pulsar-x-prx-arm-sleeve',
  'Phiên bản hợp tác đặc biệt giữa Pulsar và tổ chức Esports PRX. Tay áo thoáng mượt, mang đậm dấu ấn đội tuyển dành cho fan.',
  590000, 30, 4.5, 0, 1
FROM danh_mucs dm, thuong_hieu th WHERE dm.slug='accessory' AND th.slug='pulsar';

INSERT IGNORE INTO san_phams (danh_muc_id, thuong_hieu_id, ten, slug, mo_ta_ngan, gia_ban, so_luong_ton, diem_danh_gia, is_hot, is_active)
SELECT dm.id, th.id,
  'Feet chuột TJ Exclusives PlastiX Dots', 'tj-exclusives-plastix-dots',
  'Feet nhựa dạng chấm tròn cho khả năng kiểm soát tốt, lắp đặt dễ dàng. Giá hợp lý, phù hợp người chơi thiên control muốn tùy biến linh hoạt.',
  200000, 35, 4.4, 0, 1
FROM danh_mucs dm, thuong_hieu th WHERE dm.slug='accessory' AND th.slug='tj-exclusives';

INSERT IGNORE INTO san_phams (danh_muc_id, thuong_hieu_id, ten, slug, mo_ta_ngan, gia_ban, so_luong_ton, diem_danh_gia, is_hot, is_active)
SELECT dm.id, th.id,
  'Feet chuột Unusual Way Black Fox', 'unusual-way-black-fox',
  'Feet premium thiên control, cảm giác glide êm và độ bền cao. Thương hiệu được cộng đồng đánh giá tốt về chất lượng hoàn thiện và sự ổn định.',
  220000, 28, 4.5, 0, 1
FROM danh_mucs dm, thuong_hieu th WHERE dm.slug='accessory' AND th.slug='unusual-way';

INSERT IGNORE INTO san_phams (danh_muc_id, thuong_hieu_id, ten, slug, mo_ta_ngan, gia_ban, so_luong_ton, diem_danh_gia, is_hot, is_active)
SELECT dm.id, th.id,
  'Feet chuột Unusual Way Silver Fox', 'unusual-way-silver-fox',
  'Feet premium thiên speed, glide nhanh nhờ PTFE nguyên chất, hoàn thiện cao cấp. Lựa chọn cho người chơi ưa tốc độ và sự tinh tế.',
  220000, 26, 4.5, 0, 1
FROM danh_mucs dm, thuong_hieu th WHERE dm.slug='accessory' AND th.slug='unusual-way';

-- ---- LÓT CHUỘT (mousepad) ----
INSERT IGNORE INTO san_phams (danh_muc_id, thuong_hieu_id, ten, slug, mo_ta_ngan, gia_ban, so_luong_ton, diem_danh_gia, is_hot, is_active)
SELECT dm.id, th.id,
  'Lót chuột Artisan Hayate Otsu V2', 'hayate-otsu-v2',
  'Pad control cao cấp từ Nhật Bản. Bề mặt mịn cho độ kiểm soát chuẩn xác, đế cao su bám chắc, đường may bền bỉ. Lựa chọn của tuyển thủ chuyên nghiệp.',
  1490000, 20, 4.7, 1, 1
FROM danh_mucs dm, thuong_hieu th WHERE dm.slug='mousepad' AND th.slug='artisan';

INSERT IGNORE INTO san_phams (danh_muc_id, thuong_hieu_id, ten, slug, mo_ta_ngan, gia_ban, so_luong_ton, diem_danh_gia, is_hot, is_active)
SELECT dm.id, th.id,
  'Lót chuột Artisan Hien', 'hien',
  'Pad thiên speed với bề mặt lướt nhanh và mượt mà, mang chất lượng Artisan trứ danh. Phù hợp người thích di chuột tốc độ cao, phản xạ tức thời.',
  1320000, 18, 4.7, 1, 1
FROM danh_mucs dm, thuong_hieu th WHERE dm.slug='mousepad' AND th.slug='artisan';

INSERT IGNORE INTO san_phams (danh_muc_id, thuong_hieu_id, ten, slug, mo_ta_ngan, gia_ban, so_luong_ton, diem_danh_gia, is_hot, is_active)
SELECT dm.id, th.id,
  'Lót chuột Moondrop Neon V2 (XL)', 'neon-v2-moondrop',
  'Pad control dày 4mm êm tay, kích thước XL phủ kín mặt bàn. Đường may chắc chống sờn, đế chống trượt, mức giá hợp lý cho trải nghiệm cao cấp.',
  890000, 25, 4.5, 0, 1
FROM danh_mucs dm, thuong_hieu th WHERE dm.slug='mousepad' AND th.slug='moondrop';

INSERT IGNORE INTO san_phams (danh_muc_id, thuong_hieu_id, ten, slug, mo_ta_ngan, gia_ban, so_luong_ton, diem_danh_gia, is_hot, is_active)
SELECT dm.id, th.id,
  'Lót chuột X-raypad Saturn Pro (XL)', 'saturn-pro',
  'Pad balanced cân bằng giữa tốc độ và kiểm soát. Viền khâu bền, đế cao su chống trượt, kích thước XL rộng rãi cho mọi DPI.',
  650000, 30, 4.5, 0, 1
FROM danh_mucs dm, thuong_hieu th WHERE dm.slug='mousepad' AND th.slug='x-raypad';

INSERT IGNORE INTO san_phams (danh_muc_id, thuong_hieu_id, ten, slug, mo_ta_ngan, gia_ban, so_luong_ton, diem_danh_gia, is_hot, is_active)
SELECT dm.id, th.id,
  'Lót chuột Teevolution Gravis (Hybrid)', 'teevolution-gravis',
  'Bề mặt hybrid mượt như kính nhưng vẫn giữ được độ kiểm soát. Tốc độ glide cao, dễ vệ sinh — phù hợp người thích cảm giác nhanh mà chính xác.',
  720000, 22, 4.4, 0, 1
FROM danh_mucs dm, thuong_hieu th WHERE dm.slug='mousepad' AND th.slug='teevolution';

INSERT IGNORE INTO san_phams (danh_muc_id, thuong_hieu_id, ten, slug, mo_ta_ngan, gia_ban, so_luong_ton, diem_danh_gia, is_hot, is_active)
SELECT dm.id, th.id,
  'Lót chuột Type99 (Hybrid XL)', 'type99',
  'Pad hybrid kích thước XL cân bằng tốc độ và kiểm soát. Viền khâu chắc, đế cao su bám tốt, giá hợp lý cho game thủ phổ thông.',
  750000, 26, 4.3, 0, 1
FROM danh_mucs dm, thuong_hieu th WHERE dm.slug='mousepad' AND th.slug='wlmouse';

INSERT IGNORE INTO san_phams (danh_muc_id, thuong_hieu_id, ten, slug, mo_ta_ngan, gia_ban, so_luong_ton, diem_danh_gia, is_hot, is_active)
SELECT dm.id, th.id,
  'Lót chuột Kính WLMouse Qisha Glass', 'wl-qisha',
  'Pad kính cao cấp cho tốc độ glide cực nhanh, bề mặt đồng nhất. Độ bền cao, dễ lau chùi — dành cho người ưa tốc độ tối đa và sự ổn định.',
  990000, 15, 4.6, 1, 1
FROM danh_mucs dm, thuong_hieu th WHERE dm.slug='mousepad' AND th.slug='wlmouse';

INSERT IGNORE INTO san_phams (danh_muc_id, thuong_hieu_id, ten, slug, mo_ta_ngan, gia_ban, so_luong_ton, diem_danh_gia, is_hot, is_active)
SELECT dm.id, th.id,
  'Lót chuột Yuki Aim Demon1 (Limited)', 'yuki-aim-demon1',
  'Pad control bản giới hạn với thiết kế premium được cộng đồng săn đón. Đường may cao cấp, đế bám chắc, bề mặt kiểm soát chuẩn xác — đẳng cấp Yuki Aim.',
  1640000, 14, 4.8, 1, 1
FROM danh_mucs dm, thuong_hieu th WHERE dm.slug='mousepad' AND th.slug='yuki-aim';

INSERT IGNORE INTO san_phams (danh_muc_id, thuong_hieu_id, ten, slug, mo_ta_ngan, gia_ban, so_luong_ton, diem_danh_gia, is_hot, is_active)
SELECT dm.id, th.id,
  'Lót chuột Yuki Aim Monokuro (Limited)', 'yuki-aim-monokuro',
  'Pad balanced bản giới hạn theo phong cách trắng-đen tối giản. Chất lượng hoàn thiện cao cấp, hàng hiếm được nhiều game thủ yêu thích sưu tầm.',
  1430000, 12, 4.8, 1, 1
FROM danh_mucs dm, thuong_hieu th WHERE dm.slug='mousepad' AND th.slug='yuki-aim';

INSERT IGNORE INTO san_phams (danh_muc_id, thuong_hieu_id, ten, slug, mo_ta_ngan, gia_ban, so_luong_ton, diem_danh_gia, is_hot, is_active)
SELECT dm.id, th.id,
  'Lót chuột Yuki Aim Oni (Limited)', 'yuki-aim-oni',
  'Phiên bản Oni premium với màu sắc nổi bật, cực kỳ hiếm. Bề mặt control cao cấp, hoàn thiện tỉ mỉ — món đồ được giới sưu tầm Esports khao khát.',
  1320000, 10, 4.9, 1, 1
FROM danh_mucs dm, thuong_hieu th WHERE dm.slug='mousepad' AND th.slug='yuki-aim';

-- ============================================================
-- 3. HÌNH ẢNH SẢN PHẨM
-- ============================================================

-- Helper: insert images by slug lookup
-- Format: assets/images/products/{category}/{slug}/{n}.webp

-- MICE
INSERT IGNORE INTO hinh_anh_san_pham (san_pham_id, duong_dan, thu_tu, is_main)
SELECT id, 'assets/images/products/mice/akitsu/1.webp', 1, 1 FROM san_phams WHERE slug='akitsu';
INSERT IGNORE INTO hinh_anh_san_pham (san_pham_id, duong_dan, thu_tu, is_main)
SELECT id, 'assets/images/products/mice/akitsu/2.webp', 2, 0 FROM san_phams WHERE slug='akitsu';
INSERT IGNORE INTO hinh_anh_san_pham (san_pham_id, duong_dan, thu_tu, is_main)
SELECT id, 'assets/images/products/mice/akitsu/3.webp', 3, 0 FROM san_phams WHERE slug='akitsu';

INSERT IGNORE INTO hinh_anh_san_pham (san_pham_id, duong_dan, thu_tu, is_main)
SELECT id, 'assets/images/products/mice/beast-x-max/1.webp', 1, 1 FROM san_phams WHERE slug='beast-x-max';
INSERT IGNORE INTO hinh_anh_san_pham (san_pham_id, duong_dan, thu_tu, is_main)
SELECT id, 'assets/images/products/mice/beast-x-max/2.webp', 2, 0 FROM san_phams WHERE slug='beast-x-max';
INSERT IGNORE INTO hinh_anh_san_pham (san_pham_id, duong_dan, thu_tu, is_main)
SELECT id, 'assets/images/products/mice/beast-x-max/3.webp', 3, 0 FROM san_phams WHERE slug='beast-x-max';

INSERT IGNORE INTO hinh_anh_san_pham (san_pham_id, duong_dan, thu_tu, is_main)
SELECT id, 'assets/images/products/mice/finalmouse-ulx/1.webp', 1, 1 FROM san_phams WHERE slug='finalmouse-ulx';
INSERT IGNORE INTO hinh_anh_san_pham (san_pham_id, duong_dan, thu_tu, is_main)
SELECT id, 'assets/images/products/mice/finalmouse-ulx/2.webp', 2, 0 FROM san_phams WHERE slug='finalmouse-ulx';
INSERT IGNORE INTO hinh_anh_san_pham (san_pham_id, duong_dan, thu_tu, is_main)
SELECT id, 'assets/images/products/mice/finalmouse-ulx/3.webp', 3, 0 FROM san_phams WHERE slug='finalmouse-ulx';
INSERT IGNORE INTO hinh_anh_san_pham (san_pham_id, duong_dan, thu_tu, is_main)
SELECT id, 'assets/images/products/mice/finalmouse-ulx/4.webp', 4, 0 FROM san_phams WHERE slug='finalmouse-ulx';
INSERT IGNORE INTO hinh_anh_san_pham (san_pham_id, duong_dan, thu_tu, is_main)
SELECT id, 'assets/images/products/mice/finalmouse-ulx/5.webp', 5, 0 FROM san_phams WHERE slug='finalmouse-ulx';

INSERT IGNORE INTO hinh_anh_san_pham (san_pham_id, duong_dan, thu_tu, is_main)
SELECT id, 'assets/images/products/mice/frostlord/1.webp', 1, 1 FROM san_phams WHERE slug='frostlord';
INSERT IGNORE INTO hinh_anh_san_pham (san_pham_id, duong_dan, thu_tu, is_main)
SELECT id, 'assets/images/products/mice/frostlord/2.webp', 2, 0 FROM san_phams WHERE slug='frostlord';
INSERT IGNORE INTO hinh_anh_san_pham (san_pham_id, duong_dan, thu_tu, is_main)
SELECT id, 'assets/images/products/mice/frostlord/3.webp', 3, 0 FROM san_phams WHERE slug='frostlord';

INSERT IGNORE INTO hinh_anh_san_pham (san_pham_id, duong_dan, thu_tu, is_main)
SELECT id, 'assets/images/products/mice/maya-x/1.webp', 1, 1 FROM san_phams WHERE slug='maya-x';
INSERT IGNORE INTO hinh_anh_san_pham (san_pham_id, duong_dan, thu_tu, is_main)
SELECT id, 'assets/images/products/mice/maya-x/2.webp', 2, 0 FROM san_phams WHERE slug='maya-x';
INSERT IGNORE INTO hinh_anh_san_pham (san_pham_id, duong_dan, thu_tu, is_main)
SELECT id, 'assets/images/products/mice/maya-x/3.webp', 3, 0 FROM san_phams WHERE slug='maya-x';

INSERT IGNORE INTO hinh_anh_san_pham (san_pham_id, duong_dan, thu_tu, is_main)
SELECT id, 'assets/images/products/mice/superstrike/1.webp', 1, 1 FROM san_phams WHERE slug='superstrike';
INSERT IGNORE INTO hinh_anh_san_pham (san_pham_id, duong_dan, thu_tu, is_main)
SELECT id, 'assets/images/products/mice/superstrike/2.webp', 2, 0 FROM san_phams WHERE slug='superstrike';
INSERT IGNORE INTO hinh_anh_san_pham (san_pham_id, duong_dan, thu_tu, is_main)
SELECT id, 'assets/images/products/mice/superstrike/3.webp', 3, 0 FROM san_phams WHERE slug='superstrike';

INSERT IGNORE INTO hinh_anh_san_pham (san_pham_id, duong_dan, thu_tu, is_main)
SELECT id, 'assets/images/products/mice/sycrox-v6/1.webp', 1, 1 FROM san_phams WHERE slug='sycrox-v6';
INSERT IGNORE INTO hinh_anh_san_pham (san_pham_id, duong_dan, thu_tu, is_main)
SELECT id, 'assets/images/products/mice/sycrox-v6/2.webp', 2, 0 FROM san_phams WHERE slug='sycrox-v6';
INSERT IGNORE INTO hinh_anh_san_pham (san_pham_id, duong_dan, thu_tu, is_main)
SELECT id, 'assets/images/products/mice/sycrox-v6/3.webp', 3, 0 FROM san_phams WHERE slug='sycrox-v6';

INSERT IGNORE INTO hinh_anh_san_pham (san_pham_id, duong_dan, thu_tu, is_main)
SELECT id, 'assets/images/products/mice/tenz/1.webp', 1, 1 FROM san_phams WHERE slug='tenz';
INSERT IGNORE INTO hinh_anh_san_pham (san_pham_id, duong_dan, thu_tu, is_main)
SELECT id, 'assets/images/products/mice/tenz/2.webp', 2, 0 FROM san_phams WHERE slug='tenz';
INSERT IGNORE INTO hinh_anh_san_pham (san_pham_id, duong_dan, thu_tu, is_main)
SELECT id, 'assets/images/products/mice/tenz/3.webp', 3, 0 FROM san_phams WHERE slug='tenz';

INSERT IGNORE INTO hinh_anh_san_pham (san_pham_id, duong_dan, thu_tu, is_main)
SELECT id, 'assets/images/products/mice/viperv4pro/1.webp', 1, 1 FROM san_phams WHERE slug='viperv4pro';
INSERT IGNORE INTO hinh_anh_san_pham (san_pham_id, duong_dan, thu_tu, is_main)
SELECT id, 'assets/images/products/mice/viperv4pro/2.webp', 2, 0 FROM san_phams WHERE slug='viperv4pro';
INSERT IGNORE INTO hinh_anh_san_pham (san_pham_id, duong_dan, thu_tu, is_main)
SELECT id, 'assets/images/products/mice/viperv4pro/3.webp', 3, 0 FROM san_phams WHERE slug='viperv4pro';

INSERT IGNORE INTO hinh_anh_san_pham (san_pham_id, duong_dan, thu_tu, is_main)
SELECT id, 'assets/images/products/mice/x2cl/1.webp', 1, 1 FROM san_phams WHERE slug='x2cl';
INSERT IGNORE INTO hinh_anh_san_pham (san_pham_id, duong_dan, thu_tu, is_main)
SELECT id, 'assets/images/products/mice/x2cl/2.webp', 2, 0 FROM san_phams WHERE slug='x2cl';
INSERT IGNORE INTO hinh_anh_san_pham (san_pham_id, duong_dan, thu_tu, is_main)
SELECT id, 'assets/images/products/mice/x2cl/3.webp', 3, 0 FROM san_phams WHERE slug='x2cl';

-- KEYBOARD
INSERT IGNORE INTO hinh_anh_san_pham (san_pham_id, duong_dan, thu_tu, is_main)
SELECT id, 'assets/images/products/keyboard/arc65/1.webp', 1, 1 FROM san_phams WHERE slug='arc65';
INSERT IGNORE INTO hinh_anh_san_pham (san_pham_id, duong_dan, thu_tu, is_main)
SELECT id, 'assets/images/products/keyboard/arc65/2.webp', 2, 0 FROM san_phams WHERE slug='arc65';
INSERT IGNORE INTO hinh_anh_san_pham (san_pham_id, duong_dan, thu_tu, is_main)
SELECT id, 'assets/images/products/keyboard/arc65/3.webp', 3, 0 FROM san_phams WHERE slug='arc65';

INSERT IGNORE INTO hinh_anh_san_pham (san_pham_id, duong_dan, thu_tu, is_main)
SELECT id, 'assets/images/products/keyboard/centauri/1.webp', 1, 1 FROM san_phams WHERE slug='centauri';
INSERT IGNORE INTO hinh_anh_san_pham (san_pham_id, duong_dan, thu_tu, is_main)
SELECT id, 'assets/images/products/keyboard/centauri/2.webp', 2, 0 FROM san_phams WHERE slug='centauri';
INSERT IGNORE INTO hinh_anh_san_pham (san_pham_id, duong_dan, thu_tu, is_main)
SELECT id, 'assets/images/products/keyboard/centauri/3.webp', 3, 0 FROM san_phams WHERE slug='centauri';

INSERT IGNORE INTO hinh_anh_san_pham (san_pham_id, duong_dan, thu_tu, is_main)
SELECT id, 'assets/images/products/keyboard/huntsman-niko/1.webp', 1, 1 FROM san_phams WHERE slug='huntsman-niko';
INSERT IGNORE INTO hinh_anh_san_pham (san_pham_id, duong_dan, thu_tu, is_main)
SELECT id, 'assets/images/products/keyboard/huntsman-niko/2.webp', 2, 0 FROM san_phams WHERE slug='huntsman-niko';
INSERT IGNORE INTO hinh_anh_san_pham (san_pham_id, duong_dan, thu_tu, is_main)
SELECT id, 'assets/images/products/keyboard/huntsman-niko/3.webp', 3, 0 FROM san_phams WHERE slug='huntsman-niko';

INSERT IGNORE INTO hinh_anh_san_pham (san_pham_id, duong_dan, thu_tu, is_main)
SELECT id, 'assets/images/products/keyboard/luce60/1.webp', 1, 1 FROM san_phams WHERE slug='luce60';
INSERT IGNORE INTO hinh_anh_san_pham (san_pham_id, duong_dan, thu_tu, is_main)
SELECT id, 'assets/images/products/keyboard/luce60/2.webp', 2, 0 FROM san_phams WHERE slug='luce60';
INSERT IGNORE INTO hinh_anh_san_pham (san_pham_id, duong_dan, thu_tu, is_main)
SELECT id, 'assets/images/products/keyboard/luce60/3.webp', 3, 0 FROM san_phams WHERE slug='luce60';

INSERT IGNORE INTO hinh_anh_san_pham (san_pham_id, duong_dan, thu_tu, is_main)
SELECT id, 'assets/images/products/keyboard/made68-ultra-v2/1.webp', 1, 1 FROM san_phams WHERE slug='made68-ultra-v2';
INSERT IGNORE INTO hinh_anh_san_pham (san_pham_id, duong_dan, thu_tu, is_main)
SELECT id, 'assets/images/products/keyboard/made68-ultra-v2/2.webp', 2, 0 FROM san_phams WHERE slug='made68-ultra-v2';
INSERT IGNORE INTO hinh_anh_san_pham (san_pham_id, duong_dan, thu_tu, is_main)
SELECT id, 'assets/images/products/keyboard/made68-ultra-v2/3.webp', 3, 0 FROM san_phams WHERE slug='made68-ultra-v2';

INSERT IGNORE INTO hinh_anh_san_pham (san_pham_id, duong_dan, thu_tu, is_main)
SELECT id, 'assets/images/products/keyboard/majestouch/1.webp', 1, 1 FROM san_phams WHERE slug='majestouch';
INSERT IGNORE INTO hinh_anh_san_pham (san_pham_id, duong_dan, thu_tu, is_main)
SELECT id, 'assets/images/products/keyboard/majestouch/2.webp', 2, 0 FROM san_phams WHERE slug='majestouch';
INSERT IGNORE INTO hinh_anh_san_pham (san_pham_id, duong_dan, thu_tu, is_main)
SELECT id, 'assets/images/products/keyboard/majestouch/3.webp', 3, 0 FROM san_phams WHERE slug='majestouch';

INSERT IGNORE INTO hinh_anh_san_pham (san_pham_id, duong_dan, thu_tu, is_main)
SELECT id, 'assets/images/products/keyboard/pcmk/1.webp', 1, 1 FROM san_phams WHERE slug='pcmk';
INSERT IGNORE INTO hinh_anh_san_pham (san_pham_id, duong_dan, thu_tu, is_main)
SELECT id, 'assets/images/products/keyboard/pcmk/2.webp', 2, 0 FROM san_phams WHERE slug='pcmk';
INSERT IGNORE INTO hinh_anh_san_pham (san_pham_id, duong_dan, thu_tu, is_main)
SELECT id, 'assets/images/products/keyboard/pcmk/3.webp', 3, 0 FROM san_phams WHERE slug='pcmk';

INSERT IGNORE INTO hinh_anh_san_pham (san_pham_id, duong_dan, thu_tu, is_main)
SELECT id, 'assets/images/products/keyboard/realforce-r4/1.webp', 1, 1 FROM san_phams WHERE slug='realforce-r4';
INSERT IGNORE INTO hinh_anh_san_pham (san_pham_id, duong_dan, thu_tu, is_main)
SELECT id, 'assets/images/products/keyboard/realforce-r4/2.webp', 2, 0 FROM san_phams WHERE slug='realforce-r4';
INSERT IGNORE INTO hinh_anh_san_pham (san_pham_id, duong_dan, thu_tu, is_main)
SELECT id, 'assets/images/products/keyboard/realforce-r4/3.webp', 3, 0 FROM san_phams WHERE slug='realforce-r4';

INSERT IGNORE INTO hinh_anh_san_pham (san_pham_id, duong_dan, thu_tu, is_main)
SELECT id, 'assets/images/products/keyboard/wooting/1.webp', 1, 1 FROM san_phams WHERE slug='wooting';
INSERT IGNORE INTO hinh_anh_san_pham (san_pham_id, duong_dan, thu_tu, is_main)
SELECT id, 'assets/images/products/keyboard/wooting/2.webp', 2, 0 FROM san_phams WHERE slug='wooting';
INSERT IGNORE INTO hinh_anh_san_pham (san_pham_id, duong_dan, thu_tu, is_main)
SELECT id, 'assets/images/products/keyboard/wooting/3.webp', 3, 0 FROM san_phams WHERE slug='wooting';

INSERT IGNORE INTO hinh_anh_san_pham (san_pham_id, duong_dan, thu_tu, is_main)
SELECT id, 'assets/images/products/keyboard/xpunk/1.webp', 1, 1 FROM san_phams WHERE slug='xpunk';
INSERT IGNORE INTO hinh_anh_san_pham (san_pham_id, duong_dan, thu_tu, is_main)
SELECT id, 'assets/images/products/keyboard/xpunk/2.webp', 2, 0 FROM san_phams WHERE slug='xpunk';
INSERT IGNORE INTO hinh_anh_san_pham (san_pham_id, duong_dan, thu_tu, is_main)
SELECT id, 'assets/images/products/keyboard/xpunk/3.webp', 3, 0 FROM san_phams WHERE slug='xpunk';

-- ACCESSORY
INSERT IGNORE INTO hinh_anh_san_pham (san_pham_id, duong_dan, thu_tu, is_main)
SELECT id, 'assets/images/products/accessory/corepad-ctrl-dots/1.webp', 1, 1 FROM san_phams WHERE slug='corepad-ctrl-dots';
INSERT IGNORE INTO hinh_anh_san_pham (san_pham_id, duong_dan, thu_tu, is_main)
SELECT id, 'assets/images/products/accessory/corepad-ctrl-dots/2.webp', 2, 0 FROM san_phams WHERE slug='corepad-ctrl-dots';

INSERT IGNORE INTO hinh_anh_san_pham (san_pham_id, duong_dan, thu_tu, is_main)
SELECT id, 'assets/images/products/accessory/corepad-pxp-grips/1.webp', 1, 1 FROM san_phams WHERE slug='corepad-pxp-grips';
INSERT IGNORE INTO hinh_anh_san_pham (san_pham_id, duong_dan, thu_tu, is_main)
SELECT id, 'assets/images/products/accessory/corepad-pxp-grips/2.webp', 2, 0 FROM san_phams WHERE slug='corepad-pxp-grips';
INSERT IGNORE INTO hinh_anh_san_pham (san_pham_id, duong_dan, thu_tu, is_main)
SELECT id, 'assets/images/products/accessory/corepad-pxp-grips/3.webp', 3, 0 FROM san_phams WHERE slug='corepad-pxp-grips';

INSERT IGNORE INTO hinh_anh_san_pham (san_pham_id, duong_dan, thu_tu, is_main)
SELECT id, 'assets/images/products/accessory/esptiger-oriole/1.webp', 1, 1 FROM san_phams WHERE slug='esptiger-oriole';
INSERT IGNORE INTO hinh_anh_san_pham (san_pham_id, duong_dan, thu_tu, is_main)
SELECT id, 'assets/images/products/accessory/esptiger-oriole/2.webp', 2, 0 FROM san_phams WHERE slug='esptiger-oriole';
INSERT IGNORE INTO hinh_anh_san_pham (san_pham_id, duong_dan, thu_tu, is_main)
SELECT id, 'assets/images/products/accessory/esptiger-oriole/3.webp', 3, 0 FROM san_phams WHERE slug='esptiger-oriole';

INSERT IGNORE INTO hinh_anh_san_pham (san_pham_id, duong_dan, thu_tu, is_main)
SELECT id, 'assets/images/products/accessory/esptiger-yanzi/1.webp', 1, 1 FROM san_phams WHERE slug='esptiger-yanzi';
INSERT IGNORE INTO hinh_anh_san_pham (san_pham_id, duong_dan, thu_tu, is_main)
SELECT id, 'assets/images/products/accessory/esptiger-yanzi/2.webp', 2, 0 FROM san_phams WHERE slug='esptiger-yanzi';
INSERT IGNORE INTO hinh_anh_san_pham (san_pham_id, duong_dan, thu_tu, is_main)
SELECT id, 'assets/images/products/accessory/esptiger-yanzi/3.webp', 3, 0 FROM san_phams WHERE slug='esptiger-yanzi';

INSERT IGNORE INTO hinh_anh_san_pham (san_pham_id, duong_dan, thu_tu, is_main)
SELECT id, 'assets/images/products/accessory/pulsar-es-arm-sleeve/1.webp', 1, 1 FROM san_phams WHERE slug='pulsar-es-arm-sleeve';
INSERT IGNORE INTO hinh_anh_san_pham (san_pham_id, duong_dan, thu_tu, is_main)
SELECT id, 'assets/images/products/accessory/pulsar-es-arm-sleeve/2.webp', 2, 0 FROM san_phams WHERE slug='pulsar-es-arm-sleeve';
INSERT IGNORE INTO hinh_anh_san_pham (san_pham_id, duong_dan, thu_tu, is_main)
SELECT id, 'assets/images/products/accessory/pulsar-es-arm-sleeve/3.webp', 3, 0 FROM san_phams WHERE slug='pulsar-es-arm-sleeve';

INSERT IGNORE INTO hinh_anh_san_pham (san_pham_id, duong_dan, thu_tu, is_main)
SELECT id, 'assets/images/products/accessory/pulsar-supergrip/1.webp', 1, 1 FROM san_phams WHERE slug='pulsar-supergrip';
INSERT IGNORE INTO hinh_anh_san_pham (san_pham_id, duong_dan, thu_tu, is_main)
SELECT id, 'assets/images/products/accessory/pulsar-supergrip/2.webp', 2, 0 FROM san_phams WHERE slug='pulsar-supergrip';
INSERT IGNORE INTO hinh_anh_san_pham (san_pham_id, duong_dan, thu_tu, is_main)
SELECT id, 'assets/images/products/accessory/pulsar-supergrip/3.webp', 3, 0 FROM san_phams WHERE slug='pulsar-supergrip';

INSERT IGNORE INTO hinh_anh_san_pham (san_pham_id, duong_dan, thu_tu, is_main)
SELECT id, 'assets/images/products/accessory/pulsar-x-prx-arm-sleeve/1.webp', 1, 1 FROM san_phams WHERE slug='pulsar-x-prx-arm-sleeve';
INSERT IGNORE INTO hinh_anh_san_pham (san_pham_id, duong_dan, thu_tu, is_main)
SELECT id, 'assets/images/products/accessory/pulsar-x-prx-arm-sleeve/2.webp', 2, 0 FROM san_phams WHERE slug='pulsar-x-prx-arm-sleeve';

INSERT IGNORE INTO hinh_anh_san_pham (san_pham_id, duong_dan, thu_tu, is_main)
SELECT id, 'assets/images/products/accessory/tj-exclusives-plastix-dots/1.webp', 1, 1 FROM san_phams WHERE slug='tj-exclusives-plastix-dots';
INSERT IGNORE INTO hinh_anh_san_pham (san_pham_id, duong_dan, thu_tu, is_main)
SELECT id, 'assets/images/products/accessory/tj-exclusives-plastix-dots/2.webp', 2, 0 FROM san_phams WHERE slug='tj-exclusives-plastix-dots';

INSERT IGNORE INTO hinh_anh_san_pham (san_pham_id, duong_dan, thu_tu, is_main)
SELECT id, 'assets/images/products/accessory/unusual-way-black-fox/1.webp', 1, 1 FROM san_phams WHERE slug='unusual-way-black-fox';

INSERT IGNORE INTO hinh_anh_san_pham (san_pham_id, duong_dan, thu_tu, is_main)
SELECT id, 'assets/images/products/accessory/unusual-way-silver-fox/1.webp', 1, 1 FROM san_phams WHERE slug='unusual-way-silver-fox';
INSERT IGNORE INTO hinh_anh_san_pham (san_pham_id, duong_dan, thu_tu, is_main)
SELECT id, 'assets/images/products/accessory/unusual-way-silver-fox/2.webp', 2, 0 FROM san_phams WHERE slug='unusual-way-silver-fox';

-- MOUSEPAD
INSERT IGNORE INTO hinh_anh_san_pham (san_pham_id, duong_dan, thu_tu, is_main)
SELECT id, 'assets/images/products/mousepad/hayate-otsu-v2/1.webp', 1, 1 FROM san_phams WHERE slug='hayate-otsu-v2';
INSERT IGNORE INTO hinh_anh_san_pham (san_pham_id, duong_dan, thu_tu, is_main)
SELECT id, 'assets/images/products/mousepad/hayate-otsu-v2/2.webp', 2, 0 FROM san_phams WHERE slug='hayate-otsu-v2';

INSERT IGNORE INTO hinh_anh_san_pham (san_pham_id, duong_dan, thu_tu, is_main)
SELECT id, 'assets/images/products/mousepad/hien/1.webp', 1, 1 FROM san_phams WHERE slug='hien';
INSERT IGNORE INTO hinh_anh_san_pham (san_pham_id, duong_dan, thu_tu, is_main)
SELECT id, 'assets/images/products/mousepad/hien/2.webp', 2, 0 FROM san_phams WHERE slug='hien';

INSERT IGNORE INTO hinh_anh_san_pham (san_pham_id, duong_dan, thu_tu, is_main)
SELECT id, 'assets/images/products/mousepad/neon-v2-moondrop/1.webp', 1, 1 FROM san_phams WHERE slug='neon-v2-moondrop';
INSERT IGNORE INTO hinh_anh_san_pham (san_pham_id, duong_dan, thu_tu, is_main)
SELECT id, 'assets/images/products/mousepad/neon-v2-moondrop/2.webp', 2, 0 FROM san_phams WHERE slug='neon-v2-moondrop';
INSERT IGNORE INTO hinh_anh_san_pham (san_pham_id, duong_dan, thu_tu, is_main)
SELECT id, 'assets/images/products/mousepad/neon-v2-moondrop/3.webp', 3, 0 FROM san_phams WHERE slug='neon-v2-moondrop';

INSERT IGNORE INTO hinh_anh_san_pham (san_pham_id, duong_dan, thu_tu, is_main)
SELECT id, 'assets/images/products/mousepad/saturn-pro/1.webp', 1, 1 FROM san_phams WHERE slug='saturn-pro';
INSERT IGNORE INTO hinh_anh_san_pham (san_pham_id, duong_dan, thu_tu, is_main)
SELECT id, 'assets/images/products/mousepad/saturn-pro/2.webp', 2, 0 FROM san_phams WHERE slug='saturn-pro';
INSERT IGNORE INTO hinh_anh_san_pham (san_pham_id, duong_dan, thu_tu, is_main)
SELECT id, 'assets/images/products/mousepad/saturn-pro/3.webp', 3, 0 FROM san_phams WHERE slug='saturn-pro';

INSERT IGNORE INTO hinh_anh_san_pham (san_pham_id, duong_dan, thu_tu, is_main)
SELECT id, 'assets/images/products/mousepad/teevolution-gravis/1.webp', 1, 1 FROM san_phams WHERE slug='teevolution-gravis';
INSERT IGNORE INTO hinh_anh_san_pham (san_pham_id, duong_dan, thu_tu, is_main)
SELECT id, 'assets/images/products/mousepad/teevolution-gravis/2.webp', 2, 0 FROM san_phams WHERE slug='teevolution-gravis';
INSERT IGNORE INTO hinh_anh_san_pham (san_pham_id, duong_dan, thu_tu, is_main)
SELECT id, 'assets/images/products/mousepad/teevolution-gravis/3.webp', 3, 0 FROM san_phams WHERE slug='teevolution-gravis';

INSERT IGNORE INTO hinh_anh_san_pham (san_pham_id, duong_dan, thu_tu, is_main)
SELECT id, 'assets/images/products/mousepad/type99/1.webp', 1, 1 FROM san_phams WHERE slug='type99';
INSERT IGNORE INTO hinh_anh_san_pham (san_pham_id, duong_dan, thu_tu, is_main)
SELECT id, 'assets/images/products/mousepad/type99/2.webp', 2, 0 FROM san_phams WHERE slug='type99';
INSERT IGNORE INTO hinh_anh_san_pham (san_pham_id, duong_dan, thu_tu, is_main)
SELECT id, 'assets/images/products/mousepad/type99/3.webp', 3, 0 FROM san_phams WHERE slug='type99';

INSERT IGNORE INTO hinh_anh_san_pham (san_pham_id, duong_dan, thu_tu, is_main)
SELECT id, 'assets/images/products/mousepad/wl-qisha/1.webp', 1, 1 FROM san_phams WHERE slug='wl-qisha';
INSERT IGNORE INTO hinh_anh_san_pham (san_pham_id, duong_dan, thu_tu, is_main)
SELECT id, 'assets/images/products/mousepad/wl-qisha/2.webp', 2, 0 FROM san_phams WHERE slug='wl-qisha';
INSERT IGNORE INTO hinh_anh_san_pham (san_pham_id, duong_dan, thu_tu, is_main)
SELECT id, 'assets/images/products/mousepad/wl-qisha/3.webp', 3, 0 FROM san_phams WHERE slug='wl-qisha';

INSERT IGNORE INTO hinh_anh_san_pham (san_pham_id, duong_dan, thu_tu, is_main)
SELECT id, 'assets/images/products/mousepad/yuki-aim-demon1/1.webp', 1, 1 FROM san_phams WHERE slug='yuki-aim-demon1';
INSERT IGNORE INTO hinh_anh_san_pham (san_pham_id, duong_dan, thu_tu, is_main)
SELECT id, 'assets/images/products/mousepad/yuki-aim-demon1/2.webp', 2, 0 FROM san_phams WHERE slug='yuki-aim-demon1';
INSERT IGNORE INTO hinh_anh_san_pham (san_pham_id, duong_dan, thu_tu, is_main)
SELECT id, 'assets/images/products/mousepad/yuki-aim-demon1/3.webp', 3, 0 FROM san_phams WHERE slug='yuki-aim-demon1';

INSERT IGNORE INTO hinh_anh_san_pham (san_pham_id, duong_dan, thu_tu, is_main)
SELECT id, 'assets/images/products/mousepad/yuki-aim-monokuro/1.webp', 1, 1 FROM san_phams WHERE slug='yuki-aim-monokuro';
INSERT IGNORE INTO hinh_anh_san_pham (san_pham_id, duong_dan, thu_tu, is_main)
SELECT id, 'assets/images/products/mousepad/yuki-aim-monokuro/2.webp', 2, 0 FROM san_phams WHERE slug='yuki-aim-monokuro';
INSERT IGNORE INTO hinh_anh_san_pham (san_pham_id, duong_dan, thu_tu, is_main)
SELECT id, 'assets/images/products/mousepad/yuki-aim-monokuro/3.webp', 3, 0 FROM san_phams WHERE slug='yuki-aim-monokuro';

INSERT IGNORE INTO hinh_anh_san_pham (san_pham_id, duong_dan, thu_tu, is_main)
SELECT id, 'assets/images/products/mousepad/yuki-aim-oni/1.webp', 1, 1 FROM san_phams WHERE slug='yuki-aim-oni';
INSERT IGNORE INTO hinh_anh_san_pham (san_pham_id, duong_dan, thu_tu, is_main)
SELECT id, 'assets/images/products/mousepad/yuki-aim-oni/2.webp', 2, 0 FROM san_phams WHERE slug='yuki-aim-oni';
INSERT IGNORE INTO hinh_anh_san_pham (san_pham_id, duong_dan, thu_tu, is_main)
SELECT id, 'assets/images/products/mousepad/yuki-aim-oni/3.webp', 3, 0 FROM san_phams WHERE slug='yuki-aim-oni';

-- ============================================================
-- 4. BIẾN THỂ MÀU SẮC
-- ============================================================

-- MICE variants
INSERT IGNORE INTO bien_the_san_pham (san_pham_id, ten_bien_the, ma_hex, so_luong_ton)
SELECT id, N'Đen', '#1a1a1a', 7 FROM san_phams WHERE slug='akitsu';
INSERT IGNORE INTO bien_the_san_pham (san_pham_id, ten_bien_the, ma_hex, so_luong_ton)
SELECT id, N'Trắng', '#ffffff', 7 FROM san_phams WHERE slug='akitsu';

INSERT IGNORE INTO bien_the_san_pham (san_pham_id, ten_bien_the, ma_hex, so_luong_ton)
SELECT id, N'Đen', '#1a1a1a', 10 FROM san_phams WHERE slug='beast-x-max';
INSERT IGNORE INTO bien_the_san_pham (san_pham_id, ten_bien_the, ma_hex, so_luong_ton)
SELECT id, N'Trắng', '#ffffff', 10 FROM san_phams WHERE slug='beast-x-max';

INSERT IGNORE INTO bien_the_san_pham (san_pham_id, ten_bien_the, ma_hex, so_luong_ton)
SELECT id, N'Đen', '#1a1a1a', 4 FROM san_phams WHERE slug='finalmouse-ulx';
INSERT IGNORE INTO bien_the_san_pham (san_pham_id, ten_bien_the, ma_hex, so_luong_ton)
SELECT id, N'Bạc', '#c0c0c0', 4 FROM san_phams WHERE slug='finalmouse-ulx';

INSERT IGNORE INTO bien_the_san_pham (san_pham_id, ten_bien_the, ma_hex, so_luong_ton)
SELECT id, N'Đen', '#1a1a1a', 9 FROM san_phams WHERE slug='frostlord';
INSERT IGNORE INTO bien_the_san_pham (san_pham_id, ten_bien_the, ma_hex, so_luong_ton)
SELECT id, N'Xanh Băng', '#add8e6', 9 FROM san_phams WHERE slug='frostlord';

INSERT IGNORE INTO bien_the_san_pham (san_pham_id, ten_bien_the, ma_hex, so_luong_ton)
SELECT id, N'Trắng', '#ffffff', 5 FROM san_phams WHERE slug='maya-x';
INSERT IGNORE INTO bien_the_san_pham (san_pham_id, ten_bien_the, ma_hex, so_luong_ton)
SELECT id, N'Đen', '#1a1a1a', 6 FROM san_phams WHERE slug='maya-x';
INSERT IGNORE INTO bien_the_san_pham (san_pham_id, ten_bien_the, ma_hex, so_luong_ton)
SELECT id, N'Tím', '#7c3aed', 5 FROM san_phams WHERE slug='maya-x';

INSERT IGNORE INTO bien_the_san_pham (san_pham_id, ten_bien_the, ma_hex, so_luong_ton)
SELECT id, N'Đen', '#1a1a1a', 22 FROM san_phams WHERE slug='superstrike';
INSERT IGNORE INTO bien_the_san_pham (san_pham_id, ten_bien_the, ma_hex, so_luong_ton)
SELECT id, N'Trắng', '#ffffff', 23 FROM san_phams WHERE slug='superstrike';

INSERT IGNORE INTO bien_the_san_pham (san_pham_id, ten_bien_the, ma_hex, so_luong_ton)
SELECT id, N'Đen', '#1a1a1a', 15 FROM san_phams WHERE slug='sycrox-v6';
INSERT IGNORE INTO bien_the_san_pham (san_pham_id, ten_bien_the, ma_hex, so_luong_ton)
SELECT id, N'Trắng', '#ffffff', 15 FROM san_phams WHERE slug='sycrox-v6';

INSERT IGNORE INTO bien_the_san_pham (san_pham_id, ten_bien_the, ma_hex, so_luong_ton)
SELECT id, N'Trắng', '#ffffff', 12 FROM san_phams WHERE slug='tenz';

INSERT IGNORE INTO bien_the_san_pham (san_pham_id, ten_bien_the, ma_hex, so_luong_ton)
SELECT id, N'Đen', '#1a1a1a', 12 FROM san_phams WHERE slug='viperv4pro';
INSERT IGNORE INTO bien_the_san_pham (san_pham_id, ten_bien_the, ma_hex, so_luong_ton)
SELECT id, N'Trắng', '#ffffff', 12 FROM san_phams WHERE slug='viperv4pro';

INSERT IGNORE INTO bien_the_san_pham (san_pham_id, ten_bien_the, ma_hex, so_luong_ton)
SELECT id, N'Trắng', '#ffffff', 9 FROM san_phams WHERE slug='x2cl';
INSERT IGNORE INTO bien_the_san_pham (san_pham_id, ten_bien_the, ma_hex, so_luong_ton)
SELECT id, N'Đen', '#1a1a1a', 10 FROM san_phams WHERE slug='x2cl';
INSERT IGNORE INTO bien_the_san_pham (san_pham_id, ten_bien_the, ma_hex, so_luong_ton)
SELECT id, N'Đỏ', '#ef4444', 9 FROM san_phams WHERE slug='x2cl';

-- KEYBOARD variants
INSERT IGNORE INTO bien_the_san_pham (san_pham_id, ten_bien_the, ma_hex, so_luong_ton)
SELECT id, N'Đen', '#1a1a1a', 15 FROM san_phams WHERE slug='arc65';
INSERT IGNORE INTO bien_the_san_pham (san_pham_id, ten_bien_the, ma_hex, so_luong_ton)
SELECT id, N'Bạc', '#c0c0c0', 15 FROM san_phams WHERE slug='arc65';

INSERT IGNORE INTO bien_the_san_pham (san_pham_id, ten_bien_the, ma_hex, so_luong_ton)
SELECT id, N'Đen', '#1a1a1a', 13 FROM san_phams WHERE slug='centauri';
INSERT IGNORE INTO bien_the_san_pham (san_pham_id, ten_bien_the, ma_hex, so_luong_ton)
SELECT id, N'Trắng', '#ffffff', 14 FROM san_phams WHERE slug='centauri';
INSERT IGNORE INTO bien_the_san_pham (san_pham_id, ten_bien_the, ma_hex, so_luong_ton)
SELECT id, N'Tím', '#7c3aed', 13 FROM san_phams WHERE slug='centauri';

INSERT IGNORE INTO bien_the_san_pham (san_pham_id, ten_bien_the, ma_hex, so_luong_ton)
SELECT id, N'Đen (Niko Edition)', '#1a1a1a', 15 FROM san_phams WHERE slug='huntsman-niko';

INSERT IGNORE INTO bien_the_san_pham (san_pham_id, ten_bien_the, ma_hex, so_luong_ton)
SELECT id, N'Bạc', '#c0c0c0', 7 FROM san_phams WHERE slug='luce60';
INSERT IGNORE INTO bien_the_san_pham (san_pham_id, ten_bien_the, ma_hex, so_luong_ton)
SELECT id, N'Đen', '#1a1a1a', 7 FROM san_phams WHERE slug='luce60';
INSERT IGNORE INTO bien_the_san_pham (san_pham_id, ten_bien_the, ma_hex, so_luong_ton)
SELECT id, N'Vàng Gold', '#ffd700', 6 FROM san_phams WHERE slug='luce60';

INSERT IGNORE INTO bien_the_san_pham (san_pham_id, ten_bien_the, ma_hex, so_luong_ton)
SELECT id, N'Đen', '#1a1a1a', 17 FROM san_phams WHERE slug='made68-ultra-v2';
INSERT IGNORE INTO bien_the_san_pham (san_pham_id, ten_bien_the, ma_hex, so_luong_ton)
SELECT id, N'Trắng', '#ffffff', 18 FROM san_phams WHERE slug='made68-ultra-v2';

INSERT IGNORE INTO bien_the_san_pham (san_pham_id, ten_bien_the, ma_hex, so_luong_ton)
SELECT id, N'Đen', '#1a1a1a', 18 FROM san_phams WHERE slug='majestouch';

INSERT IGNORE INTO bien_the_san_pham (san_pham_id, ten_bien_the, ma_hex, so_luong_ton)
SELECT id, N'Đen', '#1a1a1a', 6 FROM san_phams WHERE slug='pcmk';
INSERT IGNORE INTO bien_the_san_pham (san_pham_id, ten_bien_the, ma_hex, so_luong_ton)
SELECT id, N'Bạc', '#c0c0c0', 6 FROM san_phams WHERE slug='pcmk';

INSERT IGNORE INTO bien_the_san_pham (san_pham_id, ten_bien_the, ma_hex, so_luong_ton)
SELECT id, N'Đen', '#1a1a1a', 5 FROM san_phams WHERE slug='realforce-r4';
INSERT IGNORE INTO bien_the_san_pham (san_pham_id, ten_bien_the, ma_hex, so_luong_ton)
SELECT id, N'Trắng', '#ffffff', 5 FROM san_phams WHERE slug='realforce-r4';

INSERT IGNORE INTO bien_the_san_pham (san_pham_id, ten_bien_the, ma_hex, so_luong_ton)
SELECT id, N'Đen', '#1a1a1a', 12 FROM san_phams WHERE slug='wooting';
INSERT IGNORE INTO bien_the_san_pham (san_pham_id, ten_bien_the, ma_hex, so_luong_ton)
SELECT id, N'Trắng', '#ffffff', 13 FROM san_phams WHERE slug='wooting';

INSERT IGNORE INTO bien_the_san_pham (san_pham_id, ten_bien_the, ma_hex, so_luong_ton)
SELECT id, N'Đen', '#1a1a1a', 7 FROM san_phams WHERE slug='xpunk';
INSERT IGNORE INTO bien_the_san_pham (san_pham_id, ten_bien_the, ma_hex, so_luong_ton)
SELECT id, N'Hồng', '#ff69b4', 8 FROM san_phams WHERE slug='xpunk';
INSERT IGNORE INTO bien_the_san_pham (san_pham_id, ten_bien_the, ma_hex, so_luong_ton)
SELECT id, N'Trắng', '#ffffff', 7 FROM san_phams WHERE slug='xpunk';

-- ACCESSORY variants
INSERT IGNORE INTO bien_the_san_pham (san_pham_id, ten_bien_the, ma_hex, so_luong_ton)
SELECT id, N'Trắng Sữa (PTFE)', '#f5f5f0', 30 FROM san_phams WHERE slug='corepad-ctrl-dots';

INSERT IGNORE INTO bien_the_san_pham (san_pham_id, ten_bien_the, ma_hex, so_luong_ton)
SELECT id, N'Đen', '#1a1a1a', 50 FROM san_phams WHERE slug='corepad-pxp-grips';

INSERT IGNORE INTO bien_the_san_pham (san_pham_id, ten_bien_the, ma_hex, so_luong_ton)
SELECT id, N'Trắng', '#ffffff', 55 FROM san_phams WHERE slug='esptiger-oriole';

INSERT IGNORE INTO bien_the_san_pham (san_pham_id, ten_bien_the, ma_hex, so_luong_ton)
SELECT id, N'Trắng', '#ffffff', 48 FROM san_phams WHERE slug='esptiger-yanzi';

INSERT IGNORE INTO bien_the_san_pham (san_pham_id, ten_bien_the, ma_hex, so_luong_ton)
SELECT id, N'Đen', '#1a1a1a', 40 FROM san_phams WHERE slug='pulsar-es-arm-sleeve';

INSERT IGNORE INTO bien_the_san_pham (san_pham_id, ten_bien_the, ma_hex, so_luong_ton)
SELECT id, N'Đen', '#1a1a1a', 25 FROM san_phams WHERE slug='pulsar-supergrip';
INSERT IGNORE INTO bien_the_san_pham (san_pham_id, ten_bien_the, ma_hex, so_luong_ton)
SELECT id, N'Trắng', '#ffffff', 25 FROM san_phams WHERE slug='pulsar-supergrip';

INSERT IGNORE INTO bien_the_san_pham (san_pham_id, ten_bien_the, ma_hex, so_luong_ton)
SELECT id, N'Đen', '#1a1a1a', 15 FROM san_phams WHERE slug='pulsar-x-prx-arm-sleeve';
INSERT IGNORE INTO bien_the_san_pham (san_pham_id, ten_bien_the, ma_hex, so_luong_ton)
SELECT id, N'Đỏ', '#ef4444', 15 FROM san_phams WHERE slug='pulsar-x-prx-arm-sleeve';

INSERT IGNORE INTO bien_the_san_pham (san_pham_id, ten_bien_the, ma_hex, so_luong_ton)
SELECT id, N'Trắng', '#ffffff', 35 FROM san_phams WHERE slug='tj-exclusives-plastix-dots';

INSERT IGNORE INTO bien_the_san_pham (san_pham_id, ten_bien_the, ma_hex, so_luong_ton)
SELECT id, N'Đen', '#1a1a1a', 28 FROM san_phams WHERE slug='unusual-way-black-fox';

INSERT IGNORE INTO bien_the_san_pham (san_pham_id, ten_bien_the, ma_hex, so_luong_ton)
SELECT id, N'Bạc', '#c0c0c0', 26 FROM san_phams WHERE slug='unusual-way-silver-fox';

-- MOUSEPAD variants
INSERT IGNORE INTO bien_the_san_pham (san_pham_id, ten_bien_the, ma_hex, so_luong_ton)
SELECT id, N'Đen', '#1a1a1a', 10 FROM san_phams WHERE slug='hayate-otsu-v2';
INSERT IGNORE INTO bien_the_san_pham (san_pham_id, ten_bien_the, ma_hex, so_luong_ton)
SELECT id, N'Đỏ', '#ef4444', 10 FROM san_phams WHERE slug='hayate-otsu-v2';

INSERT IGNORE INTO bien_the_san_pham (san_pham_id, ten_bien_the, ma_hex, so_luong_ton)
SELECT id, N'Đen', '#1a1a1a', 6 FROM san_phams WHERE slug='hien';
INSERT IGNORE INTO bien_the_san_pham (san_pham_id, ten_bien_the, ma_hex, so_luong_ton)
SELECT id, N'Xanh', '#2563eb', 6 FROM san_phams WHERE slug='hien';
INSERT IGNORE INTO bien_the_san_pham (san_pham_id, ten_bien_the, ma_hex, so_luong_ton)
SELECT id, N'Đỏ', '#ef4444', 6 FROM san_phams WHERE slug='hien';

INSERT IGNORE INTO bien_the_san_pham (san_pham_id, ten_bien_the, ma_hex, so_luong_ton)
SELECT id, N'Đen', '#1a1a1a', 25 FROM san_phams WHERE slug='neon-v2-moondrop';

INSERT IGNORE INTO bien_the_san_pham (san_pham_id, ten_bien_the, ma_hex, so_luong_ton)
SELECT id, N'Đen', '#1a1a1a', 15 FROM san_phams WHERE slug='saturn-pro';
INSERT IGNORE INTO bien_the_san_pham (san_pham_id, ten_bien_the, ma_hex, so_luong_ton)
SELECT id, N'Hồng', '#ff69b4', 15 FROM san_phams WHERE slug='saturn-pro';

INSERT IGNORE INTO bien_the_san_pham (san_pham_id, ten_bien_the, ma_hex, so_luong_ton)
SELECT id, N'Đen', '#1a1a1a', 22 FROM san_phams WHERE slug='teevolution-gravis';

INSERT IGNORE INTO bien_the_san_pham (san_pham_id, ten_bien_the, ma_hex, so_luong_ton)
SELECT id, N'Đen', '#1a1a1a', 13 FROM san_phams WHERE slug='type99';
INSERT IGNORE INTO bien_the_san_pham (san_pham_id, ten_bien_the, ma_hex, so_luong_ton)
SELECT id, N'Trắng', '#ffffff', 13 FROM san_phams WHERE slug='type99';

INSERT IGNORE INTO bien_the_san_pham (san_pham_id, ten_bien_the, ma_hex, so_luong_ton)
SELECT id, N'Đen', '#1a1a1a', 7 FROM san_phams WHERE slug='wl-qisha';
INSERT IGNORE INTO bien_the_san_pham (san_pham_id, ten_bien_the, ma_hex, so_luong_ton)
SELECT id, N'Trắng', '#ffffff', 8 FROM san_phams WHERE slug='wl-qisha';

INSERT IGNORE INTO bien_the_san_pham (san_pham_id, ten_bien_the, ma_hex, so_luong_ton)
SELECT id, N'Tím', '#7c3aed', 7 FROM san_phams WHERE slug='yuki-aim-demon1';
INSERT IGNORE INTO bien_the_san_pham (san_pham_id, ten_bien_the, ma_hex, so_luong_ton)
SELECT id, N'Đen', '#1a1a1a', 7 FROM san_phams WHERE slug='yuki-aim-demon1';

INSERT IGNORE INTO bien_the_san_pham (san_pham_id, ten_bien_the, ma_hex, so_luong_ton)
SELECT id, N'Trắng', '#ffffff', 6 FROM san_phams WHERE slug='yuki-aim-monokuro';
INSERT IGNORE INTO bien_the_san_pham (san_pham_id, ten_bien_the, ma_hex, so_luong_ton)
SELECT id, N'Đen', '#1a1a1a', 6 FROM san_phams WHERE slug='yuki-aim-monokuro';

INSERT IGNORE INTO bien_the_san_pham (san_pham_id, ten_bien_the, ma_hex, so_luong_ton)
SELECT id, N'Đỏ', '#ef4444', 5 FROM san_phams WHERE slug='yuki-aim-oni';
INSERT IGNORE INTO bien_the_san_pham (san_pham_id, ten_bien_the, ma_hex, so_luong_ton)
SELECT id, N'Đen', '#1a1a1a', 5 FROM san_phams WHERE slug='yuki-aim-oni';

-- ============================================================
-- KIỂM TRA KẾT QUẢ
-- ============================================================
SELECT
  (SELECT COUNT(*) FROM thuong_hieu) AS tong_thuong_hieu,
  (SELECT COUNT(*) FROM san_phams WHERE slug NOT IN ('finalmouse-starlight-12','razer-viper-v3-pro','wooting-60he-plus','logitech-gpx-sl2','artisan-zero-xl')) AS san_pham_moi,
  (SELECT COUNT(*) FROM hinh_anh_san_pham) AS tong_hinh_anh,
  (SELECT COUNT(*) FROM bien_the_san_pham) AS tong_bien_the;
