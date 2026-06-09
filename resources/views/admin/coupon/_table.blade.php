<table class="admin-table">
    <thead><tr><th>Mã code</th><th>Giảm</th><th>Đã dùng</th><th>Hạn</th><th>Trạng thái</th><th></th></tr></thead>
    <tbody>
        @forelse($maGiamGias as $ma)
        @php
            $chuaMo  = $ma->ngay_bat_dau && $ma->ngay_bat_dau->isFuture();
            $hetHan  = $ma->ngay_het_han && $ma->ngay_het_han->isPast();
            $hetLuot = $ma->so_lan_su_dung_toi_da && $ma->so_lan_da_dung >= $ma->so_lan_su_dung_toi_da;
            $trangThaiText = !$ma->trang_thai ? 'Ngừng'
                : ($hetHan ? 'Hết hạn' : ($hetLuot ? 'Hết lượt' : ($chuaMo ? 'Chưa mở' : 'Hoạt động')));
            $attrs = "openEditModal(" . $ma->id
                . ", " . json_encode($ma->ma_code)
                . ", " . json_encode($ma->loai)
                . ", " . json_encode((float) $ma->gia_tri)
                . ", " . json_encode((float) $ma->gia_tri_don_toi_thieu)
                . ", " . json_encode($ma->so_lan_su_dung_toi_da)
                . ", " . json_encode(optional($ma->ngay_bat_dau)->format('Y-m-d'))
                . ", " . json_encode(optional($ma->ngay_het_han)->format('Y-m-d'))
                . ", " . ($ma->trang_thai ? 1 : 0) . ")";
        @endphp
        <tr class="admin-table__row">
            <td><strong class="admin-table__clickable" onclick='{{ $attrs }}' title="Bấm để sửa">{{ $ma->ma_code }}</strong></td>
            <td class="admin-table__price">{{ $ma->loai=='phan_tram' ? rtrim(rtrim(number_format($ma->gia_tri,2),'0'),'.').'%' : number_format($ma->gia_tri).'đ' }}</td>
            <td>{{ $ma->so_lan_da_dung }} / {{ $ma->so_lan_su_dung_toi_da ?? '∞' }}</td>
            <td>{{ $ma->ngay_het_han?->format('d/m/Y') ?? '—' }}</td>
            <td><span class="admin-badge admin-badge--{{ $ma->conHieuLuc()?'done':'cancel' }}">{{ $trangThaiText }}</span></td>
            <td>
                <div class="d-flex gap-2">
                    <button type="button" class="admin-icon-btn" title="Sửa" onclick='{{ $attrs }}'><i class="fa-solid fa-pen"></i></button>
                    <button type="button" class="admin-icon-btn admin-icon-btn--danger" title="Xóa" data-delete-coupon="{{ $ma->id }}" data-code="{{ $ma->ma_code }}"><i class="fa-solid fa-trash-can"></i></button>
                </div>
            </td>
        </tr>
        @empty
        <tr class="admin-table__row"><td colspan="6" class="admin-table__muted">Chưa có mã giảm giá</td></tr>
        @endforelse
    </tbody>
</table>
<div class="admin-pagination">{{ $maGiamGias->links() }}</div>
