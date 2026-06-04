@extends('auth.layout')

@section('title', 'Đăng ký')

@section('back-link')
<a href="{{ route('home') }}" class="auth-back">
    <i class="fa-solid fa-arrow-left me-2"></i>TRỞ VỀ TRANG CHỦ
</a>
@endsection

@section('content')
<div class="auth-wrap auth-wrap--left">
    <div id="authPanel" class="auth-panel">
        <div class="auth-card">

            <div class="text-center mb-4">
                <h2 class="auth-card__title">Đăng Ký Tài Khoản</h2>
                <p class="auth-card__subtitle mt-2">Tạo tài khoản để nhận ưu đãi độc quyền.</p>
            </div>

            <form action="{{ route('register') }}" method="POST" class="auth-form font-poppins">
                @csrf

                {{-- Họ tên --}}
                <div class="auth-field @error('ho_ten') is-invalid @enderror">
                    <span class="auth-field__icon"><i class="fa-regular fa-user"></i></span>
                    <input type="text" name="ho_ten" id="regName"
                           class="auth-field__input" placeholder=" "
                           value="{{ old('ho_ten') }}" required autocomplete="name">
                    <label for="regName" class="auth-field__label">Họ và tên</label>
                </div>
                @error('ho_ten')
                    <div class="auth-error-msg">{{ $message }}</div>
                @enderror

                {{-- Email --}}
                <div class="auth-field @error('email') is-invalid @enderror">
                    <span class="auth-field__icon"><i class="fa-regular fa-envelope"></i></span>
                    <input type="email" name="email" id="regEmail"
                           class="auth-field__input" placeholder=" "
                           value="{{ old('email') }}" required autocomplete="email">
                    <label for="regEmail" class="auth-field__label">Email</label>
                </div>
                @error('email')
                    <div class="auth-error-msg">{{ $message }}</div>
                @enderror

                {{-- Mật khẩu --}}
                <div class="auth-field @error('password') is-invalid @enderror">
                    <span class="auth-field__icon"><i class="fa-solid fa-lock"></i></span>
                    <input type="password" name="password" id="regPass"
                           class="auth-field__input" placeholder=" "
                           required autocomplete="new-password">
                    <label for="regPass" class="auth-field__label">Mật khẩu (tối thiểu 8 ký tự)</label>
                    <button type="button" class="auth-field__toggle toggle-password" aria-label="Hiện mật khẩu">
                        <i class="fa-regular fa-eye"></i>
                    </button>
                </div>
                @error('password')
                    <div class="auth-error-msg">{{ $message }}</div>
                @enderror

                {{-- Xác nhận mật khẩu --}}
                <div class="auth-field">
                    <span class="auth-field__icon"><i class="fa-solid fa-clock-rotate-left"></i></span>
                    <input type="password" name="password_confirmation" id="regPass2"
                           class="auth-field__input" placeholder=" "
                           required autocomplete="new-password">
                    <label for="regPass2" class="auth-field__label">Xác nhận mật khẩu</label>
                    <button type="button" class="auth-field__toggle toggle-password" aria-label="Hiện mật khẩu">
                        <i class="fa-regular fa-eye"></i>
                    </button>
                </div>

                <button type="submit" class="btn w-100 auth-form__btn-submit mb-4">TẠO TÀI KHOẢN</button>

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
                    <a href="{{ route('login') }}"
                       data-slide-to="{{ route('login') }}"
                       data-transition="slide-right"
                       class="auth-form__register-link">
                        Đã có tài khoản? <span>Đăng nhập</span>
                    </a>
                </div>

            </form>
        </div>
    </div>
</div>
@endsection
