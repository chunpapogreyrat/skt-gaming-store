<?php

namespace Database\Seeders;

use App\Models\BaiViet;
use Illuminate\Database\Seeder;

class BaiVietSeeder extends Seeder
{
    public function run(): void
    {
        $posts = [
            [
                'danh_muc' => 'huong-dan',
                'tieu_de' => 'Cách chọn chuột gaming chuẩn theo cỡ tay và kiểu cầm',
                'slug' => 'chon-chuot-gaming-theo-co-tay',
                'tac_gia' => 'Minh "ZeroLatency" Trần',
                'thoi_gian_doc' => 7,
                'is_featured' => true,
                'anh_bia' => 'assets/images/banners/mouse-banner.jpg',
                'mo_ta_ngan' => 'Chuột vừa tay quyết định 50% cảm giác chơi. Đo cỡ tay, hiểu 3 kiểu cầm Palm – Claw – Fingertip và chọn form chuột phù hợp để aim ổn định hơn ngay hôm nay.',
                'noi_dung' => '<p>Một con chuột tốt không phải là con đắt nhất, mà là con <strong>vừa tay bạn nhất</strong>. Trước khi nhìn vào DPI hay sensor, hãy bắt đầu từ chính bàn tay mình.</p>
<h3>1. Đo cỡ tay của bạn</h3>
<p>Đo từ cổ tay đến đầu ngón giữa (chiều dài) và bề ngang lòng bàn tay. Quy ước phổ biến:</p>
<ul><li><strong>Nhỏ:</strong> dài &lt; 17cm — ưu tiên chuột ngắn, nhẹ.</li><li><strong>Vừa:</strong> 17–19cm — linh hoạt với hầu hết form chuột.</li><li><strong>Lớn:</strong> &gt; 19cm — cần chuột dài, lưng cao để đỡ lòng bàn tay.</li></ul>
<h3>2. Xác định kiểu cầm</h3>
<p><strong>Palm grip</strong> đặt cả lòng bàn tay lên chuột — êm, ổn định, hợp chuột lưng cao. <strong>Claw grip</strong> cong các ngón như móng vuốt — phản xạ nhanh, hợp game FPS. <strong>Fingertip</strong> chỉ chạm bằng đầu ngón — siêu linh hoạt, cần chuột nhẹ và ngắn.</p>
<h3>3. Trọng lượng & kết nối</h3>
<p>Xu hướng 2026 là chuột siêu nhẹ dưới 50g cho phản xạ tức thì. Kết nối không dây 4K–8K polling rate giờ đã ổn định, độ trễ gần như bằng có dây. Nếu chơi FPS cạnh tranh, đừng ngại đầu tư bản wireless cao cấp.</p>
<p>👉 Mẹo: hãy thử cầm thử nhiều form trước khi quyết định. Tại YUKI, mỗi sản phẩm đều có nhiều biến thể màu và thông số rõ ràng để bạn so sánh.</p>',
            ],
            [
                'danh_muc' => 'huong-dan',
                'tieu_de' => 'Switch Linear, Tactile hay Clicky — chọn loại nào cho bàn phím cơ?',
                'slug' => 'chon-switch-ban-phim-co',
                'tac_gia' => 'Hương "KeebQueen" Lê',
                'thoi_gian_doc' => 6,
                'anh_bia' => 'assets/images/banners/keyboard-banner.jpg',
                'mo_ta_ngan' => 'Linear mượt, Tactile có khấc, Clicky kêu tách tách. Hiểu rõ cảm giác gõ của từng dòng switch để chọn đúng bàn phím cho gaming lẫn làm việc.',
                'noi_dung' => '<p>Switch là "linh hồn" của bàn phím cơ — nó quyết định cảm giác gõ và độ ồn. Có ba nhóm chính bạn cần biết.</p>
<h3>Linear — mượt từ đầu đến cuối</h3>
<p>Không khấc, không tiếng click, hành trình trơn tru. Rất được game thủ FPS ưa chuộng vì nhấn nhanh và nhất quán. Ví dụ tiêu biểu: Red, Speed Silver.</p>
<h3>Tactile — có một "khấc" phản hồi</h3>
<p>Bạn cảm nhận được điểm kích hoạt qua một gợn nhẹ ở giữa hành trình. Cân bằng tốt cho người vừa gõ văn bản vừa chơi game. Ví dụ: Brown.</p>
<h3>Clicky — tách tách đã tai</h3>
<p>Có cả khấc lẫn tiếng click rõ ràng. Gõ rất "phê" nhưng ồn, cân nhắc nếu bạn ở môi trường chung. Ví dụ: Blue.</p>
<h3>Đừng quên: lực nhấn & lube</h3>
<p>Lực nhấn (gram) ảnh hưởng độ mỏi tay khi chơi lâu. Switch đã lube sẵn từ nhà máy cho cảm giác mượt hơn đáng kể. Nếu mới bắt đầu, Linear nhẹ (~45g) là lựa chọn an toàn.</p>',
            ],
            [
                'danh_muc' => 'tin-tuc',
                'tieu_de' => 'Hall Effect & Analog: cuộc cách mạng của bàn phím gaming',
                'slug' => 'hall-effect-analog-ban-phim',
                'tac_gia' => 'YUKI Team',
                'thoi_gian_doc' => 5,
                'anh_bia' => 'assets/images/library/made68pro.jpg',
                'mo_ta_ngan' => 'Công nghệ cảm biến từ trường (Hall Effect) cho phép chỉnh điểm kích hoạt và điều khiển analog như tay cầm. Vì sao đây là xu hướng nóng nhất 2026?',
                'noi_dung' => '<p>Bàn phím Hall Effect dùng cảm biến từ trường thay cho tiếp điểm vật lý, mở ra những khả năng mà switch truyền thống không có.</p>
<h3>Adjustable Actuation</h3>
<p>Bạn có thể tự chỉnh điểm kích hoạt từ siêu nhạy (0.1mm) cho phản xạ tức thì đến sâu (3.5mm) để tránh nhấn nhầm — tuỳ từng phím.</p>
<h3>Rapid Trigger</h3>
<p>Phím reset ngay khi bạn nhả, cho phép nhấn lại cực nhanh. Đây là lợi thế lớn trong các tựa game cần counter-strafe như VALORANT hay CS2.</p>
<h3>Điều khiển Analog</h3>
<p>Nhấn nông – sâu cho ra tín hiệu khác nhau như cần analog tay cầm, giúp đi bộ/chạy mượt trong game nhập vai. Không mòn tiếp điểm nên độ bền cũng cao hơn.</p>
<p>Tại YUKI, các mẫu Hall Effect như MADE68 Ultra hay Wooting 60HE đều có sẵn — ghé xem để trải nghiệm tương lai của bàn phím.</p>',
            ],
            [
                'danh_muc' => 'setup',
                'tieu_de' => 'Top 5 setup gaming tối giản đẹp mê ly cho năm 2026',
                'slug' => 'top-5-setup-gaming-toi-gian-2026',
                'tac_gia' => 'Khoa "DeskGoals" Phạm',
                'thoi_gian_doc' => 8,
                'anh_bia' => 'assets/images/setups/setup-2.jpg',
                'mo_ta_ngan' => 'Ít đồ nhưng chất. Tổng hợp 5 phong cách setup tối giản — từ all-white tinh khôi đến cyberpunk neon — kèm bí quyết đi dây gọn và chọn ánh sáng.',
                'noi_dung' => '<p>Setup đẹp không phải nhồi nhét thật nhiều gear, mà là sự hài hoà giữa màu sắc, ánh sáng và không gian sạch.</p>
<h3>1. All-White tinh khôi</h3>
<p>Bàn trắng, gear trắng, dây bọc trắng. Sạch sẽ, sang trọng, lên hình cực ăn ảnh. Bí quyết: đồng bộ tông trắng và giấu dây tuyệt đối.</p>
<h3>2. Cyberpunk Neon</h3>
<p>Nền tối, điểm nhấn LED tím – xanh. Một dải LED sau màn hình (bias lighting) vừa đẹp vừa đỡ mỏi mắt.</p>
<h3>3. Minimal Aim Station</h3>
<p>Chỉ màn hình, bàn phím TKL/60% và một pad lớn. Tối ưu cho FPS, dọn sạch mọi thứ gây xao nhãng.</p>
<h3>4. Wood &amp; Warm</h3>
<p>Mặt bàn gỗ, ánh sáng vàng ấm, gear tông be. Hợp người thích cảm giác cozy, ấm cúng.</p>
<h3>5. Creator Battle Desk</h3>
<p>Hai màn hình, mic, đèn key light cho streamer. Vẫn gọn nhờ giá treo màn hình và máng đi dây dưới bàn.</p>
<p>Mẹo chung: đầu tư một bộ <em>cable management</em> tốt và một tấm lót chuột cỡ lớn — hai thứ thay đổi diện mạo bàn nhiều nhất.</p>',
            ],
            [
                'danh_muc' => 'review',
                'tieu_de' => 'Đánh giá Finalmouse ULX Pro: siêu nhẹ, đẳng cấp dân sưu tầm',
                'slug' => 'danh-gia-finalmouse-ulx-pro',
                'tac_gia' => 'Minh "ZeroLatency" Trần',
                'thoi_gian_doc' => 9,
                'is_featured' => false,
                'anh_bia' => 'assets/images/products/mice/finalmouse-ulx/1.webp',
                'mo_ta_ngan' => 'Khung magnesium tổ ong, trọng lượng phá kỷ lục, cảm biến tùy chỉnh. Sau hai tuần dùng thử ULX Pro, đây là những gì khiến nó xứng danh flagship giới hạn.',
                'noi_dung' => '<p>Finalmouse luôn là cái tên gây tranh cãi: giá cao, hàng hiếm, nhưng độ "phê" thì khó bàn cãi. ULX Pro tiếp nối di sản đó.</p>
<h3>Thiết kế &amp; trọng lượng</h3>
<p>Khung hợp kim magnesium dạng tổ ong cho độ cứng cáp đáng nể dù siêu nhẹ. Cầm lên gần như không cảm nhận được trọng lượng — lướt chuột nhẹ tênh, rê tâm cực đã.</p>
<h3>Cảm biến &amp; hiệu năng</h3>
<p>Sensor tùy chỉnh tracking ổn định ở mọi tốc độ vẩy. Skate trượt êm, click tách bạch, không bị flex dù vỏ rỗng.</p>
<h3>Các phiên bản màu</h3>
<p>ULX Pro về YUKI với nhiều phiên bản colorway sưu tầm — từ Xám, Đỏ đô, Xanh lá đến Tím than. Mỗi màu một cá tính, chọn màu nào trang sản phẩm sẽ đổi ảnh tương ứng để bạn xem rõ.</p>
<h3>Có đáng tiền?</h3>
<p>Nếu bạn là người chơi nghiêm túc hoặc dân sưu tầm yêu cái đẹp, ULX Pro là một tuyên ngôn. Còn nếu chỉ cần hiệu năng/giá, vẫn có nhiều lựa chọn siêu nhẹ khác trong store.</p>
<p><strong>Điểm: 9.2/10</strong> — nhẹ, đẹp, hiếm. Trừ điểm vì độ khó mua và mức giá flagship.</p>',
            ],
            [
                'danh_muc' => 'huong-dan',
                'tieu_de' => 'Lót chuột Control vs Speed: chọn theo lối chơi của bạn',
                'slug' => 'lot-chuot-control-vs-speed',
                'tac_gia' => 'Hương "KeebQueen" Lê',
                'thoi_gian_doc' => 4,
                'anh_bia' => 'assets/images/banners/pad-banner.jpg',
                'mo_ta_ngan' => 'Bề mặt pad ảnh hưởng trực tiếp tới khả năng dừng tâm và lướt. Hiểu sự khác biệt Control – Speed – Hybrid để aim chính xác hơn.',
                'noi_dung' => '<p>Nhiều người nâng cấp chuột nhưng quên mất tấm pad — thứ tiếp xúc trực tiếp và quyết định cảm giác lướt.</p>
<h3>Control — bám, dừng tâm chắc</h3>
<p>Bề mặt nhám hơn, ma sát cao giúp dừng tâm chính xác. Hợp người chơi tracking, cần kiểm soát từng pixel.</p>
<h3>Speed — lướt nhanh, vẩy nhẹ</h3>
<p>Bề mặt mịn, ma sát thấp, chuột trôi nhanh. Hợp lối chơi flick, vẩy tâm rộng.</p>
<h3>Hybrid — cân bằng</h3>
<p>Dung hoà giữa hai loại, phù hợp đa số người chơi chưa rõ mình thuộc phe nào.</p>
<h3>Kích thước &amp; độ dày</h3>
<p>Pad cỡ lớn (XL/XXL) cho không gian vẩy thoải mái ở DPI thấp. Độ dày 3–4mm êm tay hơn khi chơi lâu. Nhớ giặt pad định kỳ để giữ độ lướt ổn định.</p>',
            ],
            [
                'danh_muc' => 'huong-dan',
                'tieu_de' => 'Cách vệ sinh & bảo quản gear gaming bền như mới',
                'slug' => 've-sinh-bao-quan-gear-gaming',
                'tac_gia' => 'YUKI Team',
                'thoi_gian_doc' => 5,
                'anh_bia' => 'assets/images/setups/setup-4.jpg',
                'mo_ta_ngan' => 'Gear sạch chạy tốt và lên hình đẹp. Hướng dẫn từng bước vệ sinh bàn phím, chuột và pad an toàn — không làm hỏng linh kiện.',
                'noi_dung' => '<p>Bụi, mồ hôi và dầu tay là kẻ thù thầm lặng của gear. Vệ sinh định kỳ giúp thiết bị bền và cảm giác dùng luôn như mới.</p>
<h3>Bàn phím</h3>
<p>Rút keycap bằng dụng cụ chuyên dụng, ngâm keycap với nước ấm pha xà phòng nhẹ. Dùng cọ mềm và bình khí nén thổi bụi trong khung. Tuyệt đối để khô hoàn toàn trước khi lắp lại.</p>
<h3>Chuột</h3>
<p>Lau vỏ bằng khăn microfiber ẩm. Vệ sinh khe skate và mắt đọc bằng tăm bông khô. Tránh để nước lọt vào nút bấm.</p>
<h3>Lót chuột</h3>
<p>Pad vải có thể giặt tay với nước mát và xà phòng nhẹ, chải nhẹ theo một chiều, phơi nơi thoáng (tránh nắng gắt và máy sấy nóng).</p>
<h3>Lịch gợi ý</h3>
<p>Lau nhanh hàng tuần, vệ sinh kỹ mỗi 1–2 tháng. Một chút chăm sóc đều đặn tốt hơn nhiều so với "đại tu" khi gear đã quá bẩn.</p>',
            ],
            [
                'danh_muc' => 'esports',
                'tieu_de' => 'Esports 2026: bộ gear của các tuyển thủ VALORANT đỉnh cao',
                'slug' => 'gear-tuyen-thu-valorant-2026',
                'tac_gia' => 'Khoa "DeskGoals" Phạm',
                'thoi_gian_doc' => 6,
                'anh_bia' => 'assets/images/setups/setup-3.jpg',
                'mo_ta_ngan' => 'Vì sao đa số pro VALORANT dùng chuột siêu nhẹ, DPI thấp và bàn phím TKL? Giải mã triết lý chọn gear đằng sau những pha clutch đỉnh cao.',
                'noi_dung' => '<p>Gear của tuyển thủ chuyên nghiệp không chọn theo "đẹp" mà theo hiệu năng và sự nhất quán. Đây là những điểm chung dễ thấy.</p>
<h3>Chuột siêu nhẹ</h3>
<p>Đa số pro dùng chuột dưới 60g để vẩy tâm nhanh và đỡ mỏi trong các trận đấu dài. Form chuột thường nhỏ gọn, đối xứng.</p>
<h3>DPI thấp, eDPI tối ưu</h3>
<p>Nhiều người chơi 400–800 DPI kết hợp sensitivity in-game thấp, đổi lại pad cỡ lớn để có không gian vẩy. Độ chính xác đặt lên trên tốc độ.</p>
<h3>Bàn phím TKL hoặc 60%</h3>
<p>Bỏ cụm phím số để chuột có thêm không gian và tay đặt thoải mái hơn. Switch linear nhẹ được ưa chuộng.</p>
<h3>Bài học cho game thủ thường</h3>
<p>Bạn không cần sao chép y hệt pro, nhưng triết lý "nhẹ – nhất quán – tối giản" rất đáng học. Hãy chọn gear hợp tay và luyện tập ổn định với một cấu hình.</p>',
            ],
        ];

        foreach ($posts as $i => $post) {
            $post['ngay_dang'] = now()->subDays(count($posts) - $i)->setTime(9, 0);
            $post['luot_xem'] = 120 + ($i * 47) % 900;
            $post['is_active'] = true;
            BaiViet::updateOrCreate(['slug' => $post['slug']], $post);
        }

        $this->command->info('✓ Seeded ' . count($posts) . ' bài viết blog (Góc game thủ).');
    }
}
