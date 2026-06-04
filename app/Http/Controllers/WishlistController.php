<?php

namespace App\Http\Controllers;

use App\Models\SanPham;
use App\Models\Wishlist;
use Illuminate\Http\Request;

class WishlistController extends Controller
{
    public function store(Request $request, SanPham $sanPham)
    {
        Wishlist::firstOrCreate([
            'tai_khoan_id' => $request->user()->id,
            'san_pham_id' => $sanPham->id,
        ]);

        return back()->with('success', 'San pham da duoc them vao wishlist.')->with('active_tab', 'wishlist');
    }

    public function destroy(Request $request, Wishlist $wishlist)
    {
        abort_unless($wishlist->tai_khoan_id === $request->user()->id, 403);

        $wishlist->delete();

        return back()->with('success', 'San pham da duoc xoa khoi wishlist.')->with('active_tab', 'wishlist');
    }
}
