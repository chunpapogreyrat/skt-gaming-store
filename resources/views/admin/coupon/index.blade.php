@extends('layouts.admin')

@section('title', 'Quản lý mã giảm giá - YUKI Admin')
@section('nav-coupons', 'is-active')

@section('content')
<h1 class="admin-page-title">Quản lý mã giảm giá</h1>
<p class="admin-page-sub">Tạo và theo dõi chương trình khuyến mãi</p>

@if (session('success'))
    <div class="alert alert-success py-2 small my-3"><i class="fa-solid fa-circle-check me-1"></i>{{ session('success') }}</div>
@endif
@if (session('error'))
    <div class="alert alert-danger py-2 small my-3"><i class="fa-solid fa-circle-exclamation me-1"></i>{{ session('error') }}</div>
@endif

<div class="admin-grid-2">
    <section class="admin-table-wrap">
        <div class="admin-table-wrap__head"><h3 class="admin-panel__title">Danh sách mã</h3></div>
        <table class="admin-table">
            <thead><tr><th>Mã code</th><th>Giảm</th><th>Đã dùng</th><th>Hạn</th><th>Trạng thái</th><th></th></tr></thead>
            <tbody>
                @forelse($maGiamGias as $ma)
                @php
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
                @php
                    $hetHan = $ma->ngay_het_han && $ma->ngay_het_han->isPast();
                    $hetLuot = $ma->so_lan_su_dung_toi_da && $ma->so_lan_da_dung >= $ma->so_lan_su_dung_toi_da;
                    $trangThaiText = !$ma->trang_thai ? 'Ngừng' : ($hetHan ? 'Hết hạn' : ($hetLuot ? 'Hết lượt' : 'Hoạt động'));
                @endphp
                <tr class="admin-table__row">
                    <td><strong class="admin-table__clickable" data-bs-toggle="modal" data-bs-target="#couponModal" onclick='{{ $attrs }}' title="Bấm để sửa">{{ $ma->ma_code }}</strong></td>
                    <td class="admin-table__price">{{ $ma->loai=='phan_tram' ? rtrim(rtrim(number_format($ma->gia_tri,2),'0'),'.').'%' : number_format($ma->gia_tri).'đ' }}</td>
                    <td>{{ $ma->so_lan_da_dung }} / {{ $ma->so_lan_su_dung_toi_da ?? '∞' }}</td>
                    <td>{{ $ma->ngay_het_han?->format('d/m/Y') ?? '—' }}</td>
                    <td><span class="admin-badge admin-badge--{{ $ma->conHieuLuc()?'done':'cancel' }}">{{ $trangThaiText }}</span></td>
                    <td>
                        <div class="d-flex gap-2">
                            <button class="admin-icon-btn" title="Sửa" data-bs-toggle="modal" data-bs-target="#couponModal" onclick='{{ $attrs }}'>
                                <i class="fa-solid fa-pen"></i>
                            </button>
                            <form method="POST" action="{{ route('admin.coupons.destroy', $ma->id) }}" onsubmit="return confirm('Xóa mã {{ $ma->ma_code }}?')" class="d-inline">
                                @csrf @method('DELETE')
                                <button class="admin-icon-btn admin-icon-btn--danger" title="Xóa"><i class="fa-solid fa-trash-can"></i></button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr class="admin-table__row"><td colspan="6" class="admin-table__muted">Chưa có mã giảm giá</td></tr>
                @endforelse
            </tbody>
        </table>
        <div class="admin-pagination">{{ $maGiamGias->links() }}</div>
    </section>

    <section class="admin-panel">
        <h3 class="admin-panel__title mb-3">Tạo mã mới</h3>
        <form method="POST" action="{{ route('admin.coupons.store') }}">
            @csrf
            <div class="admin-field">
                <label class="admin-field__label">Mã code</label>
                <input type="text" name="ma_code" class="admin-field__input" style="text-transform:uppercase" value="{{ old('ma_code') }}" required>
                @error('ma_code')<p class="txt-red small">{{ $message }}</p>@enderror
            </div>
            <div class="admin-field">
                <label class="admin-field__label">Loại giảm</label>
                <select name="loai" class="admin-field__select">
                    <option value="phan_tram" @selected(old('loai')==='phan_tram')>Phần trăm (%)</option>
                    <option value="so_tien" @selected(old('loai')==='so_tien')>Số tiền (đ)</option>
                </select>
            </div>
            <div class="admin-field">
                <label class="admin-field__label">Giá trị</label>
                <input type="number" name="gia_tri" class="admin-field__input" value="{{ old('gia_tri') }}" required>
                @error('gia_tri')<p class="txt-red small">{{ $message }}</p>@enderror
            </div>
            <div class="admin-field">
                <label class="admin-field__label">Đơn tối thiểu (đ)</label>
                <input type="number" name="gia_tri_don_toi_thieu" class="admin-field__input" value="{{ old('gia_tri_don_toi_thieu', 0) }}">
            </div>
            <div class="admin-field__row">
                <div class="admin-field">
                    <label class="admin-field__label">Số lượt tối đa</label>
                    <input type="number" name="so_lan_su_dung_toi_da" class="admin-field__input" placeholder="Trống = ∞" value="{{ old('so_lan_su_dung_toi_da') }}">
                </div>
                <div class="admin-field">
                    <label class="admin-field__label">Ngày hết hạn</label>
                    <input type="date" name="ngay_het_han" class="admin-field__input" value="{{ old('ngay_het_han') }}">
                </div>
            </div>
            <div class="admin-field">
                <label class="admin-field__label">Trạng thái</label>
                <select name="trang_thai" class="admin-field__select">
                    <option value="1">Hoạt động</option>
                    <option value="0">Ngừng</option>
                </select>
            </div>
            <div class="admin-form__actions">
                <button type="submit" class="admin-btn admin-btn--primary"><i class="fa-solid fa-plus"></i> Tạo mã</button>
            </div>
        </form>
    </section>
</div>

{{-- #region MODAL SỬA MÃ GIẢM GIÁ --}}
<div class="modal fade" id="couponModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="background: var(--bg-panel); border: 1px solid rgba(255,255,255,.08); color: var(--text-main);">
            <div class="modal-header" style="border-bottom: 1px solid rgba(255,255,255,.06);">
                <h5 class="modal-title admin-panel__title">Sửa mã giảm giá</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="couponEditForm" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="admin-field">
                        <label class="admin-field__label">Mã code</label>
                        <input type="text" name="ma_code" id="edit_ma_code" class="admin-field__input" style="text-transform:uppercase" required>
                    </div>
                    <div class="admin-field__row">
                        <div class="admin-field">
                            <label class="admin-field__label">Loại giảm</label>
                            <select name="loai" id="edit_loai" class="admin-field__select">
                                <option value="phan_tram">Phần trăm (%)</option>
                                <option value="so_tien">Số tiền (đ)</option>
                            </select>
                        </div>
                        <div class="admin-field">
                            <label class="admin-field__label">Giá trị</label>
                            <input type="number" name="gia_tri" id="edit_gia_tri" class="admin-field__input" required>
                        </div>
                    </div>
                    <div class="admin-field">
                        <label class="admin-field__label">Đơn tối thiểu (đ)</label>
                        <input type="number" name="gia_tri_don_toi_thieu" id="edit_don_toi_thieu" class="admin-field__input">
                    </div>
                    <div class="admin-field__row">
                        <div class="admin-field">
                            <label class="admin-field__label">Số lượt tối đa</label>
                            <input type="number" name="so_lan_su_dung_toi_da" id="edit_so_lan" class="admin-field__input" placeholder="Trống = ∞">
                        </div>
                        <div class="admin-field">
                            <label class="admin-field__label">Trạng thái</label>
                            <select name="trang_thai" id="edit_trang_thai" class="admin-field__select">
                                <option value="1">Hoạt động</option>
                                <option value="0">Ngừng</option>
                            </select>
                        </div>
                    </div>
                    <div class="admin-field__row">
                        <div class="admin-field">
                            <label class="admin-field__label">Ngày bắt đầu</label>
                            <input type="date" name="ngay_bat_dau" id="edit_ngay_bat_dau" class="admin-field__input">
                        </div>
                        <div class="admin-field">
                            <label class="admin-field__label">Ngày hết hạn</label>
                            <input type="date" name="ngay_het_han" id="edit_ngay_het_han" class="admin-field__input">
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer" style="border-top: 1px solid rgba(255,255,255,.06);">
                <button type="button" class="admin-btn admin-btn--ghost" data-bs-dismiss="modal">Hủy</button>
                <button type="submit" form="couponEditForm" class="admin-btn admin-btn--primary"><i class="fa-solid fa-floppy-disk"></i> Lưu</button>
            </div>
        </div>
    </div>
</div>
{{-- #endregion --}}
@endsection

@push('scripts')
<script>
    var couponForm = document.getElementById('couponEditForm');
    var couponBaseUrl = @json(url('/admin/ma-giam-gia'));

    function openEditModal(id, code, loai, giaTri, donToiThieu, soLan, ngayBatDau, ngayHetHan, active) {
        couponForm.setAttribute('action', couponBaseUrl + '/' + id);
        document.getElementById('edit_ma_code').value = code || '';
        document.getElementById('edit_loai').value = loai || 'phan_tram';
        document.getElementById('edit_gia_tri').value = giaTri ?? '';
        document.getElementById('edit_don_toi_thieu').value = donToiThieu ?? 0;
        document.getElementById('edit_so_lan').value = soLan ?? '';
        document.getElementById('edit_ngay_bat_dau').value = ngayBatDau || '';
        document.getElementById('edit_ngay_het_han').value = ngayHetHan || '';
        document.getElementById('edit_trang_thai').value = active ? '1' : '0';
    }
</script>
@endpush
