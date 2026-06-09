<?php

namespace App\Services;

use App\Mail\ResetPasswordMail;
use App\Models\TaiKhoan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class AuthService
{
    public function login(array $credentials, bool $remember = false): TaiKhoan
    {
        $email = $credentials['email'] ?? '';
        $password = $credentials['password'] ?? '';

        $taiKhoan = TaiKhoan::where('email', $email)->first();

        if (! $taiKhoan) {
            throw ValidationException::withMessages([
                'email' => 'Email khong ton tai trong he thong.',
            ]);
        }

        if (! $taiKhoan->isActive()) {
            throw ValidationException::withMessages([
                'email' => 'Tai khoan da bi khoa. Vui long lien he ho tro.',
            ]);
        }

        if (! Hash::check($password, $taiKhoan->mat_khau)) {
            throw ValidationException::withMessages([
                'password' => 'Mat khau khong chinh xac.',
            ]);
        }

        Auth::login($taiKhoan, $remember);

        $taiKhoan->forceFill([
            'lan_dang_nhap_cuoi' => now(),
        ])->save();

        return $taiKhoan;
    }

    public function register(array $data): TaiKhoan
    {
        $taiKhoan = TaiKhoan::create([
            'ho_ten' => $data['ho_ten'],
            'email' => $data['email'],
            'mat_khau' => Hash::make($data['password']),
            'so_dien_thoai' => $data['so_dien_thoai'] ?? null,
            'role' => 'customer',
        ]);

        Auth::login($taiKhoan);

        return $taiKhoan;
    }

    public function logout(Request $request): void
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();
    }

    public function sendPasswordResetLink(string $email): void
    {
        DB::table('password_reset_tokens')->where('email', $email)->delete();

        $token = Str::random(64);

        DB::table('password_reset_tokens')->insert([
            'email' => $email,
            'token' => Hash::make($token),
            'created_at' => now(),
        ]);

        $resetUrl = route('password.reset', ['token' => $token, 'email' => $email]);

        // Gửi email; nếu SMTP chưa cấu hình (thiếu App Password) thì không làm sập request
        // — token đã lưu DB nên link vẫn dùng được (xem log nếu mail lỗi).
        try {
            Mail::to($email)->send(new ResetPasswordMail($resetUrl));
        } catch (\Throwable $e) {
            \Illuminate\Support\Facades\Log::warning('Gui email reset that bai: ' . $e->getMessage());
        }
    }

    public function resetPassword(string $email, string $token, string $password): void
    {
        $record = DB::table('password_reset_tokens')
            ->where('email', $email)
            ->first();

        if (! $record || ! Hash::check($token, $record->token)) {
            throw ValidationException::withMessages([
                'token' => 'Link dat lai mat khau khong hop le hoac da het han.',
            ]);
        }

        $expiresInMinutes = (int) config('auth.passwords.users.expire', 60);

        if (Carbon::parse($record->created_at)->addMinutes($expiresInMinutes)->isPast()) {
            DB::table('password_reset_tokens')->where('email', $email)->delete();

            throw ValidationException::withMessages([
                'token' => 'Link dat lai mat khau da het han. Vui long yeu cau link moi.',
            ]);
        }

        TaiKhoan::where('email', $email)->update([
            'mat_khau' => Hash::make($password),
        ]);

        DB::table('password_reset_tokens')->where('email', $email)->delete();
    }
}
