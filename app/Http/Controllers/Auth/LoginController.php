<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Services\AuthService;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    // Hiển thị trang đăng nhập
    public function showLogin()
    {
        return view('auth.login');
    }

    // Xác thực đăng nhập rồi điều hướng admin về trang quản trị, khách về trang chủ
    public function login(Request $request, AuthService $authService)
    {
        $validated = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ], [
            'email.required' => 'Vui long nhap email.',
            'email.email' => 'Email khong hop le.',
            'password.required' => 'Vui long nhap mat khau.',
        ]);

        $taiKhoan = $authService->login($validated, $request->boolean('remember'));

        $request->session()->regenerate();

        // Admin -> trang quản trị; khách -> thẳng trang chủ (không dùng intended)
        $target = $taiKhoan->isAdmin()
            ? route('admin.dashboard')
            : route('home');

        if ($request->expectsJson()) {
            return response()->json(['success' => true, 'redirect' => $target]);
        }

        return redirect()->to($target);
    }

    // Đăng xuất tài khoản rồi chuyển về trang đăng nhập
    public function logout(Request $request, AuthService $authService)
    {
        $authService->logout($request);

        return redirect()->route('login');
    }
}
