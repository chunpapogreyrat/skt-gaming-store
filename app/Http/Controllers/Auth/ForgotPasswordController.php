<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\ResetPasswordMail;
use App\Models\TaiKhoan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class ForgotPasswordController extends Controller
{
    public function showForm()
    {
        return view('auth.forgot-password');
    }

    public function sendResetLink(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:tai_khoans,email',
        ], [
            'email.required' => 'Vui lòng nhập email.',
            'email.email'    => 'Email không hợp lệ.',
            'email.exists'   => 'Email này chưa được đăng ký trong hệ thống.',
        ]);

        // Xoá token cũ nếu có
        DB::table('password_reset_tokens')->where('email', $request->email)->delete();

        $token = Str::random(64);

        DB::table('password_reset_tokens')->insert([
            'email'      => $request->email,
            'token'      => Hash::make($token),
            'created_at' => now(),
        ]);

        $resetUrl = route('password.reset', ['token' => $token, 'email' => $request->email]);

        Mail::to($request->email)->send(new ResetPasswordMail($resetUrl));

        return back()->with('success', 'Link đặt lại mật khẩu đã được gửi tới email của bạn. Vui lòng kiểm tra hộp thư (kể cả spam).');
    }

    public function showResetForm(Request $request, string $token)
    {
        return view('auth.reset-password', [
            'token' => $token,
            'email' => $request->query('email', ''),
        ]);
    }

    public function reset(Request $request)
    {
        $request->validate([
            'email'    => 'required|email|exists:tai_khoans,email',
            'token'    => 'required|string',
            'password' => 'required|string|min:8|confirmed',
        ], [
            'email.required'    => 'Email không hợp lệ.',
            'email.exists'      => 'Email không tồn tại.',
            'password.required' => 'Vui lòng nhập mật khẩu mới.',
            'password.min'      => 'Mật khẩu tối thiểu 8 ký tự.',
            'password.confirmed'=> 'Xác nhận mật khẩu không khớp.',
        ]);

        $record = DB::table('password_reset_tokens')
            ->where('email', $request->email)
            ->first();

        if (! $record || ! Hash::check($request->token, $record->token)) {
            return back()->withErrors(['token' => 'Link đặt lại mật khẩu không hợp lệ hoặc đã hết hạn.']);
        }

        // Token hết hạn sau 60 phút
        if (now()->diffInMinutes($record->created_at) > 60) {
            DB::table('password_reset_tokens')->where('email', $request->email)->delete();
            return back()->withErrors(['token' => 'Link đặt lại mật khẩu đã hết hạn. Vui lòng yêu cầu link mới.']);
        }

        TaiKhoan::where('email', $request->email)->update([
            'mat_khau' => Hash::make($request->password),
        ]);

        DB::table('password_reset_tokens')->where('email', $request->email)->delete();

        return redirect()->route('login')->with('success', 'Mật khẩu đã được đặt lại thành công. Vui lòng đăng nhập.');
    }
}
