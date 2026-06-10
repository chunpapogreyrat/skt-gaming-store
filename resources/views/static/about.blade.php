@extends('layouts.app')

@section('title', 'Về Chúng Tôi — YUKI')

@section('content')
<!-- #region BREADCRUMB -->
<nav class="breadcrumb-bar container-fluid px-4 px-xl-5">
    <ol class="breadcrumb-bar__list">
        <li><a href="{{ route('home') }}"><i class="fa-solid fa-house"></i> Trang chủ</a></li>
        <li class="breadcrumb-bar__active">Giới thiệu về chúng tôi</li>
    </ol>
</nav>
<!-- #endregion -->

<!-- #region ABOUT HERO -->
<section class="about-hero">
    <div class="about-hero__grid"></div>
    <div class="about-hero__glow"></div>
    <div class="container-fluid px-4 px-xl-5 about-hero__inner">
        <span class="about-hero__tag" data-aos="fade-up">VỀ CHÚNG TÔI</span>
        <h1 class="about-hero__title" data-aos="fade-up" data-aos-delay="80">
            YUKI <span class="txt-red">GAMING</span> STORE
        </h1>
        <p class="about-hero__sub" data-aos="fade-up" data-aos-delay="160">
            Nơi quy tụ những vũ khí tối thượng cho game thủ chuyên nghiệp. Track nhanh — Bấm mượt — Không đổ lỗi cho gear.
        </p>
    </div>
</section>
<!-- #endregion -->

<!-- #region ABOUT STATS (count-up) -->
<section class="container-fluid px-4 px-xl-5 about-stats-wrap">
    <div class="about-stats" data-aos="zoom-in">
        <div class="about-stat">
            <span class="about-stat__num" data-count="8">0</span><span class="about-stat__plus">+</span>
            <span class="about-stat__label">Năm kinh nghiệm</span>
        </div>
        <div class="about-stat">
            <span class="about-stat__num" data-count="1200">0</span><span class="about-stat__plus">+</span>
            <span class="about-stat__label">Sản phẩm chính hãng</span>
        </div>
        <div class="about-stat">
            <span class="about-stat__num" data-count="50000">0</span><span class="about-stat__plus">+</span>
            <span class="about-stat__label">Khách hàng tin tưởng</span>
        </div>
        <div class="about-stat">
            <span class="about-stat__num" data-count="60">0</span><span class="about-stat__plus">+</span>
            <span class="about-stat__label">Thương hiệu hợp tác</span>
        </div>
    </div>
</section>
<!-- #endregion -->

<!-- #region MISSION & VISION -->
<section class="container-fluid px-4 px-xl-5 about-mv">
    <div class="row g-4">
        <div class="col-lg-6" data-aos="fade-right">
            <div class="mv-card mv-card--mission">
                <div class="mv-card__icon"><i class="fa-solid fa-bullseye"></i></div>
                <h3 class="mv-card__title">Sứ Mệnh</h3>
                <p class="mv-card__text">
                    Nâng tầm trải nghiệm của mọi game thủ thông qua những thiết bị tuyển chọn khắt khe nhất.
                    Chúng tôi đồng hành cùng cộng đồng eSports Việt Nam trong việc xây dựng nền tảng phần cứng
                    vững chắc để vươn tầm thế giới.
                </p>
            </div>
        </div>
        <div class="col-lg-6" data-aos="fade-left">
            <div class="mv-card mv-card--vision">
                <div class="mv-card__icon"><i class="fa-solid fa-binoculars"></i></div>
                <h3 class="mv-card__title">Tầm Nhìn</h3>
                <p class="mv-card__text">
                    Trở thành biểu tượng của văn hóa Gaming tại Đông Nam Á, nơi mọi nhà vô địch đều tìm thấy
                    vũ khí của riêng mình. Không ngừng cập nhật những công nghệ đột phá nhất từ các phòng lab
                    hàng đầu thế giới.
                </p>
            </div>
        </div>
    </div>
</section>
<!-- #endregion -->

<!-- #region CORE VALUES -->
<section class="container-fluid px-4 px-xl-5 about-values">
    <h2 class="about-section-title" data-aos="fade-up">GIÁ TRỊ CỐT LÕI</h2>
    <div class="row g-4 justify-content-center">
        <div class="col-md-4" data-aos="fade-up" data-aos-delay="0">
            <div class="value-card">
                <div class="value-card__icon"><i class="fa-solid fa-shield-halved"></i></div>
                <h4 class="value-card__title">Chất Lượng</h4>
                <p class="value-card__text">
                    Chỉ phân phối hàng chính hãng với tiêu chuẩn kiểm định nghiêm ngặt từ nhà sản xuất.
                </p>
            </div>
        </div>
        <div class="col-md-4" data-aos="fade-up" data-aos-delay="120">
            <div class="value-card">
                <div class="value-card__icon"><i class="fa-solid fa-bolt"></i></div>
                <h4 class="value-card__title">Đột Phá</h4>
                <p class="value-card__text">
                    Luôn là đơn vị tiên phong mang về những sản phẩm "Limited Edition" và công nghệ mới nhất.
                </p>
            </div>
        </div>
        <div class="col-md-4" data-aos="fade-up" data-aos-delay="240">
            <div class="value-card">
                <div class="value-card__icon"><i class="fa-solid fa-users"></i></div>
                <h4 class="value-card__title">Cộng Đồng</h4>
                <p class="value-card__text">
                    Xây dựng hệ sinh thái hỗ trợ game thủ, tổ chức các giải đấu chuyên nghiệp và cộng đồng chia sẻ đam mê.
                </p>
            </div>
        </div>
    </div>
</section>
<!-- #endregion -->

<!-- #region TEAM -->
<section class="container-fluid px-4 px-xl-5 about-team">
    <h2 class="about-section-title" data-aos="fade-up">ĐỘI NGŨ CHUYÊN GIA</h2>
    <p class="about-team__intro" data-aos="fade-up" data-aos-delay="80">
        Những bộ óc đứng sau YUKI — kiến tạo trải nghiệm, dựng nền tảng và tối ưu từng dòng code.
    </p>
    <div class="row g-4 justify-content-center">
        <div class="col-md-6 col-lg-4" data-aos="zoom-out-up" data-aos-delay="0">
            <div class="team-card team-card--cyan">
                <div class="team-card__avatar">
                    <img src="{{ asset('assets/images/avatars/truong.jpg') }}" alt="Vũ Quang Trưởng">
                </div>
                <h4 class="team-card__name">Vũ Quang Trưởng</h4>
                <span class="team-card__role">Lead UI/UX Architect &amp; Data Analyst</span>
                <p class="team-card__desc">Kiến trúc sư giao diện — thiết kế UI/UX, phân tích dữ liệu và dựng nên diện mạo trực quan của YUKI.</p>
                <ul class="team-card__socials">
                    <li><a href="#"><i class="fa-brands fa-facebook-f"></i></a></li>
                    <li><a href="#"><i class="fa-brands fa-linkedin-in"></i></a></li>
                    <li><a href="#"><i class="fa-solid fa-plus"></i></a></li>
                    <li><a href="#"><i class="fa-brands fa-discord"></i></a></li>
                    <li><a href="#"><i class="fa-solid fa-globe"></i></a></li>
                </ul>
            </div>
        </div>
        <div class="col-md-6 col-lg-4" data-aos="zoom-out-up" data-aos-delay="120">
            <div class="team-card team-card--red">
                <div class="team-card__avatar">
                    <img src="{{ asset('assets/images/avatars/trung.png') }}" alt="Trần Đức Trung">
                </div>
                <h4 class="team-card__name">Trần Đức Trung</h4>
                <span class="team-card__role">Team Leader &amp; Full-stack Engineer</span>
                <p class="team-card__desc">Thuyền trưởng dự án — dẫn dắt đội ngũ và xây dựng trọn vẹn hệ thống từ front-end đến back-end.</p>
                <ul class="team-card__socials">
                    <li><a href="#"><i class="fa-brands fa-facebook-f"></i></a></li>
                    <li><a href="#"><i class="fa-brands fa-youtube"></i></a></li>
                    <li><a href="#"><i class="fa-solid fa-plus"></i></a></li>
                    <li><a href="#"><i class="fa-brands fa-tiktok"></i></a></li>
                    <li><a href="#"><i class="fa-solid fa-globe"></i></a></li>
                </ul>
            </div>
        </div>
        <div class="col-md-6 col-lg-4" data-aos="zoom-out-up" data-aos-delay="240">
            <div class="team-card team-card--gold">
                <div class="team-card__avatar">
                    <img src="{{ asset('assets/images/avatars/khoa.jpg') }}" alt="Lê Trần Đăng Khoa">
                </div>
                <h4 class="team-card__name">Lê Trần Đăng Khoa</h4>
                <span class="team-card__role">Backend Engineer &amp; System Architect</span>
                <p class="team-card__desc">Kiến trúc sư hệ thống — phân tích nghiệp vụ và xây dựng nền tảng back-end vững chắc, an toàn.</p>
                <ul class="team-card__socials">
                    <li><a href="#"><i class="fa-brands fa-facebook-f"></i></a></li>
                    <li><a href="#"><i class="fa-brands fa-instagram"></i></a></li>
                    <li><a href="#"><i class="fa-solid fa-plus"></i></a></li>
                    <li><a href="#"><i class="fa-brands fa-discord"></i></a></li>
                    <li><a href="#"><i class="fa-solid fa-globe"></i></a></li>
                </ul>
            </div>
        </div>
    </div>
</section>
<!-- #endregion -->

<!-- #region CTA -->
<section class="container-fluid px-4 px-xl-5">
    <div class="about-cta" data-aos="zoom-in">
        <div class="about-cta__glow"></div>
        <h2 class="about-cta__title">Sẵn sàng nâng cấp <span class="txt-red">chiến mã</span> của bạn?</h2>
        <p class="about-cta__sub">Khám phá kho vũ khí gaming gear hi-end đang chờ bạn.</p>
        <a href="{{ route('products.index') }}" class="about-cta__btn">KHÁM PHÁ NGAY <i class="fa-solid fa-arrow-right ms-2"></i></a>
    </div>
</section>
<!-- #endregion -->
@endsection
