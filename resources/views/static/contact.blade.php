@extends('layouts.app')

@section('title', 'Liên Hệ — YUKI')

@section('content')
<!-- #region BREADCRUMB -->
<nav class="breadcrumb-bar container-fluid px-4 px-xl-5">
    <ol class="breadcrumb-bar__list">
        <li><a href="{{ route('home') }}"><i class="fa-solid fa-house"></i> Trang chủ</a></li>
        <li class="breadcrumb-bar__active">Liên hệ</li>
    </ol>
</nav>
<!-- #endregion -->

<!-- #region CONTACT (MAIN) -->
<main class="container-fluid px-4 px-xl-5 contact-page">

    <header class="contact-head" data-aos="fade-up">
        <span class="contact-head__tag">LIÊN HỆ</span>
        <h1 class="contact-head__title">KẾT NỐI VỚI <span class="txt-red">YUKI</span></h1>
        <p class="contact-head__sub">Đội ngũ kỹ thuật luôn sẵn sàng hỗ trợ bạn 24/7. Gửi tín hiệu cho chúng tôi ngay!</p>
    </header>

    <div class="row g-4">

        <!-- LEFT: INFO + MAP -->
        <div class="col-lg-5" data-aos="fade-right">
            <div class="contact-info">
                <h3 class="contact-info__title"><i class="fa-solid fa-tower-broadcast"></i> TRẠM CHỈ HUY</h3>

                <div class="contact-info__item">
                    <span class="contact-info__icon"><i class="fa-solid fa-location-dot"></i></span>
                    <div>
                        <p class="contact-info__label">Địa chỉ trụ sở</p>
                        <p class="contact-info__value">Số 1 Võ Văn Ngân, P. Linh Chiểu, TP. Thủ Đức, TP. Hồ Chí Minh</p>
                    </div>
                </div>

                <div class="contact-info__item">
                    <span class="contact-info__icon"><i class="fa-solid fa-headset"></i></span>
                    <div>
                        <p class="contact-info__label">Đường dây nóng</p>
                        <p class="contact-info__value">+84 1900 8888 (24/7 Support)</p>
                    </div>
                </div>

                <div class="contact-info__item">
                    <span class="contact-info__icon"><i class="fa-solid fa-envelope"></i></span>
                    <div>
                        <p class="contact-info__label">Liên hệ điện tử</p>
                        <p class="contact-info__value">hq@YUKIgaming.com.vn</p>
                    </div>
                </div>

                <a href="https://www.google.com/maps?q=1+Vo+Van+Ngan,+Linh+Chieu,+Thu+Duc,+Ho+Chi+Minh"
                   target="_blank" rel="noopener" class="contact-info__map-btn">
                    <i class="fa-solid fa-map-location-dot"></i> Open in Maps
                </a>

                <div class="contact-map">
                    <iframe
                        src="https://www.google.com/maps?q=1+Vo+Van+Ngan,+Linh+Chieu,+Thu+Duc,+Ho+Chi+Minh&output=embed"
                        width="100%" height="100%" style="border:0;" allowfullscreen=""
                        loading="lazy" referrerpolicy="no-referrer-when-downgrade"
                        title="Bản đồ YUKI"></iframe>
                </div>
            </div>
        </div>

        <!-- RIGHT: FORM -->
        <div class="col-lg-7" data-aos="fade-left">
            <div class="contact-form-card">
                <h3 class="contact-form-card__title"><i class="fa-solid fa-satellite-dish"></i> KÊNH TRUYỀN TIN</h3>

                <form class="contact-form" action="{{ route('static.contact.send') }}" method="POST">
                    @csrf
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="contact-form__label">Họ và tên</label>
                            <div class="contact-field">
                                <i class="fa-regular fa-user"></i>
                                <input type="text" name="ho_ten" value="{{ old('ho_ten') }}" class="contact-field__input" placeholder="Nhập tên của bạn..." required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="contact-form__label">Địa chỉ email</label>
                            <div class="contact-field">
                                <i class="fa-regular fa-envelope"></i>
                                <input type="email" name="email" value="{{ old('email') }}" class="contact-field__input" placeholder="example@gmail.com" required>
                            </div>
                        </div>
                        <div class="col-12">
                            <label class="contact-form__label">Tiêu đề</label>
                            <div class="contact-field">
                                <i class="fa-solid fa-tag"></i>
                                <select name="chu_de" class="contact-field__input">
                                    <option value="ho-tro-ky-thuat" @selected(old('chu_de')==='ho-tro-ky-thuat')>Hỗ trợ kỹ thuật</option>
                                    <option value="bao-hanh" @selected(old('chu_de')==='bao-hanh')>Bảo hành sản phẩm</option>
                                    <option value="don-hang" @selected(old('chu_de')==='don-hang')>Thông tin đơn hàng</option>
                                    <option value="hop-tac" @selected(old('chu_de')==='hop-tac')>Hợp tác kinh doanh</option>
                                    <option value="khac" @selected(old('chu_de')==='khac')>Khác</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-12">
                            <label class="contact-form__label">Nội dung thông điệp</label>
                            <textarea name="noi_dung" class="contact-form__textarea" rows="5" placeholder="Viết thông điệp của bạn tại đây..." required>{{ old('noi_dung') }}</textarea>
                        </div>
                        <div class="col-12">
                            <button type="submit" class="contact-form__submit">
                                KHỞI ĐỘNG TRUYỀN TIN <i class="fa-solid fa-bolt ms-2"></i>
                            </button>
                        </div>
                    </div>
                    <p class="contact-form__note">* Phản hồi sẽ được mã hóa và gửi đến trung tâm điều hành trong vòng 24 giờ.</p>

                    @if ($errors->any())
                        <div class="contact-form__success" style="display:flex;background:rgba(255,49,93,.1);border-color:rgba(255,49,93,.4);color:#ff7d97">
                            <i class="fa-solid fa-circle-exclamation"></i> {{ $errors->first() }}
                        </div>
                    @endif
                    @if (session('lien_he_success'))
                        <div class="contact-form__success" style="display:flex">
                            <i class="fa-solid fa-circle-check"></i> {{ session('lien_he_success') }}
                        </div>
                    @endif
                </form>
            </div>
        </div>
    </div>

    <!-- FEATURE STRIP -->
    <div class="contact-features" data-aos="fade-up">
        <div class="contact-feature">
            <span class="contact-feature__icon contact-feature__icon--cyan"><i class="fa-solid fa-shield-halved"></i></span>
            <div>
                <h5 class="contact-feature__title">Bảo Mật Tuyệt Đối</h5>
                <p class="contact-feature__text">Mọi thông tin điều được mã hóa đầu cuối.</p>
            </div>
        </div>
        <div class="contact-feature">
            <span class="contact-feature__icon contact-feature__icon--red"><i class="fa-solid fa-bolt"></i></span>
            <div>
                <h5 class="contact-feature__title">Phản Hồi Siêu Tốc</h5>
                <p class="contact-feature__text">Cam kết xử lý yêu cầu dưới 12 giờ làm việc.</p>
            </div>
        </div>
        <div class="contact-feature">
            <span class="contact-feature__icon contact-feature__icon--gold"><i class="fa-solid fa-headphones"></i></span>
            <div>
                <h5 class="contact-feature__title">Hỗ Trợ Tận Tâm</h5>
                <p class="contact-feature__text">Đội ngũ kỹ thuật viên giàu kinh nghiệm.</p>
            </div>
        </div>
    </div>
</main>
<!-- #endregion -->
@endsection
