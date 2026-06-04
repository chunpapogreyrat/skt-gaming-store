@extends('auth.layout')

@section('title', 'Đăng nhập')

@section('back-link')
<a href="{{ route('home') }}" class="auth-back">
    <i class="fa-solid fa-arrow-left me-2"></i>TRỞ VỀ TRANG CHỦ
</a>
@endsection

@section('content')

{{-- Tarik Modal (bên trái) --}}
<div id="tarikModal" class="tarik-modal" role="dialog" aria-modal="true">
    <div class="tarik-modal__bg"></div>
    <button class="tarik-modal__close" aria-label="Đóng"><i class="fa-solid fa-xmark"></i></button>
    <div class="tarik-modal__inner">
        <div class="tarik-modal__badge">YUKI — Pro Pick</div>
        <h2 class="tarik-modal__name">Chào Mừng<br>Chiến Binh!</h2>
        <div class="tarik-modal__divider"></div>
        <p class="tarik-modal__slogan">
            <em>Tarik</em> đã được chọn được chuột,<br>còn bạn thì sao?
        </p>
        <a href="{{ route('home') }}" class="tarik-modal__cta">
            <i class="fa-solid fa-bolt"></i> VÀO CHIẾN TRƯỜNG
        </a>
    </div>
</div>

<div class="auth-wrap auth-wrap--right">
    <div id="authPanel" class="auth-panel">
        <div class="auth-card">

            {{-- Flash message thành công (sau khi reset password) --}}
            @if (session('success'))
                <div class="alert alert-success mb-3 py-2 small">
                    <i class="fa-solid fa-circle-check me-1"></i>{{ session('success') }}
                </div>
            @endif

            <div class="text-center mb-4">
                <h2 class="auth-card__title">Đăng Nhập Hệ Thống</h2>
                <p class="auth-card__subtitle mt-2">Chào mừng chiến binh quay trở lại chiến trường.</p>
            </div>

            <form action="{{ route('login') }}" method="POST" class="auth-form font-poppins">
                @csrf

                {{-- Email --}}
                <div class="auth-field @error('email') is-invalid @enderror">
                    <span class="auth-field__icon"><i class="fa-regular fa-envelope"></i></span>
                    <input type="email" name="email" id="loginEmail"
                           class="auth-field__input" placeholder=" "
                           value="{{ old('email') }}" required autocomplete="email">
                    <label for="loginEmail" class="auth-field__label">Email / Tài khoản</label>
                </div>
                @error('email')
                    <div class="auth-error-msg">{{ $message }}</div>
                @enderror

                {{-- Mật khẩu --}}
                <div class="auth-field @error('password') is-invalid @enderror">
                    <span class="auth-field__icon"><i class="fa-solid fa-lock"></i></span>
                    <input type="password" name="password" id="loginPass"
                           class="auth-field__input" placeholder=" "
                           required autocomplete="current-password">
                    <label for="loginPass" class="auth-field__label">Mật khẩu</label>
                    <button type="button" class="auth-field__toggle toggle-password" aria-label="Hiện mật khẩu">
                        <i class="fa-regular fa-eye"></i>
                    </button>
                </div>
                @error('password')
                    <div class="auth-error-msg">{{ $message }}</div>
                @enderror

                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div class="form-check auth-form__check">
                        <input class="form-check-input bg-dark border-secondary" type="checkbox"
                               name="remember" id="rememberMe" {{ old('remember') ? 'checked' : '' }}>
                        <label class="form-check-label text-secondary" for="rememberMe" style="font-size:0.83rem;">
                            Ghi nhớ đăng nhập
                        </label>
                    </div>
                    <a href="{{ route('password.request') }}"
                       data-slide-to="{{ route('password.request') }}"
                       data-transition="spin"
                       class="auth-form__forgot-link">
                        Quên mật khẩu?
                    </a>
                </div>

                <button type="submit" class="btn w-100 auth-form__btn-submit mb-4">ĐĂNG NHẬP</button>

                <div class="d-flex align-items-center mb-4">
                    <hr class="flex-grow-1 border-secondary opacity-25">
                    <span class="mx-3 small font-poppins text-muted">HOẶC</span>
                    <hr class="flex-grow-1 border-secondary opacity-25">
                </div>

                <div class="row g-3 mb-4">
                    <div class="col-6">
                        <button type="button" class="btn auth-form__btn-social btn-google w-100 py-2">
                            <i class="fa-brands fa-google me-2"></i>GOOGLE
                        </button>
                    </div>
                    <div class="col-6">
                        <button type="button" class="btn auth-form__btn-social btn-facebook w-100 py-2">
                            <i class="fa-brands fa-facebook-f me-2"></i>FACEBOOK
                        </button>
                    </div>
                </div>

                <div class="text-center font-poppins">
                    <a href="{{ route('register') }}"
                       data-slide-to="{{ route('register') }}"
                       data-transition="slide-left"
                       class="auth-form__register-link">
                        Chưa có tài khoản? <span>Đăng ký ngay</span>
                    </a>
                </div>

            </form>
        </div>
    </div>
</div>
@endsection
