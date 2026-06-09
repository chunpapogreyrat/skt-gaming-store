@extends('auth.layout')

@section('title', 'Tài khoản')

@section('content')

{{-- TARIK MODAL --}}
<div id="tarikModal" class="tarik-modal" role="dialog" aria-modal="true">
    <div class="tarik-modal__bg"></div>
    <button class="tarik-modal__close" aria-label="Đóng"><i class="fa-solid fa-xmark"></i></button>
    <div class="tarik-modal__inner">
        <div class="tarik-modal__badge">YUKI — Pro Pick</div>
        <h2 class="tarik-modal__name">Chào Mừng<br>Chiến Binh!</h2>
        <div class="tarik-modal__divider"></div>
        <p class="tarik-modal__slogan"><em>Tarik</em> đã được chọn được chuột,<br>còn bạn thì sao?</p>
        <a href="{{ route('home') }}" class="tarik-modal__cta"><i class="fa-solid fa-bolt"></i> VÀO CHIẾN TRƯỜNG</a>
    </div>
</div>

<a href="{{ route('home') }}" class="auth-brand">YUKI</a>
<a href="{{ route('home') }}" class="auth-back"><i class="fa-solid fa-arrow-left me-2"></i>TRỞ VỀ TRANG CHỦ</a>

{{-- #region SLIDER AUTH (double-slider login/register + forgot) --}}
<div class="slider-wrap">
    <div class="slider-auth" id="sliderAuth">

        {{-- ===== FORM: ĐĂNG NHẬP ===== --}}
        <div class="slider-auth__form-box slider-auth__form-box--login">
            <form id="loginForm" action="{{ route('login') }}" method="POST" class="slider-auth__form">
                @csrf
                <h2 class="slider-auth__title">Đăng Nhập</h2>
                <div class="slider-auth__socials">
                    <button type="button" class="slider-auth__social"><i class="fa-brands fa-google"></i></button>
                    <button type="button" class="slider-auth__social"><i class="fa-brands fa-facebook-f"></i></button>
                </div>
                <span class="slider-auth__hint">hoặc dùng tài khoản của bạn</span>

                <div class="slider-auth__field">
                    <i class="fa-regular fa-envelope"></i>
                    <input type="text" id="loginEmail" name="email" placeholder="Email / Tài khoản" value="{{ old('email') }}" required>
                </div>
                <div class="slider-auth__field">
                    <i class="fa-solid fa-lock"></i>
                    <input type="password" id="loginPass" name="password" placeholder="Mật khẩu" required>
                    <button type="button" class="slider-auth__eye toggle-password"><i class="fa-regular fa-eye"></i></button>
                </div>

                <div class="auth-msg" data-auth-msg></div>

                <a href="#" data-auth-view="forgot" class="slider-auth__link">Quên mật khẩu?</a>
                <button type="submit" class="slider-auth__btn">ĐĂNG NHẬP</button>

                <p class="slider-auth__mobile-switch">Chưa có tài khoản?
                    <a href="#" data-auth-view="register">Đăng ký</a>
                </p>
            </form>
        </div>

        {{-- ===== FORM: ĐĂNG KÝ ===== --}}
        <div class="slider-auth__form-box slider-auth__form-box--register">
            <form id="registerForm" action="{{ route('register') }}" method="POST" class="slider-auth__form">
                @csrf
                <h2 class="slider-auth__title">Tạo Tài Khoản</h2>
                <div class="slider-auth__socials">
                    <button type="button" class="slider-auth__social"><i class="fa-brands fa-google"></i></button>
                    <button type="button" class="slider-auth__social"><i class="fa-brands fa-facebook-f"></i></button>
                </div>
                <span class="slider-auth__hint">hoặc đăng ký bằng email</span>

                <div class="slider-auth__field">
                    <i class="fa-regular fa-user"></i>
                    <input type="text" id="regName" name="ho_ten" placeholder="Họ và tên" value="{{ old('ho_ten') }}" required>
                </div>
                <div class="slider-auth__field">
                    <i class="fa-regular fa-envelope"></i>
                    <input type="email" id="regEmail" name="email" placeholder="Email" required>
                </div>
                <div class="slider-auth__field">
                    <i class="fa-solid fa-lock"></i>
                    <input type="password" id="regPass" name="password" placeholder="Mật khẩu" required>
                    <button type="button" class="slider-auth__eye toggle-password"><i class="fa-regular fa-eye"></i></button>
                </div>
                <div class="slider-auth__field">
                    <i class="fa-solid fa-clock-rotate-left"></i>
                    <input type="password" id="regPass2" name="password_confirmation" placeholder="Xác nhận mật khẩu" required>
                    <button type="button" class="slider-auth__eye toggle-password"><i class="fa-regular fa-eye"></i></button>
                </div>

                <div class="auth-msg" data-auth-msg></div>

                <button type="submit" class="slider-auth__btn">TẠO TÀI KHOẢN</button>

                <p class="slider-auth__mobile-switch">Đã có tài khoản?
                    <a href="#" data-auth-view="login">Đăng nhập</a>
                </p>
            </form>
        </div>

        {{-- ===== FORM: QUÊN MẬT KHẨU (phủ lên bên login) ===== --}}
        <div class="slider-auth__form-box slider-auth__form-box--forgot">
            <form id="forgotForm" action="{{ route('password.email') }}" method="POST" class="slider-auth__form">
                @csrf
                <div class="slider-auth__key"><i class="fa-solid fa-key"></i></div>
                <h2 class="slider-auth__title">Quên Mật Khẩu</h2>
                <span class="slider-auth__hint">Nhập email, chúng tôi sẽ gửi link đặt lại</span>

                <div class="slider-auth__field">
                    <i class="fa-regular fa-envelope"></i>
                    <input type="email" id="forgotEmail" name="email" placeholder="Email của bạn" required>
                </div>
                <div class="auth-msg" id="forgotMsg" data-auth-msg></div>

                <button type="submit" class="slider-auth__btn">GỬI LINK ĐẶT LẠI</button>
                <a href="#" data-auth-view="login" class="slider-auth__link mt-3">
                    <i class="fa-solid fa-arrow-left me-1"></i> Quay lại đăng nhập
                </a>
            </form>
        </div>

        {{-- ===== OVERLAY (panel màu trượt) ===== --}}
        <div class="slider-auth__overlay-box">
            <div class="slider-auth__overlay">
                {{-- panel hiện khi đang ở REGISTER → mời quay lại login --}}
                <div class="slider-auth__overlay-panel slider-auth__overlay-panel--left">
                    <h2 class="slider-auth__overlay-title">Chào mừng trở lại!</h2>
                    <p class="slider-auth__overlay-text">Đã có tài khoản? Đăng nhập để tiếp tục chinh phục chiến trường.</p>
                    <button type="button" class="slider-auth__ghost" id="goLogin">ĐĂNG NHẬP</button>
                </div>
                {{-- panel hiện khi đang ở LOGIN → mời đăng ký --}}
                <div class="slider-auth__overlay-panel slider-auth__overlay-panel--right">
                    <h2 class="slider-auth__overlay-title">Chào, Chiến Binh!</h2>
                    <p class="slider-auth__overlay-text">Chưa có tài khoản? Đăng ký ngay để nhận ưu đãi độc quyền.</p>
                    <button type="button" class="slider-auth__ghost" id="goRegister">ĐĂNG KÝ</button>
                </div>
            </div>
        </div>

    </div>
</div>
{{-- #endregion --}}

@push('scripts')
<script>
/* ============================================================
   AUTH REAL SUBMIT (Laravel) — Hiến pháp §9.3: submit AJAX → JSON
   – Bắt submit ở CAPTURE phase trên document → chạy TRƯỚC các
     handler fake (initFakeAuth/Register/ForgotPassword) trong
     script.js (gắn ở AT_TARGET), rồi stopImmediatePropagation.
   – Slider trượt (initAuthSwitcher) vẫn do script.js xử lý.
============================================================ */
(function () {
    var csrf = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    var ROUTES = {
        loginForm:    @json(route('login')),
        registerForm: @json(route('register')),
        forgotForm:   @json(route('password.email'))
    };

    function msgBox(form) {
        return form.querySelector('[data-auth-msg]');
    }
    function showErr(form, text) {
        var m = msgBox(form);
        if (m) { m.className = 'auth-msg auth-msg--err'; m.innerHTML = '<i class="fa-solid fa-circle-exclamation"></i> ' + text; }
        form.classList.add('auth-shake');
        setTimeout(function () { form.classList.remove('auth-shake'); }, 500);
    }
    function showOk(form, text) {
        var m = msgBox(form);
        if (m) { m.className = 'auth-msg auth-msg--ok'; m.innerHTML = '<i class="fa-solid fa-circle-check"></i> ' + text; }
    }
    function firstError(data) {
        if (data && data.errors) { for (var k in data.errors) { return data.errors[k][0]; } }
        return (data && data.message) || 'Có lỗi xảy ra, vui lòng thử lại.';
    }
    // Modal chào mừng "Tarik" sau khi đăng nhập/đăng ký → chạm màn hình mới về trang chủ
    function showTarikModal(url) {
        var m = document.getElementById('tarikModal');
        if (!m) { window.location.href = url; return; }
        var cta = m.querySelector('.tarik-modal__cta');
        if (cta) { cta.setAttribute('href', url); }
        m.style.display = 'flex';
        setTimeout(function () { m.classList.add('tarik-modal--visible'); }, 20);
        setTimeout(function () {
            document.addEventListener('click', function onClk(e) {
                if (e.target.closest('.tarik-modal__cta')) return; // bấm CTA tự điều hướng
                document.removeEventListener('click', onClk);
                m.classList.remove('tarik-modal--visible');
                setTimeout(function () { window.location.href = url; }, 400);
            });
        }, 150);
    }

    document.addEventListener('submit', function (e) {
        var form = e.target;
        var url = ROUTES[form.id];
        if (!url) return; // không phải form auth → để yên

        e.preventDefault();
        e.stopImmediatePropagation(); // chặn handler fake trong script.js

        var btn = form.querySelector('.slider-auth__btn');
        var label = btn ? btn.innerHTML : '';
        if (btn) { btn.disabled = true; btn.innerHTML = 'ĐANG XỬ LÝ...'; }

        fetch(url, {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': csrf, 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' },
            credentials: 'same-origin',
            body: new FormData(form)
        })
        .then(function (r) { return r.json().then(function (d) { return { ok: r.ok, data: d }; }); })
        .then(function (res) {
            if (res.ok && res.data.redirect) {
                showTarikModal(res.data.redirect); // hiện modal chào → chạm để vào trang chủ
                return;
            }
            if (res.ok && res.data.success) {
                showOk(form, res.data.message || 'Thành công!');
                if (btn) { btn.innerHTML = 'ĐÃ GỬI ✓'; }
                return;
            }
            showErr(form, firstError(res.data));
            if (btn) { btn.disabled = false; btn.innerHTML = label; }
        })
        .catch(function () {
            showErr(form, 'Không kết nối được máy chủ. Thử lại sau.');
            if (btn) { btn.disabled = false; btn.innerHTML = label; }
        });
    }, true); // capture = true → chạy trước script.js
})();
</script>
@endpush
@endsection
