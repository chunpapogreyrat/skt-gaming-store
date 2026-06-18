<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\AdminService;
use Illuminate\View\View;

class DashboardController extends Controller
{
    // Khởi tạo controller và tiêm service xử lý nghiệp vụ admin
    public function __construct(
        private AdminService $adminService
    ) {}

    // Hiển thị trang tổng quan: thống kê, doanh thu 7 ngày và đơn hàng mới nhất
    public function index(): View
    {
        $thongKe = $this->adminService->thongKeTongQuan();
        $doanhThu7Ngay = $this->adminService->doanhThu7Ngay();
        $donMoiNhat = $this->adminService->donHangMoiNhat();

        return view('admin.dashboard', compact('thongKe', 'doanhThu7Ngay', 'donMoiNhat'));
    }
}
