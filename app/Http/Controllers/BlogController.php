<?php

namespace App\Http\Controllers;

use App\Models\BaiViet;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BlogController extends Controller
{
    public function index(Request $request): View
    {
        $danhMuc = $request->query('danh_muc');
        $tuKhoa  = $request->query('q');

        $query = BaiViet::where('is_active', true);

        if ($danhMuc && array_key_exists($danhMuc, BaiViet::DANH_MUC)) {
            $query->where('danh_muc', $danhMuc);
        }

        if ($tuKhoa) {
            $query->where(function ($q) use ($tuKhoa) {
                $q->where('tieu_de', 'like', "%{$tuKhoa}%")
                  ->orWhere('mo_ta_ngan', 'like', "%{$tuKhoa}%");
            });
        }

        // Bài nổi bật (hero): chỉ khi không lọc/tìm kiếm. Luôn loại khỏi lưới ở mọi trang,
        // nhưng chỉ hiển thị hero ở TRANG 1 (tránh lặp hero + lệch lưới ở trang 2).
        $featured = null;
        if (! $danhMuc && ! $tuKhoa) {
            $featuredPost = BaiViet::where('is_active', true)
                ->orderByDesc('is_featured')
                ->orderByDesc('ngay_dang')
                ->first();

            if ($featuredPost) {
                $query->where('id', '!=', $featuredPost->id);
                if ((int) $request->query('page', 1) === 1) {
                    $featured = $featuredPost;
                }
            }
        }

        $baiViets = $query->orderByDesc('ngay_dang')->paginate(6)->withQueryString();

        // Đếm bài theo danh mục cho thanh lọc
        $demTheoDanhMuc = BaiViet::where('is_active', true)
            ->selectRaw('danh_muc, count(*) as tong')
            ->groupBy('danh_muc')
            ->pluck('tong', 'danh_muc');

        $phoBien = BaiViet::where('is_active', true)
            ->orderByDesc('luot_xem')
            ->limit(4)
            ->get();

        return view('blog.index', [
            'featured'       => $featured,
            'baiViets'       => $baiViets,
            'danhMucActive'  => $danhMuc,
            'tuKhoa'         => $tuKhoa,
            'danhMucs'       => BaiViet::DANH_MUC,
            'demTheoDanhMuc' => $demTheoDanhMuc,
            'phoBien'        => $phoBien,
            'tongBai'        => BaiViet::where('is_active', true)->count(),
        ]);
    }

    public function show(BaiViet $baiViet): View
    {
        abort_unless($baiViet->is_active, 404);

        $baiViet->increment('luot_xem');

        $lienQuan = BaiViet::where('is_active', true)
            ->where('id', '!=', $baiViet->id)
            ->where('danh_muc', $baiViet->danh_muc)
            ->orderByDesc('ngay_dang')
            ->limit(3)
            ->get();

        // Bổ sung nếu cùng danh mục chưa đủ 3 bài
        if ($lienQuan->count() < 3) {
            $themBai = BaiViet::where('is_active', true)
                ->where('id', '!=', $baiViet->id)
                ->whereNotIn('id', $lienQuan->pluck('id'))
                ->orderByDesc('ngay_dang')
                ->limit(3 - $lienQuan->count())
                ->get();
            $lienQuan = $lienQuan->concat($themBai);
        }

        $moiNhat = BaiViet::where('is_active', true)
            ->where('id', '!=', $baiViet->id)
            ->orderByDesc('ngay_dang')
            ->limit(4)
            ->get();

        return view('blog.show', [
            'baiViet'  => $baiViet,
            'lienQuan' => $lienQuan,
            'moiNhat'  => $moiNhat,
            'danhMucs' => BaiViet::DANH_MUC,
        ]);
    }
}
