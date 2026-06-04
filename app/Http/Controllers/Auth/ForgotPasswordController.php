<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Services\AuthService;
use Illuminate\Http\Request;

class ForgotPasswordController extends Controller
{
    public function showForm()
    {
        return view('auth.forgot-password');
    }

    public function sendResetLink(Request $request, AuthService $authService)
    {
        $validated = $request->validate([
            'email' => ['required', 'email', 'exists:tai_khoans,email'],
        ], [
            'email.required' => 'Vui long nhap email.',
            'email.email' => 'Email khong hop le.',
            'email.exists' => 'Email nay chua duoc dang ky trong he thong.',
        ]);

        $authService->sendPasswordResetLink($validated['email']);

        return back()->with('success', 'Link dat lai mat khau da duoc gui toi email cua ban.');
    }

    public function showResetForm(Request $request, string $token)
    {
        return view('auth.reset-password', [
            'token' => $token,
            'email' => $request->query('email', ''),
        ]);
    }

    public function reset(Request $request, AuthService $authService)
    {
        $validated = $request->validate([
            'email' => ['required', 'email', 'exists:tai_khoans,email'],
            'token' => ['required', 'string'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ], [
            'email.required' => 'Email khong hop le.',
            'email.exists' => 'Email khong ton tai.',
            'password.required' => 'Vui long nhap mat khau moi.',
            'password.min' => 'Mat khau toi thieu 8 ky tu.',
            'password.confirmed' => 'Xac nhan mat khau khong khop.',
        ]);

        $authService->resetPassword($validated['email'], $validated['token'], $validated['password']);

        return redirect()->route('login')->with('success', 'Mat khau da duoc dat lai thanh cong. Vui long dang nhap.');
    }
}
