{{-- Chân trang dùng chung --}}
<footer class="site-footer mt-5">
    <div class="container-fluid px-4 px-xl-5">
        <div class="row g-4 site-footer__top">
            <div class="col-lg-4 col-md-6">
                <a href="{{ route('home') }}" class="site-footer__logo"><span class="site-footer__logo-yuki">YUKI</span> GAMING STORE</a>
                <p class="site-footer__desc">Vũ khí tối thượng cho game thủ chuyên nghiệp. Engineered for extreme performance.</p>
                <div class="site-footer__socials">
                    <a href="#" class="social-btn social-btn--web"><i class="fa-solid fa-globe"></i></a>
                    <a href="#" class="social-btn social-btn--yt"><i class="fa-brands fa-youtube"></i></a>
                    <a href="#" class="social-btn social-btn--fb"><i class="fa-brands fa-facebook-f"></i></a>
                    <a href="#" class="social-btn social-btn--dc"><i class="fa-brands fa-discord"></i></a>
                    <a href="#" class="social-btn social-btn--tk"><i class="fa-brands fa-tiktok"></i></a>
                    <a href="#" class="social-btn social-btn--ig"><i class="fa-brands fa-instagram"></i></a>
                </div>
            </div>
            <div class="col-lg-2 col-md-6 col-6">
                <h6 class="site-footer__col-title">SẢN PHẨM</h6>
                <ul class="site-footer__links list-unstyled">
                    <li><a href="{{ route('products.index', ['category' => 'keyboard']) }}">Bàn phím cơ</a></li>
                    <li><a href="{{ route('products.index', ['category' => 'mice']) }}">Chuột gaming</a></li>
                    <li><a href="{{ route('products.index', ['category' => 'accessory']) }}">Tai nghe</a></li>
                    <li><a href="{{ route('products.index', ['category' => 'mousepad']) }}">Lót chuột</a></li>
                </ul>
            </div>
            <div class="col-lg-3 col-md-6 col-6">
                <h6 class="site-footer__col-title">HỖ TRỢ</h6>
                <ul class="site-footer__links list-unstyled">
                    <li><a href="#">Chính sách bảo hành</a></li>
                    <li><a href="#">Giao hàng hỏa tốc</a></li>
                    <li><a href="{{ route('static.about') }}">Giới thiệu</a></li>
                    <li><a href="{{ route('static.contact') }}">Liên hệ chúng tôi</a></li>
                </ul>
            </div>
            <div class="col-lg-3 col-md-6">
                <h6 class="site-footer__col-title">THANH TOÁN</h6>
                <div class="site-footer__payments">
                    <span class="pay-icon pay-icon--visa" title="Visa"><i class="fa-brands fa-cc-visa"></i></span>
                    <span class="pay-icon pay-icon--master" title="Mastercard"><i class="fa-brands fa-cc-mastercard"></i></span>
                    <span class="pay-icon pay-icon--momo" title="MoMo"><i class="fa-solid fa-wallet"></i></span>
                    <span class="pay-icon pay-icon--bank" title="Internet Banking"><i class="fa-solid fa-building-columns"></i></span>
                    <span class="pay-icon pay-icon--paypal" title="PayPal"><i class="fa-brands fa-paypal"></i></span>
                </div>
                <p class="site-footer__copyright">© 2026 YUKI Gaming. Designed with Cyber-precision.</p>
            </div>
        </div>
    </div>
</footer>
