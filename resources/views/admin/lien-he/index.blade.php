@extends('layouts.admin')

@section('title', 'Liên hệ khách hàng - YUKI Admin')
@section('nav-contacts', 'is-active')

@php
    $badgeChuDe = ['ho-tro-ky-thuat' => 'prep', 'bao-hanh' => 'pending', 'don-hang' => 'done', 'hop-tac' => 'prep', 'khac' => 'pending'];
@endphp

@section('content')
<div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
    <div>
        <h1 class="admin-page-title">Liên hệ khách hàng</h1>
        <p class="admin-page-sub">{{ $thongKe['tong'] }} liên hệ · {{ $thongKe['chua_xu_ly'] }} chưa xử lý</p>
    </div>
</div>

{{-- STAT CARDS --}}
<div class="admin-stats" style="grid-template-columns:repeat(2,minmax(0,260px));margin:24px 0">
    <div class="admin-card">
        <div class="admin-stat__top">
            <div class="admin-stat__icon admin-stat__icon--cyan"><i class="fa-solid fa-envelope"></i></div>
        </div>
        <div class="admin-stat__value">{{ $thongKe['tong'] }}</div>
        <div class="admin-stat__label">Tổng liên hệ</div>
    </div>
    <div class="admin-card">
        <div class="admin-stat__top">
            <div class="admin-stat__icon admin-stat__icon--amber"><i class="fa-solid fa-clock"></i></div>
        </div>
        <div class="admin-stat__value">{{ $thongKe['chua_xu_ly'] }}</div>
        <div class="admin-stat__label">Chưa xử lý</div>
    </div>
</div>

{{-- TABLE --}}
<section class="admin-table-wrap">
    <div class="admin-table-wrap__head">
        <h3 class="admin-panel__title">Danh sách liên hệ</h3>
        <form method="GET" action="{{ route('admin.contacts.index') }}" class="d-flex gap-2 flex-wrap align-items-center">
            <input name="q" value="{{ request('q') }}" class="admin-status-select" placeholder="Tìm tên / email / nội dung...">
            <select name="status" class="admin-status-select" onchange="this.form.submit()">
                <option value="">Tất cả</option>
                <option value="chua" @selected(request('status')==='chua')>Chưa xử lý</option>
                <option value="roi" @selected(request('status')==='roi')>Đã xử lý</option>
            </select>
            <button type="submit" class="admin-btn admin-btn--primary" title="Tìm"><i class="fa-solid fa-magnifying-glass"></i></button>
            @if(request('q') || request('status'))
                <a href="{{ route('admin.contacts.index') }}" class="admin-btn admin-btn--ghost" title="Xóa lọc"><i class="fa-solid fa-xmark"></i></a>
            @endif
        </form>
    </div>
    <table class="admin-table">
        <thead>
            <tr><th>Người gửi</th><th>SĐT</th><th>Chủ đề</th><th>Nội dung</th><th>Thời gian</th><th>Trạng thái</th><th>Thao tác</th></tr>
        </thead>
        <tbody>
            @forelse($lienHes as $lh)
            @php
                $attrs = 'xemLienHe('
                    . json_encode($lh->ho_ten) . ', '
                    . json_encode($lh->email) . ', '
                    . json_encode($lh->so_dien_thoai ?? '—') . ', '
                    . json_encode($lh->tenChuDe()) . ', '
                    . json_encode($lh->noi_dung) . ', '
                    . json_encode($lh->created_at->format('d/m/Y H:i')) . ')';
            @endphp
            <tr class="admin-table__row">
                <td>
                    <a href="#" class="admin-table__edit-link" data-bs-toggle="modal" data-bs-target="#contactModal" onclick='{{ $attrs }}' title="Xem chi tiết">
                        <div class="admin-table__name">{{ $lh->ho_ten }}</div>
                        <div class="admin-table__muted">{{ $lh->email }}</div>
                    </a>
                </td>
                <td>{{ $lh->so_dien_thoai ?: '—' }}</td>
                <td><span class="admin-badge admin-badge--{{ $badgeChuDe[$lh->chu_de] ?? 'prep' }}">{{ $lh->tenChuDe() }}</span></td>
                <td><span class="admin-table__muted" style="display:inline-block;max-width:280px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;vertical-align:bottom">{{ $lh->noi_dung }}</span></td>
                <td class="admin-table__muted">{{ $lh->created_at->format('d/m/Y H:i') }}</td>
                <td>
                    <form method="POST" action="{{ route('admin.contacts.toggle', $lh->id) }}" class="d-inline">
                        @csrf @method('PATCH')
                        <button class="admin-badge admin-badge--{{ $lh->da_xu_ly ? 'done' : 'pending' }}" style="cursor:pointer;border:0" title="Bấm để đổi trạng thái">
                            <i class="fa-solid fa-{{ $lh->da_xu_ly ? 'circle-check' : 'hourglass-half' }} me-1"></i>{{ $lh->da_xu_ly ? 'Đã xử lý' : 'Chưa xử lý' }}
                        </button>
                    </form>
                </td>
                <td>
                    <div class="d-flex gap-2">
                        <button class="admin-icon-btn" data-bs-toggle="modal" data-bs-target="#contactModal" onclick='{{ $attrs }}' title="Xem"><i class="fa-solid fa-eye"></i></button>
                        <form method="POST" action="{{ route('admin.contacts.destroy', $lh->id) }}" onsubmit="return confirm('Xóa liên hệ của {{ $lh->ho_ten }}?')" class="d-inline">
                            @csrf @method('DELETE')
                            <button class="admin-icon-btn admin-icon-btn--danger" title="Xóa"><i class="fa-solid fa-trash-can"></i></button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr class="admin-table__row"><td colspan="7" class="admin-table__muted">Chưa có liên hệ nào</td></tr>
            @endforelse
        </tbody>
    </table>
    <div class="admin-pagination">{{ $lienHes->links() }}</div>
</section>

{{-- MODAL XEM CHI TIẾT --}}
<div class="modal fade" id="contactModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="background: var(--bg-panel); border: 1px solid rgba(255,255,255,.08); color: var(--text-main);">
            <div class="modal-header" style="border-bottom: 1px solid rgba(255,255,255,.06);">
                <h5 class="modal-title admin-panel__title">Chi tiết liên hệ</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="admin-field"><label class="admin-field__label">Họ tên</label><div id="ct-name" class="admin-field__static"></div></div>
                <div class="admin-field"><label class="admin-field__label">Email</label><div id="ct-email" class="admin-field__static"></div></div>
                <div class="admin-field"><label class="admin-field__label">Số điện thoại</label><div id="ct-phone" class="admin-field__static"></div></div>
                <div class="admin-field"><label class="admin-field__label">Chủ đề</label><div id="ct-topic" class="admin-field__static"></div></div>
                <div class="admin-field"><label class="admin-field__label">Thời gian gửi</label><div id="ct-time" class="admin-field__static"></div></div>
                <div class="admin-field"><label class="admin-field__label">Nội dung</label><div id="ct-body" class="admin-field__static" style="white-space:pre-wrap;line-height:1.6"></div></div>
            </div>
            <div class="modal-footer" style="border-top: 1px solid rgba(255,255,255,.06);">
                <a id="ct-reply" href="#" class="admin-btn admin-btn--primary"><i class="fa-solid fa-reply"></i> Trả lời qua email</a>
                <button type="button" class="admin-btn admin-btn--ghost" data-bs-dismiss="modal">Đóng</button>
            </div>
        </div>
    </div>
</div>

<style>
.admin-field__static { color: var(--text-main); font-size: .95rem; padding: 2px 0; }
</style>

@push('scripts')
<script>
    function xemLienHe(ten, email, sdt, chuDe, noiDung, thoiGian) {
        document.getElementById('ct-name').textContent = ten;
        document.getElementById('ct-email').textContent = email;
        document.getElementById('ct-phone').textContent = sdt;
        document.getElementById('ct-topic').textContent = chuDe;
        document.getElementById('ct-time').textContent = thoiGian;
        document.getElementById('ct-body').textContent = noiDung;
        document.getElementById('ct-reply').href = 'mailto:' + email + '?subject=' + encodeURIComponent('[YUKI] Phản hồi: ' + chuDe);
    }
</script>
@endpush
@endsection
