<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\TaiKhoan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required|string',
        ], [
            'email.required'    => 'Vui lòng nhập email.',
            'email.email'       => 'Email không hợp lệ.',
            'password.required' => 'Vui lòng nhập mật khẩu.',
        ]);

        $taiKhoan = TaiKhoan::where('email', $request->email)->first();

        if (! $taiKhoan) {
            return back()->withErrors(['email' => 'Email không tồn tại trong hệ thống.'])->withInput();
        }

        if (! $taiKhoan->isActive()) {
            return back()->withErrors(['email' => 'Tài khoản đã bị khoá. Vui lòng liên hệ hỗ trợ.'])->withInput();
        }

        $credentials = [
            'email'    => $request->email,
            'password' => $request->password,
        ];

        if (! Auth::attempt($credentials, $request->boolean('remember'))) {
            return back()->withErrors(['password' => 'Mật khẩu không chính xác.'])->withInput();
        }

        $request->session()->regenerate();

        // Cập nhật lần đăng nhập cuối
        Auth::user()->update(['lan_dang_nhap_cuoi' => now()]);

        if (Auth::user()->isAdmin()) {
            return redirect()->route('admin.dashboard');
        }

        return redirect()->intended(route('home'));
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'ho_ten'            => 'required|string|max:100',
            'email'             => 'required|email|unique:tai_khoans,email',
            'password'          => 'required|string|min:8|confirmed',
            'so_dien_thoai'     => 'nullable|string|max:15',
        ], [
            'ho_ten.required'   => 'Vui lòng nhập họ và tên.',
            'email.required'    => 'Vui lòng nhập email.',
            'email.email'       => 'Email không hợp lệ.',
            'email.unique'      => 'Email này đã được đăng ký.',
            'password.required' => 'Vui lòng nhập mật khẩu.',
            'password.min'      => 'Mật khẩu tối thiểu 8 ký tự.',
            'password.confirmed'=> 'Xác nhận mật khẩu không khớp.',
        ]);

        $taiKhoan = TaiKhoan::create([
            'ho_ten'        => $request->ho_ten,
            'email'         => $request->email,
            'mat_khau'      => Hash::make($request->password),
            'so_dien_thoai' => $request->so_dien_thoai,
            'role'          => 'customer',
        ]);

        Auth::login($taiKhoan);

        $request->session()->regenerate();

        return redirect()->route('home')->with('success', 'Đăng ký thành công! Chào mừng bạn đến với YUKI.');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
