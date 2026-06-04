@extends('auth.layout')

@section('title', 'Quên mật khẩu')

@section('back-link')
<a href="{{ route('login') }}"
   data-slide-to="{{ route('login') }}"
   data-transition="spin"
   class="auth-back">
    <i class="fa-solid fa-arrow-left me-2"></i>TRỞ VỀ ĐĂNG NHẬP
</a>
@endsection

@section('content')
<div class="auth-wrap auth-wrap--right">
    <div id="authPanel" class="auth-panel">
        <div class="auth-card">

            <div class="text-center mb-4">
                <div class="forgot-icon"><i class="fa-solid fa-key"></i></div>
                <h2 class="auth-card__title">Quên Mật Khẩu</h2>
                <p class="auth-card__subtitle mt-2">Nhập email đăng ký, chúng tôi sẽ gửi link đặt lại mật khẩu.</p>
            </div>

            {{-- Thành công --}}
            @if (session('success'))
                <div class="alert alert-success mb-3 py-2 small text-center">
                    <i class="fa-solid fa-envelope-circle-check me-1"></i>{{ session('success') }}
                </div>
            @endif

            <form action="{{ route('password.email') }}" method="POST" class="auth-form font-poppins">
                @csrf

                <div class="auth-field @error('email') is-invalid @enderror">
                    <span class="auth-field__icon"><i class="fa-regular fa-envelope"></i></span>
                    <input type="email" name="email" id="forgotEmail"
                           class="auth-field__input" placeholder=" "
                           value="{{ old('email') }}" required autocomplete="email">
                    <label for="forgotEmail" class="auth-field__label">Email của bạn</label>
                </div>
                @error('email')
                    <div class="auth-error-msg">{{ $message }}</div>
                @enderror

                <button type="submit" class="btn w-100 auth-form__btn-submit mb-4">GỬI LINK ĐẶT LẠI</button>

                <div class="text-center font-poppins">
                    <a href="{{ route('login') }}"
                       data-slide-to="{{ route('login') }}"
                       data-transition="spin"
                       class="auth-form__register-link">
                        Nhớ ra mật khẩu rồi? <span>Đăng nhập</span>
                    </a>
                </div>

            </form>
        </div>
    </div>
</div>
@endsection
