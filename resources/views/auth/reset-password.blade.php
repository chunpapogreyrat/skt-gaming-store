@extends('auth.layout')

@section('title', 'Đặt lại mật khẩu')

@section('back-link')
<a href="{{ route('login') }}" class="auth-back">
    <i class="fa-solid fa-arrow-left me-2"></i>TRỞ VỀ ĐĂNG NHẬP
</a>
@endsection

@section('content')
<div class="auth-wrap auth-wrap--right">
    <div id="authPanel" class="auth-panel">
        <div class="auth-card">

            <div class="text-center mb-4">
                <div class="forgot-icon"><i class="fa-solid fa-shield-halved"></i></div>
                <h2 class="auth-card__title">Đặt Lại Mật Khẩu</h2>
                <p class="auth-card__subtitle mt-2">Nhập mật khẩu mới cho tài khoản của bạn.</p>
            </div>

            @error('token')
                <div class="alert alert-danger mb-3 py-2 small text-center">
                    <i class="fa-solid fa-triangle-exclamation me-1"></i>{{ $message }}
                </div>
            @enderror

            <form action="{{ route('password.update') }}" method="POST" class="auth-form font-poppins">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">
                <input type="hidden" name="email" value="{{ $email }}">

                {{-- Mật khẩu mới --}}
                <div class="auth-field @error('password') is-invalid @enderror">
                    <span class="auth-field__icon"><i class="fa-solid fa-lock"></i></span>
                    <input type="password" name="password" id="newPass"
                           class="auth-field__input" placeholder=" "
                           required autocomplete="new-password">
                    <label for="newPass" class="auth-field__label">Mật khẩu mới (tối thiểu 8 ký tự)</label>
                    <button type="button" class="auth-field__toggle toggle-password" aria-label="Hiện mật khẩu">
                        <i class="fa-regular fa-eye"></i>
                    </button>
                </div>
                @error('password')
                    <div class="auth-error-msg">{{ $message }}</div>
                @enderror

                {{-- Xác nhận mật khẩu mới --}}
                <div class="auth-field">
                    <span class="auth-field__icon"><i class="fa-solid fa-clock-rotate-left"></i></span>
                    <input type="password" name="password_confirmation" id="newPass2"
                           class="auth-field__input" placeholder=" "
                           required autocomplete="new-password">
                    <label for="newPass2" class="auth-field__label">Xác nhận mật khẩu mới</label>
                    <button type="button" class="auth-field__toggle toggle-password" aria-label="Hiện mật khẩu">
                        <i class="fa-regular fa-eye"></i>
                    </button>
                </div>

                <button type="submit" class="btn w-100 auth-form__btn-submit mb-4">ĐẶT LẠI MẬT KHẨU</button>

            </form>
        </div>
    </div>
</div>
@endsection
