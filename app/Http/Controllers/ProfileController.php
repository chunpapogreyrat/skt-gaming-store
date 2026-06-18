<?php

namespace App\Http\Controllers;

use App\Models\DanhGiaSanPham;
use App\Models\DonHang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    // Hien thi trang ca nhan voi tab dang chon, kem dia chi, wishlist, don hang, danh gia va thong ke
    public function show(Request $request)
    {
        $user = $request->user();
        $tabs = ['overview', 'profile', 'addresses', 'wishlist', 'orders', 'reviews', 'security'];
        $activeTab = session('active_tab', $request->query('tab', 'overview'));

        if (! in_array($activeTab, $tabs, true)) {
            $activeTab = 'overview';
        }

        $addresses = $user->diaChi()
            ->orderByDesc('is_mac_dinh')
            ->orderByDesc('id')
            ->get();

        $wishlistItems = $user->wishlists()
            ->with(['sanPham.hinhAnh', 'sanPham.danhMuc', 'sanPham.thuongHieu'])
            ->orderByDesc('ngay_tao')
            ->get();

        // DonHang dùng schema Module 4: created_at + chi_tiet_don_hangs (số nhiều)
        $orders = DonHang::where('tai_khoan_id', $user->id)
            ->with(['chiTiet.sanPham'])
            ->latest()
            ->limit(10)
            ->get();

        $reviews = DanhGiaSanPham::where('tai_khoan_id', $user->id)
            ->with(['sanPham.hinhAnh'])
            ->orderByDesc('ngay_tao')
            ->limit(10)
            ->get();

        $stats = [
            'addresses' => $addresses->count(),
            'wishlist' => $wishlistItems->count(),
            'orders' => DonHang::where('tai_khoan_id', $user->id)->count(),
            'reviews' => DanhGiaSanPham::where('tai_khoan_id', $user->id)->count(),
        ];

        return view('nguoi-dung.profile', compact(
            'user',
            'activeTab',
            'addresses',
            'wishlistItems',
            'orders',
            'reviews',
            'stats',
        ));
    }

    // Cap nhat thong tin ca nhan (ho ten, email, dien thoai, ngay sinh, gioi tinh) sau khi xac thuc
    public function update(Request $request)
    {
        $validated = $request->validate([
            'ho_ten' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email', Rule::unique('tai_khoans', 'email')->ignore($request->user()->id)],
            'so_dien_thoai' => ['nullable', 'string', 'max:15'],
            'ngay_sinh' => ['nullable', 'date'],
            'gioi_tinh' => ['nullable', Rule::in(['nam', 'nu', 'khac'])],
        ], [
            'ho_ten.required' => 'Vui long nhap ho ten.',
            'email.required' => 'Vui long nhap email.',
            'email.email' => 'Email khong hop le.',
            'email.unique' => 'Email nay da duoc su dung.',
        ]);

        $request->user()->forceFill($validated)->save();

        return back()->with('success', 'Thong tin tai khoan da duoc cap nhat.')->with('active_tab', 'profile');
    }

    // Doi mat khau: kiem tra mat khau hien tai roi luu mat khau moi da ma hoa
    public function updatePassword(Request $request)
    {
        $validated = $request->validate([
            'current_password' => ['required', 'string'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ], [
            'current_password.required' => 'Vui long nhap mat khau hien tai.',
            'password.required' => 'Vui long nhap mat khau moi.',
            'password.min' => 'Mat khau moi toi thieu 8 ky tu.',
            'password.confirmed' => 'Xac nhan mat khau khong khop.',
        ]);

        if (! Hash::check($validated['current_password'], $request->user()->mat_khau)) {
            return back()
                ->withErrors(['current_password' => 'Mat khau hien tai khong chinh xac.'])
                ->with('active_tab', 'security');
        }

        $request->user()->forceFill([
            'mat_khau' => Hash::make($validated['password']),
        ])->save();

        return back()->with('success', 'Mat khau da duoc cap nhat.')->with('active_tab', 'security');
    }
}
