<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Services\AuthService;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request, AuthService $authService)
    {
        $validated = $request->validate([
            'ho_ten' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email', 'unique:tai_khoans,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'so_dien_thoai' => ['nullable', 'string', 'max:15'],
        ], [
            'ho_ten.required' => 'Vui long nhap ho va ten.',
            'email.required' => 'Vui long nhap email.',
            'email.email' => 'Email khong hop le.',
            'email.unique' => 'Email nay da duoc dang ky.',
            'password.required' => 'Vui long nhap mat khau.',
            'password.min' => 'Mat khau toi thieu 8 ky tu.',
            'password.confirmed' => 'Xac nhan mat khau khong khop.',
        ]);

        $authService->register($validated);

        $request->session()->regenerate();

        return redirect()->route('home')->with('success', 'Dang ky thanh cong.');
    }
}
