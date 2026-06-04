<?php

namespace App\Http\Controllers;

use App\Models\SanPham;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class TrangTinhController extends Controller
{
    public function about()
    {
        return view('static.about', [
            'stats' => [
                'products' => SanPham::where('is_active', true)->count(),
                'hotProducts' => SanPham::where('is_active', true)->where('is_hot', true)->count(),
                'saleProducts' => SanPham::where('is_active', true)->where('is_sale', true)->count(),
            ],
        ]);
    }

    public function contact()
    {
        return view('static.contact');
    }

    public function setups()
    {
        return view('static.setups', [
            'setups' => $this->getSetups(),
        ]);
    }

    public function notFound()
    {
        return response()->view('static.404', [
            'suggestedProducts' => SanPham::where('is_active', true)
                ->with(['hinhAnh', 'danhMuc', 'thuongHieu'])
                ->orderByDesc('is_hot')
                ->orderByDesc('luot_ban')
                ->limit(4)
                ->get(),
        ], 404);
    }

    private function getSetups(): Collection
    {
        if (Schema::hasTable('setups_trung_bay')) {
            $setups = DB::table('setups_trung_bay')
                ->where('is_active', true)
                ->orderBy('thu_tu')
                ->orderBy('id')
                ->get();

            if ($setups->isNotEmpty()) {
                return $setups;
            }
        }

        return collect([
            [
                'tieu_de' => 'Cyberpunk Desk',
                'danh_muc' => 'cyberpunk',
                'hinh_anh' => 'assets/images/setups/setup-1.jpg',
                'thu_tu' => 1,
            ],
            [
                'tieu_de' => 'Minimal Aim Station',
                'danh_muc' => 'minimalist',
                'hinh_anh' => 'assets/images/setups/setup-2.jpg',
                'thu_tu' => 2,
            ],
            [
                'tieu_de' => 'White Build',
                'danh_muc' => 'white_build',
                'hinh_anh' => 'assets/images/setups/setup-3.jpg',
                'thu_tu' => 3,
            ],
            [
                'tieu_de' => 'Hardcore FPS Rig',
                'danh_muc' => 'hardcore',
                'hinh_anh' => 'assets/images/setups/setup-4.jpg',
                'thu_tu' => 4,
            ],
            [
                'tieu_de' => 'Creator Battle Desk',
                'danh_muc' => 'other',
                'hinh_anh' => 'assets/images/setups/setup-5.jpg',
                'thu_tu' => 5,
            ],
        ]);
    }
}
