<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\AdminService;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __construct(
        private AdminService $adminService
    ) {}

    public function index(): View
    {
        $thongKe = $this->adminService->thongKeTongQuan();
        $doanhThu7Ngay = $this->adminService->doanhThu7Ngay();
        $donMoiNhat = $this->adminService->donHangMoiNhat();

        return view('admin.dashboard', compact('thongKe', 'doanhThu7Ngay', 'donMoiNhat'));
    }
}
