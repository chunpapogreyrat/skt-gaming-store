<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\AdminService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DoanhThuController extends Controller
{
    public function __construct(
        private AdminService $adminService
    ) {}

    public function index(Request $request): View
    {
        $now = now();
        $nam = (int) $request->query('nam', $now->year);
        $thang = (int) $request->query('thang', $now->month);

        // Không xem năm tương lai
        if ($nam > $now->year) {
            $nam = (int) $now->year;
        }

        // Năm nay chỉ tới tháng hiện tại; năm cũ tới T12
        $thangToiDa = $nam === (int) $now->year ? (int) $now->month : 12;
        if ($thang < 1 || $thang > $thangToiDa) {
            $thang = $thangToiDa;
        }

        $baoCao = $this->adminService->baoCaoDoanhThu($nam, $thang);

        return view('admin.doanh-thu', compact('baoCao'));
    }
}
