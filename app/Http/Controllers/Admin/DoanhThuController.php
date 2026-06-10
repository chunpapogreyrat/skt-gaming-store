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
        $nam = (int) $request->query('nam', now()->year);
        $thang = (int) $request->query('thang', now()->month);

        if ($thang < 1 || $thang > 12) {
            $thang = (int) now()->month;
        }

        $baoCao = $this->adminService->baoCaoDoanhThu($nam, $thang);

        return view('admin.doanh-thu', compact('baoCao'));
    }
}
