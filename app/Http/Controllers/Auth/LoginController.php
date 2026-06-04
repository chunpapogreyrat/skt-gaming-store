<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Services\AuthService;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

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

        if ($taiKhoan->isAdmin()) {
            return redirect()->route('admin.dashboard');
        }

        return redirect()->intended(route('home'));
    }

    public function logout(Request $request, AuthService $authService)
    {
        $authService->logout($request);

        return redirect()->route('login');
    }
}
