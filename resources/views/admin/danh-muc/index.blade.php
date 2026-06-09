@extends('layouts.admin')

@section('title', 'Quản lý danh mục - YUKI Admin')
@section('nav-categories', 'is-active')

@section('content')
<h1 class="admin-page-title">Quản lý danh mục</h1>
<p class="admin-page-sub">Thêm, sửa, xóa danh mục sản phẩm</p>

@if (session('success'))
    <div class="alert alert-success py-2 small mb-3"><i class="fa-solid fa-circle-check me-1"></i>{{ session('success') }}</div>
@endif
@if (session('error'))
    <div class="alert alert-danger py-2 small mb-3"><i class="fa-solid fa-circle-exclamation me-1"></i>{{ session('error') }}</div>
@endif

<div class="admin-grid-2">
    <section class="admin-table-wrap">
        <div class="admin-table-wrap__head"><h3 class="admin-panel__title">Danh sách danh mục</h3></div>
        <table class="admin-table">
            <thead><tr><th>#</th><th>Tên</th><th>Slug</th><th>Số SP</th><th>Trạng thái</th><th></th></tr></thead>
            <tbody>
                @forelse($danhMucs as $dm)
                <tr class="admin-table__row">
                    <td>{{ $dm->thu_tu }}</td>
                    <td><strong>{{ $dm->ten }}</strong></td>
                    <td class="admin-table__muted">{{ $dm->slug }}</td>
                    <td>{{ $dm->san_phams_count }}</td>
                    <td><span class="admin-badge admin-badge--{{ $dm->is_active ? 'done' : 'cancel' }}">{{ $dm->is_active ? 'Hiện' : 'Ẩn' }}</span></td>
                    <td style="white-space:nowrap">
                        <button type="button" class="admin-icon-btn js-edit-cat"
                            data-id="{{ $dm->id }}" data-ten="{{ $dm->ten }}" data-slug="{{ $dm->slug }}"
                            data-hinhanh="{{ $dm->hinh_anh }}" data-thutu="{{ $dm->thu_tu }}" data-active="{{ $dm->is_active ? 1 : 0 }}">
                            <i class="fa-solid fa-pen"></i>
                        </button>
                        <form method="POST" action="{{ route('admin.categories.destroy', $dm->id) }}" onsubmit="return confirm('Xóa danh mục này?')" class="d-inline">
                            @csrf @method('DELETE')
                            <button class="admin-icon-btn admin-icon-btn--danger"><i class="fa-solid fa-trash-can"></i></button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr class="admin-table__row"><td colspan="6" class="admin-table__muted">Chưa có danh mục</td></tr>
                @endforelse
            </tbody>
        </table>
        <div class="admin-pagination">{{ $danhMucs->links() }}</div>
    </section>

    <section class="admin-panel">
        <h3 class="admin-panel__title mb-3" id="catFormTitle">Thêm danh mục</h3>
        <form method="POST" action="{{ route('admin.categories.store') }}" id="catForm">
            @csrf
            <input type="hidden" name="_method" id="catMethod" value="">
            <div class="admin-field">
                <label class="admin-field__label">Tên danh mục</label>
                <input type="text" name="ten" id="catTen" class="admin-field__input" value="{{ old('ten') }}" required>
                @error('ten')<p class="txt-red small">{{ $message }}</p>@enderror
            </div>
            <div class="admin-field">
                <label class="admin-field__label">Slug <span class="admin-field__hint">(để trống = tự tạo từ tên)</span></label>
                <input type="text" name="slug" id="catSlug" class="admin-field__input" value="{{ old('slug') }}" placeholder="vd: ban-phim-co">
                @error('slug')<p class="txt-red small">{{ $message }}</p>@enderror
            </div>
            <div class="admin-field">
                <label class="admin-field__label">Hình ảnh (đường dẫn)</label>
                <input type="text" name="hinh_anh" id="catHinhAnh" class="admin-field__input" value="{{ old('hinh_anh') }}" placeholder="assets/images/...">
            </div>
            <div class="admin-field__row">
                <div class="admin-field">
                    <label class="admin-field__label">Thứ tự</label>
                    <input type="number" name="thu_tu" id="catThuTu" class="admin-field__input" value="{{ old('thu_tu', 0) }}" min="0">
                </div>
                <div class="admin-field">
                    <label class="admin-field__label">Hiển thị</label>
                    <select name="is_active" id="catActive" class="admin-field__select">
                        <option value="1">Hiện</option>
                        <option value="0">Ẩn</option>
                    </select>
                </div>
            </div>
            <div class="admin-form__actions">
                <button type="submit" class="admin-btn admin-btn--primary" id="catSubmit"><i class="fa-solid fa-plus"></i> Thêm danh mục</button>
                <button type="button" class="admin-btn" id="catCancel" style="display:none"><i class="fa-solid fa-xmark"></i> Hủy sửa</button>
            </div>
        </form>
    </section>
</div>

@push('scripts')
<script>
(function () {
    var form = document.getElementById('catForm');
    var storeUrl = @json(route('admin.categories.store'));
    var baseUrl = @json(url('/admin/danh-muc'));

    function toAddMode() {
        form.setAttribute('action', storeUrl);
        document.getElementById('catMethod').value = '';
        document.getElementById('catFormTitle').textContent = 'Thêm danh mục';
        document.getElementById('catSubmit').innerHTML = '<i class="fa-solid fa-plus"></i> Thêm danh mục';
        document.getElementById('catCancel').style.display = 'none';
        form.reset();
        document.getElementById('catThuTu').value = 0;
    }

    document.querySelectorAll('.js-edit-cat').forEach(function (btn) {
        btn.addEventListener('click', function () {
            form.setAttribute('action', baseUrl + '/' + btn.dataset.id);
            document.getElementById('catMethod').value = 'PUT';
            document.getElementById('catTen').value = btn.dataset.ten;
            document.getElementById('catSlug').value = btn.dataset.slug;
            document.getElementById('catHinhAnh').value = btn.dataset.hinhanh || '';
            document.getElementById('catThuTu').value = btn.dataset.thutu || 0;
            document.getElementById('catActive').value = btn.dataset.active;
            document.getElementById('catFormTitle').textContent = 'Cập nhật danh mục';
            document.getElementById('catSubmit').innerHTML = '<i class="fa-solid fa-floppy-disk"></i> Lưu thay đổi';
            document.getElementById('catCancel').style.display = '';
            form.scrollIntoView({ behavior: 'smooth', block: 'center' });
        });
    });

    document.getElementById('catCancel').addEventListener('click', toAddMode);
})();
</script>
@endpush
@endsection
