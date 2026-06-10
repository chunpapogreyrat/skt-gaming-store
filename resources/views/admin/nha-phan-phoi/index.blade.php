@extends('layouts.admin')

@section('title', 'Nhà phân phối - YUKI Admin')
@section('nav-suppliers', 'is-active')

@section('content')
<div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
    <div>
        <h1 class="admin-page-title">Nhà phân phối</h1>
        <p class="admin-page-sub">{{ $thongKe['tong'] }} nhà phân phối · {{ $thongKe['active'] }} đang hợp tác</p>
    </div>
    <button class="admin-btn admin-btn--primary" data-bs-toggle="modal" data-bs-target="#supplierModal" onclick="openAddSupplier()">
        <i class="fa-solid fa-plus"></i> Thêm nhà phân phối
    </button>
</div>

{{-- STAT CARDS --}}
<div class="admin-stats" style="grid-template-columns:repeat(4,1fr);margin:24px 0">
    <div class="admin-card">
        <div class="admin-stat__top">
            <div class="admin-stat__icon admin-stat__icon--cyan"><i class="fa-solid fa-truck-ramp-box"></i></div>
        </div>
        <div class="admin-stat__value">{{ $thongKe['tong'] }}</div>
        <div class="admin-stat__label">Tổng nhà phân phối</div>
    </div>
    <div class="admin-card">
        <div class="admin-stat__top">
            <div class="admin-stat__icon admin-stat__icon--green"><i class="fa-solid fa-handshake"></i></div>
        </div>
        <div class="admin-stat__value">{{ $thongKe['active'] }}</div>
        <div class="admin-stat__label">Đang hợp tác</div>
    </div>
    <div class="admin-card">
        <div class="admin-stat__top">
            <div class="admin-stat__icon admin-stat__icon--amber"><i class="fa-solid fa-pause"></i></div>
        </div>
        <div class="admin-stat__value">{{ $thongKe['paused'] }}</div>
        <div class="admin-stat__label">Tạm dừng</div>
    </div>
    <div class="admin-card">
        <div class="admin-stat__top">
            <div class="admin-stat__icon admin-stat__icon--red"><i class="fa-solid fa-box-open"></i></div>
        </div>
        <div class="admin-stat__value">{{ number_format($thongKe['tong_sku']) }}</div>
        <div class="admin-stat__label">Tổng SKU đang nhập</div>
    </div>
</div>

{{-- TABLE --}}
<section class="admin-table-wrap">
    <div class="admin-table-wrap__head">
        <h3 class="admin-panel__title">Danh sách nhà phân phối</h3>
        <form method="GET" action="{{ route('admin.suppliers.index') }}" class="d-flex gap-2 flex-wrap align-items-center">
            <input name="q" value="{{ request('q') }}" class="admin-status-select" placeholder="Tìm tên / email / quốc gia...">
            <select name="status" class="admin-status-select" onchange="this.form.submit()">
                <option value="">Tất cả trạng thái</option>
                <option value="active" @selected(request('status')==='active')>Đang hợp tác</option>
                <option value="paused" @selected(request('status')==='paused')>Tạm dừng</option>
                <option value="ended" @selected(request('status')==='ended')>Đã kết thúc</option>
            </select>
            <button type="submit" class="admin-btn admin-btn--primary" title="Tìm"><i class="fa-solid fa-magnifying-glass"></i></button>
            @if(request('q') || request('status'))
                <a href="{{ route('admin.suppliers.index') }}" class="admin-btn admin-btn--ghost" title="Xóa lọc"><i class="fa-solid fa-xmark"></i></a>
            @endif
        </form>
    </div>
    <table class="admin-table">
        <thead>
            <tr><th>Nhà phân phối</th><th>Liên hệ</th><th>Quốc gia</th><th>SKU</th><th>Hợp đồng đến</th><th>Trạng thái</th><th>Thao tác</th></tr>
        </thead>
        <tbody>
            @forelse($nhaPhanPhois as $npp)
            @php
                $attrs = 'openEditSupplier(' . $npp->id . ', '
                    . json_encode($npp->ten) . ', '
                    . json_encode($npp->mo_ta ?? '') . ', '
                    . json_encode($npp->email ?? '') . ', '
                    . json_encode($npp->sdt ?? '') . ', '
                    . json_encode($npp->quoc_gia ?? '') . ', '
                    . $npp->so_sku . ', '
                    . json_encode(optional($npp->hop_dong_den)->format('Y-m-d') ?? '') . ', '
                    . json_encode($npp->trang_thai) . ', '
                    . json_encode($npp->ghi_chu ?? '') . ')';
            @endphp
            <tr class="admin-table__row">
                <td>
                    <a href="#" class="admin-table__edit-link admin-table__product" data-bs-toggle="modal" data-bs-target="#supplierModal" onclick='{{ $attrs }}' title="Bấm để chỉnh sửa">
                        <div class="admin-supplier-logo admin-supplier-logo--{{ $npp->trang_thai }}"><i class="fa-solid {{ $npp->icon ?: 'fa-truck-ramp-box' }}"></i></div>
                        <div>
                            <div class="admin-table__name">{{ $npp->ten }}</div>
                            <div class="admin-table__muted">{{ $npp->mo_ta }}</div>
                        </div>
                    </a>
                </td>
                <td>{{ $npp->email }}<div class="admin-table__muted">{{ $npp->sdt }}</div></td>
                <td>@if($npp->coQuocGia()){{ $npp->coQuocGia() }} @endif{{ $npp->quoc_gia ?: '—' }}</td>
                <td><span class="admin-badge admin-badge--prep">{{ $npp->so_sku }} SKU</span></td>
                <td>{{ optional($npp->hop_dong_den)->format('d/m/Y') ?? '—' }}</td>
                <td><span class="admin-badge admin-badge--{{ $npp->badgeTrangThai() }}">{{ $npp->tenTrangThai() }}</span></td>
                <td>
                    <div class="d-flex gap-2">
                        <button class="admin-icon-btn" data-bs-toggle="modal" data-bs-target="#supplierModal" onclick='{{ $attrs }}' title="Sửa"><i class="fa-solid fa-pen"></i></button>
                        <form method="POST" action="{{ route('admin.suppliers.destroy', $npp->id) }}" onsubmit="return confirm('Xóa nhà phân phối {{ $npp->ten }}?')" class="d-inline">
                            @csrf @method('DELETE')
                            <button class="admin-icon-btn admin-icon-btn--danger" title="Xóa"><i class="fa-solid fa-trash-can"></i></button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr class="admin-table__row"><td colspan="7" class="admin-table__muted">Chưa có nhà phân phối</td></tr>
            @endforelse
        </tbody>
    </table>
    <div class="admin-pagination">{{ $nhaPhanPhois->links() }}</div>
</section>

{{-- #region MODAL THÊM/SỬA NHÀ PHÂN PHỐI --}}
<div class="modal fade" id="supplierModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content" style="background: var(--bg-panel); border: 1px solid rgba(255,255,255,.08); color: var(--text-main);">
            <div class="modal-header" style="border-bottom: 1px solid rgba(255,255,255,.06);">
                <h5 class="modal-title admin-panel__title" id="supplierModalLabel">Thêm nhà phân phối</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="supplierForm" method="POST" action="{{ route('admin.suppliers.store') }}">
                    @csrf
                    <input type="hidden" name="_method" id="supMethodField" value="">
                    <div class="row g-3">
                        <div class="col-md-8">
                            <div class="admin-field"><label class="admin-field__label">Tên nhà phân phối</label>
                                <input type="text" name="ten" id="supName" class="admin-field__input" placeholder="VD: Finalmouse Inc." required></div>
                        </div>
                        <div class="col-md-4">
                            <div class="admin-field"><label class="admin-field__label">Quốc gia</label>
                                <input type="text" name="quoc_gia" id="supCountry" class="admin-field__input" placeholder="VD: Mỹ"></div>
                        </div>
                        <div class="col-12">
                            <div class="admin-field"><label class="admin-field__label">Mô tả ngắn</label>
                                <input type="text" name="mo_ta" id="supDesc" class="admin-field__input" placeholder="VD: Chuột gaming cao cấp"></div>
                        </div>
                        <div class="col-md-7">
                            <div class="admin-field"><label class="admin-field__label">Email liên hệ</label>
                                <input type="email" name="email" id="supEmail" class="admin-field__input" placeholder="contact@supplier.com"></div>
                        </div>
                        <div class="col-md-5">
                            <div class="admin-field"><label class="admin-field__label">Số điện thoại</label>
                                <input type="text" name="sdt" id="supPhone" class="admin-field__input" placeholder="0800 xxx xxx"></div>
                        </div>
                        <div class="col-md-4">
                            <div class="admin-field"><label class="admin-field__label">Số SKU</label>
                                <input type="number" name="so_sku" id="supSku" class="admin-field__input" min="0" placeholder="0"></div>
                        </div>
                        <div class="col-md-4">
                            <div class="admin-field"><label class="admin-field__label">Hợp đồng đến</label>
                                <input type="date" name="hop_dong_den" id="supContract" class="admin-field__input"></div>
                        </div>
                        <div class="col-md-4">
                            <div class="admin-field"><label class="admin-field__label">Trạng thái</label>
                                <select name="trang_thai" id="supStatus" class="admin-field__select">
                                    <option value="active">Đang hợp tác</option>
                                    <option value="paused">Tạm dừng</option>
                                    <option value="ended">Đã kết thúc</option>
                                </select></div>
                        </div>
                        <div class="col-12">
                            <div class="admin-field"><label class="admin-field__label">Ghi chú</label>
                                <textarea name="ghi_chu" id="supNote" class="admin-field__textarea" rows="3" placeholder="Điều khoản, mặt hàng chuyên cung cấp..."></textarea></div>
                        </div>
                    </div>
                    @if ($errors->any())
                        <p class="txt-red small mt-2">{{ $errors->first() }}</p>
                    @endif
                </form>
            </div>
            <div class="modal-footer" style="border-top: 1px solid rgba(255,255,255,.06);">
                <button type="button" class="admin-btn admin-btn--ghost" data-bs-dismiss="modal">Hủy</button>
                <button type="submit" form="supplierForm" class="admin-btn admin-btn--primary"><i class="fa-solid fa-floppy-disk"></i> Lưu</button>
            </div>
        </div>
    </div>
</div>
{{-- #endregion --}}

<style>
.admin-supplier-logo {
    width: 42px; height: 42px;
    border-radius: 10px;
    background: rgba(0,255,255,.08);
    color: var(--cyber-cyan, #00ffff);
    display: grid; place-items: center;
    font-size: 18px;
    flex-shrink: 0;
}
.admin-supplier-logo--paused { background: rgba(255,183,3,.1); color: #ffb703; }
.admin-supplier-logo--ended  { background: rgba(255,0,60,.08); color: var(--red, #ff003c); }
</style>

@push('scripts')
<script>
    var supForm = document.getElementById('supplierForm');
    var supStoreUrl = @json(route('admin.suppliers.store'));
    var supBaseUrl = @json(url('/admin/nha-phan-phoi'));

    function openAddSupplier() {
        supForm.setAttribute('action', supStoreUrl);
        document.getElementById('supMethodField').value = '';
        document.getElementById('supplierModalLabel').textContent = 'Thêm nhà phân phối';
        ['supName','supCountry','supDesc','supEmail','supPhone','supContract','supNote'].forEach(id => document.getElementById(id).value = '');
        document.getElementById('supSku').value = '0';
        document.getElementById('supStatus').value = 'active';
    }

    function openEditSupplier(id, ten, moTa, email, sdt, quocGia, soSku, hopDong, trangThai, ghiChu) {
        supForm.setAttribute('action', supBaseUrl + '/' + id);
        document.getElementById('supMethodField').value = 'PUT';
        document.getElementById('supplierModalLabel').textContent = 'Sửa nhà phân phối';
        document.getElementById('supName').value = ten;
        document.getElementById('supDesc').value = moTa || '';
        document.getElementById('supEmail').value = email || '';
        document.getElementById('supPhone').value = sdt || '';
        document.getElementById('supCountry').value = quocGia || '';
        document.getElementById('supSku').value = soSku;
        document.getElementById('supContract').value = hopDong || '';
        document.getElementById('supStatus').value = trangThai;
        document.getElementById('supNote').value = ghiChu || '';
    }

    // Có lỗi validate -> mở lại modal để sửa
    @if ($errors->any())
        document.addEventListener('DOMContentLoaded', function () {
            new bootstrap.Modal(document.getElementById('supplierModal')).show();
        });
    @endif
</script>
@endpush
@endsection
