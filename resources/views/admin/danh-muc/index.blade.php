@extends('layouts.admin')

@section('title', 'Quản lý danh mục - YUKI Admin')
@section('nav-categories', 'is-active')

@section('content')
<div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
    <div>
        <h1 class="admin-page-title">Quản lý danh mục</h1>
        <p class="admin-page-sub">{{ $tongDanhMuc }} danh mục · {{ $tongSanPham }} sản phẩm</p>
    </div>
    <button class="admin-btn admin-btn--primary" data-bs-toggle="modal" data-bs-target="#categoryModal" onclick="openAddModal()">
        <i class="fa-solid fa-plus"></i> Thêm danh mục
    </button>
</div>

@if (session('success'))
    <div class="alert alert-success py-2 small my-3"><i class="fa-solid fa-circle-check me-1"></i>{{ session('success') }}</div>
@endif
@if (session('error'))
    <div class="alert alert-danger py-2 small my-3"><i class="fa-solid fa-circle-exclamation me-1"></i>{{ session('error') }}</div>
@endif

<section class="admin-table-wrap">
    <div class="admin-table-wrap__head">
        <h3 class="admin-panel__title">Danh sách danh mục</h3>
    </div>
    <table class="admin-table">
        <thead>
            <tr><th>Danh mục</th><th>Số sản phẩm</th><th>Slug</th><th>Trạng thái</th><th>Thao tác</th></tr>
        </thead>
        <tbody>
            @forelse($danhMucs as $dm)
            @php
                $attrs = "openEditModal({$dm->id}, " . json_encode($dm->ten) . ', ' . json_encode($dm->slug) . ', ' . json_encode($dm->icon ?? '') . ', ' . json_encode($dm->mo_ta ?? '') . ", {$dm->is_active})";
            @endphp
            <tr class="admin-table__row">
                <td>
                    <a href="#" class="admin-table__edit-link" data-bs-toggle="modal" data-bs-target="#categoryModal" onclick='{{ $attrs }}'>
                        <div class="admin-cat__icon"><i class="fa-solid {{ $dm->icon ?: 'fa-layer-group' }}"></i></div>
                        <div class="admin-table__name">{{ $dm->ten }}</div>
                    </a>
                </td>
                <td>{{ $dm->san_phams_count }}</td>
                <td><code class="admin-slug">{{ $dm->slug }}</code></td>
                <td>
                    <form method="POST" action="{{ route('admin.categories.toggle', $dm->id) }}" class="d-inline">
                        @csrf @method('PATCH')
                        <button type="submit" class="admin-badge admin-badge--{{ $dm->is_active ? 'done' : 'cancel' }} admin-badge--toggle"
                                title="Bấm để {{ $dm->is_active ? 'ẩn danh mục' : 'hiển thị danh mục' }}">
                            <i class="fa-solid {{ $dm->is_active ? 'fa-eye' : 'fa-eye-slash' }}"></i> {{ $dm->is_active ? 'Hoạt động' : 'Đã ẩn' }}
                        </button>
                    </form>
                </td>
                <td>
                    <div class="d-flex gap-2">
                        <button class="admin-icon-btn" data-bs-toggle="modal" data-bs-target="#categoryModal" onclick='{{ $attrs }}'>
                            <i class="fa-solid fa-pen"></i>
                        </button>
                        <form method="POST" action="{{ route('admin.categories.destroy', $dm->id) }}" onsubmit="return confirm('Xóa danh mục này?')" class="d-inline">
                            @csrf @method('DELETE')
                            <button class="admin-icon-btn admin-icon-btn--danger"><i class="fa-solid fa-trash-can"></i></button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr class="admin-table__row"><td colspan="5" class="admin-table__muted">Chưa có danh mục</td></tr>
            @endforelse
        </tbody>
    </table>
    <div class="admin-pagination">{{ $danhMucs->links() }}</div>
</section>

{{-- #region MODAL THÊM/SỬA DANH MỤC --}}
<div class="modal fade" id="categoryModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="background: var(--bg-panel); border: 1px solid rgba(255,255,255,.08); color: var(--text-main);">
            <div class="modal-header" style="border-bottom: 1px solid rgba(255,255,255,.06);">
                <h5 class="modal-title admin-panel__title" id="categoryModalLabel">Thêm danh mục</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="categoryForm" method="POST" action="{{ route('admin.categories.store') }}">
                    @csrf
                    <input type="hidden" name="_method" id="catMethodField" value="">
                    <div class="admin-field">
                        <label class="admin-field__label">Tên danh mục</label>
                        <input type="text" name="ten" class="admin-field__input" id="catName" placeholder="VD: Tai nghe" required>
                    </div>
                    <div class="admin-field">
                        <label class="admin-field__label">Slug <span class="admin-field__hint">(để trống = tự tạo)</span></label>
                        <input type="text" name="slug" class="admin-field__input" id="catSlug" placeholder="VD: tai-nghe">
                    </div>
                    <div class="admin-field">
                        <label class="admin-field__label">Icon (Font Awesome class)</label>
                        <input type="text" name="icon" class="admin-field__input" id="catIcon" placeholder="VD: fa-headphones">
                    </div>
                    <div class="admin-field">
                        <label class="admin-field__label">Mô tả</label>
                        <textarea name="mo_ta" class="admin-field__textarea" id="catDesc" placeholder="Mô tả ngắn về danh mục..."></textarea>
                    </div>
                    <div class="admin-field">
                        <label class="admin-field__label">Trạng thái</label>
                        <select name="is_active" class="admin-field__select" id="catStatus">
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
                        </select>
                    </div>
                    @if ($errors->any())
                        <p class="txt-red small">{{ $errors->first() }}</p>
                    @endif
                </form>
            </div>
            <div class="modal-footer" style="border-top: 1px solid rgba(255,255,255,.06);">
                <button type="button" class="admin-btn admin-btn--ghost" data-bs-dismiss="modal">Hủy</button>
                <button type="submit" form="categoryForm" class="admin-btn admin-btn--primary"><i class="fa-solid fa-floppy-disk"></i> Lưu</button>
            </div>
        </div>
    </div>
</div>
{{-- #endregion --}}

@push('scripts')
<script>
    var catForm = document.getElementById('categoryForm');
    var catStoreUrl = @json(route('admin.categories.store'));
    var catBaseUrl = @json(url('/admin/danh-muc'));

    function openAddModal() {
        catForm.setAttribute('action', catStoreUrl);
        document.getElementById('catMethodField').value = '';
        document.getElementById('categoryModalLabel').textContent = 'Thêm danh mục';
        document.getElementById('catName').value = '';
        document.getElementById('catSlug').value = '';
        document.getElementById('catIcon').value = '';
        document.getElementById('catDesc').value = '';
        document.getElementById('catStatus').value = '1';
    }

    function openEditModal(id, ten, slug, icon, moTa, active) {
        catForm.setAttribute('action', catBaseUrl + '/' + id);
        document.getElementById('catMethodField').value = 'PUT';
        document.getElementById('categoryModalLabel').textContent = 'Sửa danh mục';
        document.getElementById('catName').value = ten;
        document.getElementById('catSlug').value = slug;
        document.getElementById('catIcon').value = icon || '';
        document.getElementById('catDesc').value = moTa || '';
        document.getElementById('catStatus').value = active ? '1' : '0';
    }

    // Nếu có lỗi validate (modal đóng sau reload) -> mở lại modal để sửa
    @if ($errors->any())
        document.addEventListener('DOMContentLoaded', function () {
            var m = new bootstrap.Modal(document.getElementById('categoryModal'));
            m.show();
        });
    @endif
</script>
@endpush
@endsection
