@extends('layouts.admin')

@section('title', 'Quản lý setup - SKT Admin')
@section('nav-setups', 'is-active')

@section('content')
<h1 class="admin-page-title">Setup trưng bày</h1>
<p class="admin-page-sub">Quản lý các setup nổi bật hiển thị ngoài cửa hàng</p>

<div class="admin-grid-2">
    <section class="admin-table-wrap">
        <div class="admin-table-wrap__head"><h3 class="admin-panel__title">Danh sách setup</h3></div>
        <table class="admin-table">
            <thead><tr><th>Setup</th><th>Game thủ</th><th>Nổi bật</th><th>Thứ tự</th><th></th></tr></thead>
            <tbody>
                @forelse($setups as $setup)
                <tr class="admin-table__row">
                    <td><div class="admin-table__product">
                        @if($setup->anh_chinh)<img class="admin-table__thumb" src="{{ asset('storage/'.$setup->anh_chinh) }}" alt="">@endif
                        <div class="admin-table__name">{{ $setup->ten_setup }}</div>
                    </div></td>
                    <td>{{ $setup->ten_game_thu ?? '—' }}</td>
                    <td><span class="admin-badge admin-badge--{{ $setup->noi_bat?'done':'pending' }}">{{ $setup->noi_bat?'Có':'Không' }}</span></td>
                    <td>{{ $setup->thu_tu }}</td>
                    <td>
                        <form method="POST" action="{{ route('admin.setups.destroy', $setup->id) }}" onsubmit="return confirm('Xóa setup này?')">
                            @csrf @method('DELETE')
                            <button class="admin-icon-btn admin-icon-btn--danger"><i class="fa-solid fa-trash-can"></i></button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr class="admin-table__row"><td colspan="5" class="admin-table__muted">Chưa có setup</td></tr>
                @endforelse
            </tbody>
        </table>
        <div class="admin-pagination">{{ $setups->links() }}</div>
    </section>

    <section class="admin-panel">
        <h3 class="admin-panel__title mb-3">Thêm setup</h3>
        <form method="POST" action="{{ route('admin.setups.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="admin-field">
                <label class="admin-field__label">Tên setup</label>
                <input type="text" name="ten_setup" class="admin-field__input" value="{{ old('ten_setup') }}" required>
                @error('ten_setup')<p class="txt-red small">{{ $message }}</p>@enderror
            </div>
            <div class="admin-field">
                <label class="admin-field__label">Tên game thủ</label>
                <input type="text" name="ten_game_thu" class="admin-field__input" value="{{ old('ten_game_thu') }}">
            </div>
            <div class="admin-field">
                <label class="admin-field__label">Ảnh chính</label>
                <input type="file" name="anh_chinh" class="admin-field__input" accept="image/*">
            </div>
            <div class="admin-field">
                <label class="admin-field__label">Mô tả</label>
                <textarea name="mo_ta" class="admin-field__textarea">{{ old('mo_ta') }}</textarea>
            </div>
            <div class="admin-field__row">
                <div class="admin-field">
                    <label class="admin-field__label">Thứ tự</label>
                    <input type="number" name="thu_tu" class="admin-field__input" value="{{ old('thu_tu', 0) }}">
                </div>
                <div class="admin-field">
                    <label class="admin-field__label">Nổi bật</label>
                    <select name="noi_bat" class="admin-field__select">
                        <option value="0">Không</option>
                        <option value="1">Có</option>
                    </select>
                </div>
            </div>
            <div class="admin-form__actions">
                <button type="submit" class="admin-btn admin-btn--primary"><i class="fa-solid fa-plus"></i> Thêm setup</button>
            </div>
        </form>
    </section>
</div>
@endsection
