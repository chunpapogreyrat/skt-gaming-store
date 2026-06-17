@extends('layouts.admin')

@section('title', ($sanPham->exists ? 'Sửa' : 'Thêm') . ' sản phẩm - YUKI Admin')
@section('nav-products', 'is-active')

@section('content')
<h1 class="admin-page-title">{{ $sanPham->exists ? 'Sửa' : 'Thêm' }} sản phẩm</h1>
<p class="admin-page-sub"><a href="{{ route('admin.products.index') }}" class="admin-table__muted">Sản phẩm</a> / {{ $sanPham->exists ? $sanPham->ten : 'Thêm mới' }}</p>

<form method="POST" action="{{ $sanPham->exists ? route('admin.products.update', $sanPham->id) : route('admin.products.store') }}" enctype="multipart/form-data" class="admin-form-grid">
    @csrf
    @if($sanPham->exists) @method('PUT') @endif

    <div>
        <div class="admin-panel mb-3">
            <h3 class="admin-panel__title mb-3">Thông tin cơ bản</h3>
            <div class="admin-field">
                <label class="admin-field__label">Tên sản phẩm</label>
                <input type="text" name="ten" class="admin-field__input" value="{{ old('ten', $sanPham->ten) }}" required>
                @error('ten')<p class="txt-red small">{{ $message }}</p>@enderror
            </div>
            <div class="admin-field__row">
                <div class="admin-field">
                    <label class="admin-field__label">Slug (tự sinh nếu trống)</label>
                    <input type="text" name="slug" class="admin-field__input" value="{{ old('slug', $sanPham->slug) }}">
                </div>
                <div class="admin-field">
                    <label class="admin-field__label">Thương hiệu</label>
                    <select name="thuong_hieu_id" class="admin-field__select">
                        <option value="">— Không —</option>
                        @foreach($thuongHieus as $th)
                        <option value="{{ $th->id }}" @selected(old('thuong_hieu_id', $sanPham->thuong_hieu_id)==$th->id)>{{ $th->ten }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="admin-field">
                <label class="admin-field__label">Mô tả ngắn</label>
                <textarea name="mo_ta_ngan" class="admin-field__textarea">{{ old('mo_ta_ngan', $sanPham->mo_ta_ngan) }}</textarea>
            </div>
            <div class="admin-field">
                <label class="admin-field__label">Mô tả chi tiết</label>
                <textarea name="mo_ta_day_du" class="admin-field__textarea" rows="6">{{ old('mo_ta_day_du', $sanPham->mo_ta_day_du) }}</textarea>
            </div>
        </div>

        <div class="admin-panel mb-3">
            <h3 class="admin-panel__title mb-3">Hình ảnh sản phẩm</h3>
            @if($sanPham->exists && $sanPham->hinhAnh->count())
                <div class="d-flex flex-wrap gap-2 mb-2">
                    @foreach($sanPham->hinhAnh as $img)
                    <label style="position:relative;width:84px;height:84px;border-radius:8px;overflow:hidden;border:1px solid rgba(255,255,255,.12);cursor:pointer;display:block;background:#fff">
                        <img src="{{ asset($img->duong_dan) }}" alt="" style="width:100%;height:100%;object-fit:contain">
                        @if($img->is_main)<span style="position:absolute;top:2px;left:2px;background:var(--red);color:#fff;font-size:9px;padding:1px 5px;border-radius:3px">Chính</span>@endif
                        <span style="position:absolute;top:2px;right:2px;background:rgba(0,0,0,.65);padding:2px 4px;border-radius:3px">
                            <input type="checkbox" name="xoa_anh[]" value="{{ $img->id }}" title="Xóa ảnh này">
                        </span>
                    </label>
                    @endforeach
                </div>
                <p class="admin-table__muted small mb-3">Tick ô góc phải mỗi ảnh để xóa khi lưu.</p>
            @endif
            <div class="admin-field">
                <label class="admin-field__label">Thêm ảnh sản phẩm (cho slider chi tiết)</label>
                <div id="imgDropzone" class="img-dropzone">
                    <i class="fa-solid fa-cloud-arrow-up"></i>
                    <p><strong>Kéo &amp; thả ảnh vào đây</strong><br><span>hoặc bấm để chọn — có thể thêm nhiều ảnh</span></p>
                    <input type="file" name="hinh_anh[]" id="imgInput" multiple accept="image/*" hidden>
                </div>
                <div id="imgPreview" class="img-preview"></div>
                @error('hinh_anh.*')<p class="txt-red small">{{ $message }}</p>@enderror
            </div>
        </div>
    </div>

    <div>
        <div class="admin-panel mb-3">
            <h3 class="admin-panel__title mb-3">Giá & Kho</h3>
            <div class="admin-field">
                <label class="admin-field__label">Giá bán (đ)</label>
                <input type="number" name="gia_ban" class="admin-field__input" value="{{ old('gia_ban', $sanPham->gia_ban) }}" required>
                @error('gia_ban')<p class="txt-red small">{{ $message }}</p>@enderror
            </div>
            <div class="admin-field">
                <label class="admin-field__label">Giá gốc — gạch ngang (đ)</label>
                <input type="number" name="gia_goc" class="admin-field__input" value="{{ old('gia_goc', $sanPham->gia_goc) }}">
            </div>
            <div class="admin-field">
                <label class="admin-field__label">Số lượng tồn</label>
                <input type="number" name="so_luong_ton" class="admin-field__input" value="{{ old('so_luong_ton', $sanPham->so_luong_ton ?? 0) }}" required>
            </div>
        </div>

        @php
            // Danh sách biến thể: ưu tiên dữ liệu cũ (khi validate lỗi), nếu không lấy từ DB
            $bienTheList = old('bien_the');
            if ($bienTheList === null) {
                $bienTheList = $sanPham->exists
                    ? $sanPham->bienTheTatCa->map(fn ($b) => [
                        'id' => $b->id,
                        'ten' => $b->ten_bien_the,
                        'hex' => $b->ma_hex,
                        'hinh_anh_id' => $b->hinh_anh_id,
                        'gia_chenh_lech' => (int) $b->gia_chenh_lech,
                        'so_luong_ton' => $b->so_luong_ton,
                        'is_active' => $b->is_active,
                    ])->toArray()
                    : [];
            }
            // Ảnh sản phẩm để gắn cho từng màu (chọn màu sẽ đổi sang ảnh này ở trang khách)
            $anhOptions = $sanPham->exists
                ? $sanPham->hinhAnh->values()->map(fn ($img, $i) => ['id' => $img->id, 'label' => 'Ảnh ' . ($i + 1)])
                : collect();
        @endphp
        <div class="admin-panel mb-3">
            <h3 class="admin-panel__title mb-2">Biến thể màu sắc</h3>
            <p class="admin-table__muted small mb-3">Dùng cho sản phẩm nhiều màu (chuột, lót chuột…). Khách sẽ chọn màu khi đặt hàng. Để trống nếu sản phẩm chỉ có một màu.</p>

            <div class="variant-list__head">
                <span style="flex:0 0 38px">Màu</span>
                <span style="flex:1">Tên màu</span>
                <span style="flex:0 0 90px">Ảnh</span>
                <span style="flex:0 0 90px">Chênh giá</span>
                <span style="flex:0 0 64px">Tồn</span>
                <span style="flex:0 0 44px">Hiện</span>
                <span style="flex:0 0 30px"></span>
            </div>

            <div id="variantRows">
                @foreach($bienTheList as $i => $bt)
                <div class="variant-row" data-variant-row>
                    <input type="hidden" name="bien_the[{{ $i }}][id]" value="{{ $bt['id'] ?? '' }}">
                    <input type="color" name="bien_the[{{ $i }}][hex]" value="{{ $bt['hex'] ?: '#1a1a1a' }}" class="variant-row__color" title="Chọn màu">
                    <input type="text" name="bien_the[{{ $i }}][ten]" value="{{ $bt['ten'] ?? '' }}" placeholder="VD: Đen, Trắng, Bạc…" class="admin-field__input variant-row__name">
                    <select name="bien_the[{{ $i }}][hinh_anh_id]" class="admin-field__select variant-row__img" title="Ảnh hiển thị khi chọn màu này">
                        <option value="">— Ảnh —</option>
                        @foreach($anhOptions as $opt)
                        <option value="{{ $opt['id'] }}" @selected(($bt['hinh_anh_id'] ?? null) == $opt['id'])>{{ $opt['label'] }}</option>
                        @endforeach
                    </select>
                    <input type="number" name="bien_the[{{ $i }}][gia_chenh_lech]" value="{{ $bt['gia_chenh_lech'] ?? 0 }}" class="admin-field__input variant-row__price" title="Chênh lệch giá so với giá bán (đ)">
                    <input type="number" name="bien_the[{{ $i }}][so_luong_ton]" value="{{ $bt['so_luong_ton'] ?? 0 }}" min="0" class="admin-field__input variant-row__stock">
                    <label class="variant-row__active"><input type="checkbox" name="bien_the[{{ $i }}][is_active]" value="1" @checked($bt['is_active'] ?? true)></label>
                    <button type="button" class="variant-row__rm" data-rm-variant title="Xóa màu này">&times;</button>
                </div>
                @endforeach
            </div>

            <button type="button" class="admin-btn admin-btn--ghost mt-2" id="addVariantBtn"><i class="fa-solid fa-plus"></i> Thêm màu</button>

            <template id="variantTpl">
                <div class="variant-row" data-variant-row>
                    <input type="hidden" name="bien_the[__IDX__][id]" value="">
                    <input type="color" name="bien_the[__IDX__][hex]" value="#1a1a1a" class="variant-row__color" title="Chọn màu">
                    <input type="text" name="bien_the[__IDX__][ten]" value="" placeholder="VD: Đen, Trắng, Bạc…" class="admin-field__input variant-row__name">
                    <select name="bien_the[__IDX__][hinh_anh_id]" class="admin-field__select variant-row__img" title="Ảnh hiển thị khi chọn màu này">
                        <option value="">— Ảnh —</option>
                        @foreach($anhOptions as $opt)
                        <option value="{{ $opt['id'] }}">{{ $opt['label'] }}</option>
                        @endforeach
                    </select>
                    <input type="number" name="bien_the[__IDX__][gia_chenh_lech]" value="0" class="admin-field__input variant-row__price" title="Chênh lệch giá so với giá bán (đ)">
                    <input type="number" name="bien_the[__IDX__][so_luong_ton]" value="0" min="0" class="admin-field__input variant-row__stock">
                    <label class="variant-row__active"><input type="checkbox" name="bien_the[__IDX__][is_active]" value="1" checked></label>
                    <button type="button" class="variant-row__rm" data-rm-variant title="Xóa màu này">&times;</button>
                </div>
            </template>
        </div>

        <div class="admin-panel mb-3">
            <h3 class="admin-panel__title mb-3">Phân loại & Trạng thái</h3>
            <div class="admin-field">
                <label class="admin-field__label">Danh mục</label>
                <select name="danh_muc_id" class="admin-field__select" required>
                    <option value="">— Chọn —</option>
                    @foreach($danhMucs as $dm)
                    <option value="{{ $dm->id }}" @selected(old('danh_muc_id', $sanPham->danh_muc_id)==$dm->id)>{{ $dm->ten }}</option>
                    @endforeach
                </select>
                @error('danh_muc_id')<p class="txt-red small">{{ $message }}</p>@enderror
            </div>
            <div class="admin-field">
                <label class="admin-field__label d-flex align-items-center gap-2">
                    <input type="checkbox" name="is_active" value="1" @checked(old('is_active', $sanPham->is_active ?? true))>
                    Hiển thị (active)
                </label>
                <label class="admin-field__label d-flex align-items-center gap-2">
                    <input type="checkbox" name="is_hot" value="1" @checked(old('is_hot', $sanPham->is_hot ?? false))>
                    Sản phẩm HOT
                </label>
                <label class="admin-field__label d-flex align-items-center gap-2">
                    <input type="checkbox" name="is_sale" value="1" @checked(old('is_sale', $sanPham->is_sale ?? false))>
                    Đang giảm giá (SALE)
                </label>
            </div>
        </div>

        <div class="admin-form__actions">
            <button type="submit" class="admin-btn admin-btn--primary"><i class="fa-solid fa-floppy-disk"></i> Lưu sản phẩm</button>
            <a href="{{ route('admin.products.index') }}" class="admin-btn admin-btn--ghost">Hủy</a>
        </div>
    </div>
</form>
@endsection

@push('styles')
<style>
    .img-dropzone { border: 2px dashed rgba(255,255,255,.18); border-radius: 10px; padding: 24px 16px; text-align: center; cursor: pointer; transition: .2s; color: var(--text-muted); }
    .img-dropzone:hover, .img-dropzone.is-drag { border-color: var(--red); background: rgba(255,0,60,.06); color: #fff; }
    .img-dropzone i { font-size: 1.7rem; color: var(--red); }
    .img-dropzone p { margin: 8px 0 0; font-size: .85rem; }
    .img-dropzone span { font-size: .78rem; opacity: .7; }
    .img-preview { display: flex; flex-wrap: wrap; gap: 8px; margin-top: 10px; }
    .img-preview__item { position: relative; width: 80px; height: 80px; border-radius: 8px; overflow: hidden; border: 1px solid rgba(255,255,255,.12); background:#fff; }
    .img-preview__item img { width: 100%; height: 100%; object-fit: contain; }
    .img-preview__rm { position: absolute; top: 2px; right: 2px; width: 20px; height: 20px; border: 0; border-radius: 50%; background: rgba(0,0,0,.7); color: #fff; cursor: pointer; line-height: 18px; font-size: 14px; padding: 0; }

    /* Biến thể màu sắc */
    .variant-list__head { display: flex; align-items: center; gap: 8px; padding: 0 2px 6px; font-size: .72rem; color: var(--text-muted); font-weight: 600; text-transform: uppercase; letter-spacing: .03em; }
    .variant-row { display: flex; align-items: center; gap: 8px; margin-bottom: 8px; }
    .variant-row__color { flex: 0 0 38px; width: 38px; height: 38px; padding: 2px; border: 1px solid rgba(255,255,255,.14); border-radius: 8px; background: transparent; cursor: pointer; }
    .variant-row__name { flex: 1; margin: 0; }
    .variant-row__img { flex: 0 0 90px; margin: 0; padding: 6px 6px; }
    .variant-row__price { flex: 0 0 90px; margin: 0; }
    .variant-row__stock { flex: 0 0 64px; margin: 0; }
    .variant-row__active { flex: 0 0 44px; display: flex; justify-content: center; align-items: center; margin: 0; }
    .variant-row__rm { flex: 0 0 30px; width: 30px; height: 30px; border: 0; border-radius: 8px; background: rgba(255,0,60,.14); color: var(--red); cursor: pointer; font-size: 20px; line-height: 1; transition: .15s; }
    .variant-row__rm:hover { background: var(--red); color: #fff; }
</style>
@endpush

@push('scripts')
<script>
(function () {
    var dz = document.getElementById('imgDropzone');
    var input = document.getElementById('imgInput');
    var preview = document.getElementById('imgPreview');
    if (!dz || !input) return;
    var store = new DataTransfer();

    function render() {
        preview.innerHTML = '';
        Array.from(store.files).forEach(function (file, idx) {
            var url = URL.createObjectURL(file);
            var item = document.createElement('div');
            item.className = 'img-preview__item';
            item.innerHTML = '<img src="' + url + '" alt=""><button type="button" class="img-preview__rm" data-idx="' + idx + '">&times;</button>';
            preview.appendChild(item);
        });
    }
    function addFiles(files) {
        Array.from(files).forEach(function (f) { if (f.type.indexOf('image/') === 0) store.items.add(f); });
        input.files = store.files;
        render();
    }

    dz.addEventListener('click', function () { input.click(); });
    input.addEventListener('change', function () {
        // file lấy từ hộp thoại -> gom vào store rồi gán lại
        var picked = Array.from(input.files);
        // tránh đệ quy: chỉ thêm file chưa có trong store
        var current = Array.from(store.files);
        if (picked.length && picked !== current) {
            picked.forEach(function (f) {
                var dup = current.some(function (c) { return c.name === f.name && c.size === f.size; });
                if (!dup && f.type.indexOf('image/') === 0) store.items.add(f);
            });
            input.files = store.files;
            render();
        }
    });

    ['dragover', 'dragenter'].forEach(function (ev) {
        dz.addEventListener(ev, function (e) { e.preventDefault(); dz.classList.add('is-drag'); });
    });
    ['dragleave', 'dragend'].forEach(function (ev) {
        dz.addEventListener(ev, function (e) { e.preventDefault(); dz.classList.remove('is-drag'); });
    });
    dz.addEventListener('drop', function (e) {
        e.preventDefault();
        dz.classList.remove('is-drag');
        addFiles(e.dataTransfer.files);
    });

    preview.addEventListener('click', function (e) {
        var btn = e.target.closest('.img-preview__rm');
        if (!btn) return;
        var idx = parseInt(btn.dataset.idx);
        var nt = new DataTransfer();
        Array.from(store.files).forEach(function (f, i) { if (i !== idx) nt.items.add(f); });
        store = nt;
        input.files = store.files;
        render();
    });
})();

/* Repeater biến thể màu sắc */
(function () {
    var rows = document.getElementById('variantRows');
    var addBtn = document.getElementById('addVariantBtn');
    var tpl = document.getElementById('variantTpl');
    if (!rows || !addBtn || !tpl) return;

    // index kế tiếp = số dòng hiện có (các dòng cũ đánh số 0..n-1)
    var nextIdx = rows.querySelectorAll('[data-variant-row]').length;

    addBtn.addEventListener('click', function () {
        var html = tpl.innerHTML.replace(/__IDX__/g, nextIdx++);
        rows.insertAdjacentHTML('beforeend', html);
    });

    rows.addEventListener('click', function (e) {
        var rm = e.target.closest('[data-rm-variant]');
        if (!rm) return;
        var row = rm.closest('[data-variant-row]');
        if (row) row.remove();
    });
})();
</script>
@endpush
