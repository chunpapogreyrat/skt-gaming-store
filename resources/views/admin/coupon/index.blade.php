@extends('layouts.admin')

@section('title', 'Quản lý mã giảm giá - YUKI Admin')
@section('nav-coupons', 'is-active')

@section('content')
<h1 class="admin-page-title">Quản lý mã giảm giá</h1>
<p class="admin-page-sub">Tạo và theo dõi chương trình khuyến mãi</p>

<div id="couponToast" class="alert d-none py-2 small my-3"></div>

<div class="admin-grid-2">
    <section class="admin-table-wrap">
        <div class="admin-table-wrap__head"><h3 class="admin-panel__title">Mã đang hoạt động</h3></div>
        <div id="couponList">
            @include('admin.coupon._table')
        </div>
    </section>

    <section class="admin-panel">
        <h3 class="admin-panel__title mb-3">Tạo mã mới</h3>
        <form id="couponCreateForm">
            @csrf
            <div class="admin-field">
                <label class="admin-field__label">Mã code</label>
                <input type="text" name="ma_code" class="admin-field__input" style="text-transform:uppercase" placeholder="VD: YUKISALE" required>
            </div>
            <div class="admin-field">
                <label class="admin-field__label">Loại giảm</label>
                <select name="loai" class="admin-field__select">
                    <option value="phan_tram">Phần trăm (%)</option>
                    <option value="so_tien">Số tiền (đ)</option>
                </select>
            </div>
            <div class="admin-field">
                <label class="admin-field__label">Giá trị</label>
                <input type="number" name="gia_tri" class="admin-field__input" placeholder="10" required>
            </div>
            <div class="admin-field">
                <label class="admin-field__label">Đơn tối thiểu (đ)</label>
                <input type="number" name="gia_tri_don_toi_thieu" class="admin-field__input" value="0">
            </div>
            <div class="admin-field__row">
                <div class="admin-field">
                    <label class="admin-field__label">Số lượt tối đa</label>
                    <input type="number" name="so_lan_su_dung_toi_da" class="admin-field__input" placeholder="Trống = ∞">
                </div>
                <div class="admin-field">
                    <label class="admin-field__label">Ngày hết hạn</label>
                    <input type="date" name="ngay_het_han" class="admin-field__input">
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

{{-- #region MODAL SỬA — dùng admin-modal khớp thiết kế --}}
<div class="modal fade" id="couponModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content admin-modal">
            <div class="modal-header admin-modal__header">
                <h5 class="modal-title admin-modal__title"><i class="fa-solid fa-ticket me-2" style="color:var(--red)"></i>Chỉnh sửa mã — <span id="edit_title"></span></h5>
                <button type="button" class="admin-modal__close" data-bs-dismiss="modal"><i class="fa-solid fa-xmark"></i></button>
            </div>
            <div class="modal-body p-4">
                <form id="couponEditForm">
                    @csrf
                    <input type="hidden" name="_method" value="PUT">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="admin-field">
                                <label class="admin-field__label">Mã code</label>
                                <input type="text" name="ma_code" id="edit_ma_code" class="admin-field__input" style="text-transform:uppercase" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="admin-field">
                                <label class="admin-field__label">Loại giảm</label>
                                <select name="loai" id="edit_loai" class="admin-field__select">
                                    <option value="phan_tram">Phần trăm (%)</option>
                                    <option value="so_tien">Số tiền (đ)</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="admin-field">
                                <label class="admin-field__label">Giá trị</label>
                                <input type="number" name="gia_tri" id="edit_gia_tri" class="admin-field__input" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="admin-field">
                                <label class="admin-field__label">Đơn tối thiểu (đ)</label>
                                <input type="number" name="gia_tri_don_toi_thieu" id="edit_don_toi_thieu" class="admin-field__input">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="admin-field">
                                <label class="admin-field__label">Số lượt tối đa</label>
                                <input type="number" name="so_lan_su_dung_toi_da" id="edit_so_lan" class="admin-field__input" placeholder="Trống = ∞">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="admin-field">
                                <label class="admin-field__label">Trạng thái</label>
                                <select name="trang_thai" id="edit_trang_thai" class="admin-field__select">
                                    <option value="1">Hoạt động</option>
                                    <option value="0">Ngừng</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="admin-field">
                                <label class="admin-field__label">Ngày bắt đầu</label>
                                <input type="date" name="ngay_bat_dau" id="edit_ngay_bat_dau" class="admin-field__input">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="admin-field">
                                <label class="admin-field__label">Ngày hết hạn</label>
                                <input type="date" name="ngay_het_han" id="edit_ngay_het_han" class="admin-field__input">
                            </div>
                        </div>
                    </div>
                    <p class="txt-red small mt-2 mb-0 d-none" id="edit_error"></p>
                </form>
            </div>
            <div class="modal-footer admin-modal__footer" style="border-top:1px solid rgba(255,255,255,.06)">
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
(function () {
    var indexUrl = @json(route('admin.coupons.index'));
    var storeUrl = @json(route('admin.coupons.store'));
    var baseUrl  = @json(url('/admin/ma-giam-gia'));
    var token    = document.querySelector('#couponCreateForm input[name="_token"]').value;
    var listEl   = document.getElementById('couponList');
    var toastEl  = document.getElementById('couponToast');
    var modalEl  = document.getElementById('couponModal');
    var bsModal  = new bootstrap.Modal(modalEl);

    function toast(msg, ok) {
        toastEl.className = 'alert py-2 small my-3 ' + (ok ? 'alert-success' : 'alert-danger');
        toastEl.textContent = msg;
        setTimeout(function () { toastEl.classList.add('d-none'); }, 3500);
    }

    function send(url, formData) {
        return fetch(url, {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': token, 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' },
            body: formData,
        }).then(function (r) { return r.json().then(function (d) { return { ok: r.ok, status: r.status, d: d }; }); });
    }

    function reloadTable(url) {
        fetch(url || indexUrl, { headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' } })
            .then(function (r) { return r.json(); })
            .then(function (res) { if (res.html) listEl.innerHTML = res.html; });
    }

    // Mở modal sửa (gọi từ onclick trong bảng)
    window.openEditModal = function (id, code, loai, giaTri, donToiThieu, soLan, ngayBatDau, ngayHetHan, active) {
        var f = document.getElementById('couponEditForm');
        f.setAttribute('data-url', baseUrl + '/' + id);
        document.getElementById('edit_title').textContent = code || '';
        document.getElementById('edit_ma_code').value = code || '';
        document.getElementById('edit_loai').value = loai || 'phan_tram';
        document.getElementById('edit_gia_tri').value = giaTri ?? '';
        document.getElementById('edit_don_toi_thieu').value = donToiThieu ?? 0;
        document.getElementById('edit_so_lan').value = soLan ?? '';
        document.getElementById('edit_ngay_bat_dau').value = ngayBatDau || '';
        document.getElementById('edit_ngay_het_han').value = ngayHetHan || '';
        document.getElementById('edit_trang_thai').value = active ? '1' : '0';
        document.getElementById('edit_error').classList.add('d-none');
        bsModal.show();
    };

    // Tạo mã (AJAX)
    document.getElementById('couponCreateForm').addEventListener('submit', function (e) {
        e.preventDefault();
        var form = this;
        send(storeUrl, new FormData(form)).then(function (res) {
            if (res.ok && res.d.success) {
                form.reset();
                reloadTable();
                toast(res.d.message || 'Đã tạo mã', true);
            } else {
                toast(firstError(res.d) || 'Tạo mã thất bại', false);
            }
        }).catch(function () { toast('Lỗi mạng', false); });
    });

    // Sửa mã (AJAX)
    document.getElementById('couponEditForm').addEventListener('submit', function (e) {
        e.preventDefault();
        var form = this;
        send(form.getAttribute('data-url'), new FormData(form)).then(function (res) {
            if (res.ok && res.d.success) {
                bsModal.hide();
                reloadTable();
                toast(res.d.message || 'Đã cập nhật', true);
            } else {
                var err = document.getElementById('edit_error');
                err.textContent = firstError(res.d) || 'Cập nhật thất bại';
                err.classList.remove('d-none');
            }
        }).catch(function () { toast('Lỗi mạng', false); });
    });

    // Xóa + chuyển trang (event delegation trên container — vẫn chạy sau khi reload AJAX)
    listEl.addEventListener('click', function (e) {
        var del = e.target.closest('[data-delete-coupon]');
        if (del) {
            var code = del.getAttribute('data-code');
            if (!confirm('Xóa mã ' + code + '?')) return;
            var fd = new FormData(); fd.append('_method', 'DELETE'); fd.append('_token', token);
            send(baseUrl + '/' + del.getAttribute('data-delete-coupon'), fd).then(function (res) {
                if (res.ok && res.d.success) { reloadTable(); toast(res.d.message || 'Đã xóa', true); }
                else { toast('Xóa thất bại', false); }
            });
            return;
        }
        var page = e.target.closest('.admin-pagination a');
        if (page) {
            e.preventDefault();
            reloadTable(page.getAttribute('href'));
        }
    });

    function firstError(d) {
        if (d && d.errors) { for (var k in d.errors) return d.errors[k][0]; }
        return d && d.message;
    }
})();
</script>
@endpush
