@extends('layouts.store')

@section('title', 'Tai khoan cua toi - SKT Gaming Store')

@php
    $tabItems = [
        'overview' => ['label' => 'Tong quan', 'icon' => 'fa-gauge-high'],
        'profile' => ['label' => 'Ho so', 'icon' => 'fa-user-gear'],
        'addresses' => ['label' => 'Dia chi', 'icon' => 'fa-location-dot'],
        'wishlist' => ['label' => 'Wishlist', 'icon' => 'fa-heart'],
        'orders' => ['label' => 'Don hang', 'icon' => 'fa-receipt'],
        'reviews' => ['label' => 'Danh gia', 'icon' => 'fa-star'],
        'security' => ['label' => 'Bao mat', 'icon' => 'fa-shield-halved'],
    ];
@endphp

@push('styles')
<style>
    .profile-page { padding-top: 20px; }
    .profile-hero { display: grid; grid-template-columns: auto 1fr; gap: 18px; align-items: center; padding: 22px; border: 1px solid rgba(255,255,255,.08); background: rgba(12,14,20,.74); border-radius: 8px; }
    .profile-avatar { width: 76px; height: 76px; border-radius: 50%; display: grid; place-items: center; background: linear-gradient(135deg, #ff003c, #00e5ff); color: #fff; font-family: Orbitron, sans-serif; font-weight: 800; font-size: 1.45rem; }
    .profile-hero__name { margin: 0; color: #fff; font-family: Orbitron, sans-serif; font-size: 1.55rem; }
    .profile-hero__meta { margin: 6px 0 0; color: #94a3b8; font-size: .92rem; }
    .profile-stats { display: grid; grid-template-columns: repeat(4, minmax(0, 1fr)); gap: 12px; margin-top: 14px; }
    .profile-stat { border: 1px solid rgba(255,255,255,.08); background: rgba(255,255,255,.035); border-radius: 8px; padding: 14px; }
    .profile-stat strong { display: block; color: #fff; font-size: 1.35rem; }
    .profile-stat span { color: #94a3b8; font-size: .82rem; text-transform: uppercase; letter-spacing: .04em; }
    .profile-shell { display: grid; grid-template-columns: 260px minmax(0, 1fr); gap: 20px; margin-top: 22px; }
    .profile-tabs { border: 1px solid rgba(255,255,255,.08); background: rgba(12,14,20,.74); border-radius: 8px; padding: 10px; align-self: start; }
    .profile-tab { display: flex; align-items: center; gap: 10px; color: #cbd5e1; text-decoration: none; border-radius: 6px; padding: 11px 12px; font-weight: 600; }
    .profile-tab:hover, .profile-tab.is-active { color: #fff; background: rgba(255,0,60,.16); }
    .profile-panel { border: 1px solid rgba(255,255,255,.08); background: rgba(12,14,20,.74); border-radius: 8px; padding: 20px; min-width: 0; }
    .profile-panel__head { display: flex; justify-content: space-between; gap: 12px; align-items: center; margin-bottom: 16px; }
    .profile-panel__title { margin: 0; color: #fff; font-family: Orbitron, sans-serif; font-size: 1.05rem; }
    .profile-grid { display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 12px; }
    .profile-field label { display: block; color: #94a3b8; font-size: .78rem; text-transform: uppercase; margin-bottom: 6px; }
    .profile-field input, .profile-field select, .profile-field textarea { width: 100%; background: rgba(10,12,16,.78); border: 1px solid rgba(255,255,255,.1); border-radius: 8px; color: #fff; padding: 10px 12px; outline: none; }
    .profile-field textarea { min-height: 84px; resize: vertical; }
    .profile-field input:focus, .profile-field select:focus, .profile-field textarea:focus { border-color: #00e5ff; }
    .profile-actions { display: flex; flex-wrap: wrap; gap: 10px; align-items: center; margin-top: 14px; }
    .profile-btn { border: 0; border-radius: 8px; padding: 10px 14px; color: #fff; background: var(--red); font-weight: 700; text-decoration: none; display: inline-flex; align-items: center; gap: 8px; }
    .profile-btn--ghost { border: 1px solid rgba(255,255,255,.14); background: transparent; color: #cbd5e1; }
    .profile-btn--danger { background: rgba(255,0,60,.22); border: 1px solid rgba(255,0,60,.34); }
    .profile-list { display: grid; gap: 12px; }
    .profile-item { border: 1px solid rgba(255,255,255,.08); background: rgba(255,255,255,.035); border-radius: 8px; padding: 14px; }
    .profile-item__top { display: flex; justify-content: space-between; gap: 12px; align-items: flex-start; margin-bottom: 10px; }
    .profile-item__title { color: #fff; margin: 0; font-weight: 700; }
    .profile-item__meta { color: #94a3b8; margin: 4px 0 0; font-size: .9rem; }
    .profile-badge { display: inline-flex; align-items: center; gap: 6px; border-radius: 999px; background: rgba(0,229,255,.12); color: #67e8f9; padding: 5px 9px; font-size: .78rem; font-weight: 700; }
    .profile-product { display: grid; grid-template-columns: 92px 1fr auto; gap: 14px; align-items: center; }
    .profile-product img { width: 92px; height: 92px; object-fit: cover; border-radius: 8px; background: rgba(255,255,255,.04); }
    .profile-product__price { color: #ff4b6e; font-weight: 800; }
    .profile-empty { color: #94a3b8; border: 1px dashed rgba(255,255,255,.16); border-radius: 8px; padding: 22px; text-align: center; }
    .profile-order-lines { color: #94a3b8; margin: 8px 0 0; padding-left: 18px; }
    @media (max-width: 992px) {
        .profile-shell { grid-template-columns: 1fr; }
        .profile-tabs { display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); }
        .profile-stats { grid-template-columns: repeat(2, minmax(0, 1fr)); }
    }
    @media (max-width: 640px) {
        .profile-hero { grid-template-columns: 1fr; }
        .profile-tabs, .profile-grid { grid-template-columns: 1fr; }
        .profile-product { grid-template-columns: 76px 1fr; }
        .profile-product form { grid-column: 1 / -1; }
    }
</style>
@endpush

@section('content')
<nav class="breadcrumb-bar container-fluid px-4 px-xl-5">
    <ol class="breadcrumb-bar__list">
        <li><a href="{{ route('home') }}"><i class="fa-solid fa-house"></i> Trang chu</a></li>
        <li class="breadcrumb-bar__active">Tai khoan</li>
    </ol>
</nav>

<main class="profile-page container-fluid px-4 px-xl-5">
    @if (session('success'))
        <div class="store-alert">{{ session('success') }}</div>
    @endif
    @if ($errors->any())
        <div class="store-alert store-alert--err">{{ $errors->first() }}</div>
    @endif

    <section class="profile-hero">
        <div class="profile-avatar">{{ mb_strtoupper(mb_substr($user->ho_ten ?? 'SKT', 0, 2)) }}</div>
        <div>
            <h1 class="profile-hero__name">{{ $user->ho_ten }}</h1>
            <p class="profile-hero__meta">
                {{ $user->email }} · Hang {{ strtoupper($user->hang_thanh_vien ?? 'bronze') }} · {{ number_format($user->diem_tich_luy ?? 0) }} diem
            </p>
            <div class="profile-stats">
                <div class="profile-stat"><strong>{{ $stats['orders'] }}</strong><span>Don hang</span></div>
                <div class="profile-stat"><strong>{{ $stats['wishlist'] }}</strong><span>Wishlist</span></div>
                <div class="profile-stat"><strong>{{ $stats['addresses'] }}</strong><span>Dia chi</span></div>
                <div class="profile-stat"><strong>{{ $stats['reviews'] }}</strong><span>Danh gia</span></div>
            </div>
        </div>
    </section>

    <div class="profile-shell">
        <aside class="profile-tabs">
            @foreach ($tabItems as $key => $tab)
                <a class="profile-tab {{ $activeTab === $key ? 'is-active' : '' }}" href="{{ route('profile.show', ['tab' => $key]) }}">
                    <i class="fa-solid {{ $tab['icon'] }}"></i> {{ $tab['label'] }}
                </a>
            @endforeach
        </aside>

        <section class="profile-panel">
            @if ($activeTab === 'overview')
                <div class="profile-panel__head">
                    <h2 class="profile-panel__title">Tong quan tai khoan</h2>
                    <a class="profile-btn profile-btn--ghost" href="{{ route('products.index') }}"><i class="fa-solid fa-bag-shopping"></i> Mua sam</a>
                </div>
                <div class="profile-list">
                    <div class="profile-item">
                        <div class="profile-item__top">
                            <div>
                                <h3 class="profile-item__title">Don hang gan day</h3>
                                <p class="profile-item__meta">{{ $orders->count() }} don gan nhat trong he thong.</p>
                            </div>
                            <a class="profile-btn profile-btn--ghost" href="{{ route('profile.show', ['tab' => 'orders']) }}">Xem don</a>
                        </div>
                    </div>
                    <div class="profile-item">
                        <div class="profile-item__top">
                            <div>
                                <h3 class="profile-item__title">San pham yeu thich</h3>
                                <p class="profile-item__meta">{{ $wishlistItems->count() }} san pham dang duoc luu.</p>
                            </div>
                            <a class="profile-btn profile-btn--ghost" href="{{ route('profile.show', ['tab' => 'wishlist']) }}">Xem wishlist</a>
                        </div>
                    </div>
                </div>
            @elseif ($activeTab === 'profile')
                <div class="profile-panel__head">
                    <h2 class="profile-panel__title">Ho so ca nhan</h2>
                </div>
                <form action="{{ route('profile.update') }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <div class="profile-grid">
                        <div class="profile-field">
                            <label>Ho ten</label>
                            <input type="text" name="ho_ten" value="{{ old('ho_ten', $user->ho_ten) }}" required>
                        </div>
                        <div class="profile-field">
                            <label>Email</label>
                            <input type="email" name="email" value="{{ old('email', $user->email) }}" required>
                        </div>
                        <div class="profile-field">
                            <label>So dien thoai</label>
                            <input type="text" name="so_dien_thoai" value="{{ old('so_dien_thoai', $user->so_dien_thoai) }}">
                        </div>
                        <div class="profile-field">
                            <label>Ngay sinh</label>
                            <input type="date" name="ngay_sinh" value="{{ old('ngay_sinh', $user->ngay_sinh?->format('Y-m-d')) }}">
                        </div>
                        <div class="profile-field">
                            <label>Gioi tinh</label>
                            <select name="gioi_tinh">
                                <option value="">Chua chon</option>
                                <option value="nam" @selected(old('gioi_tinh', $user->gioi_tinh) === 'nam')>Nam</option>
                                <option value="nu" @selected(old('gioi_tinh', $user->gioi_tinh) === 'nu')>Nu</option>
                                <option value="khac" @selected(old('gioi_tinh', $user->gioi_tinh) === 'khac')>Khac</option>
                            </select>
                        </div>
                    </div>
                    <div class="profile-actions">
                        <button class="profile-btn" type="submit"><i class="fa-solid fa-floppy-disk"></i> Luu ho so</button>
                    </div>
                </form>
            @elseif ($activeTab === 'addresses')
                <div class="profile-panel__head">
                    <h2 class="profile-panel__title">So dia chi</h2>
                    <span class="profile-badge"><i class="fa-solid fa-location-dot"></i> {{ $addresses->count() }} dia chi</span>
                </div>

                <form action="{{ route('profile.addresses.store') }}" method="POST" class="profile-item mb-3">
                    @csrf
                    <div class="profile-grid">
                        <div class="profile-field">
                            <label>Nguoi nhan</label>
                            <input type="text" name="ten_nguoi_nhan" value="{{ old('ten_nguoi_nhan', $user->ho_ten) }}" required>
                        </div>
                        <div class="profile-field">
                            <label>So dien thoai</label>
                            <input type="text" name="so_dien_thoai" value="{{ old('so_dien_thoai', $user->so_dien_thoai) }}" required>
                        </div>
                        <div class="profile-field">
                            <label>Tinh thanh</label>
                            <input type="text" name="tinh_thanh" value="{{ old('tinh_thanh') }}" required>
                        </div>
                        <div class="profile-field">
                            <label>Quan huyen</label>
                            <input type="text" name="quan_huyen" value="{{ old('quan_huyen') }}" required>
                        </div>
                        <div class="profile-field">
                            <label>Phuong xa</label>
                            <input type="text" name="phuong_xa" value="{{ old('phuong_xa') }}">
                        </div>
                        <div class="profile-field">
                            <label>Loai dia chi</label>
                            <select name="loai_dia_chi">
                                <option value="nha">Nha rieng</option>
                                <option value="cong_ty">Cong ty</option>
                                <option value="khac">Khac</option>
                            </select>
                        </div>
                        <div class="profile-field" style="grid-column:1 / -1">
                            <label>Dia chi cu the</label>
                            <textarea name="dia_chi_cu_the" required>{{ old('dia_chi_cu_the') }}</textarea>
                        </div>
                    </div>
                    <div class="profile-actions">
                        <label class="text-secondary"><input type="checkbox" name="is_mac_dinh" value="1"> Mac dinh</label>
                        <button class="profile-btn" type="submit"><i class="fa-solid fa-plus"></i> Them dia chi</button>
                    </div>
                </form>

                <div class="profile-list">
                    @forelse ($addresses as $address)
                        <div class="profile-item">
                            <div class="profile-item__top">
                                <div>
                                    <h3 class="profile-item__title">{{ $address->ten_nguoi_nhan }} · {{ $address->so_dien_thoai }}</h3>
                                    <p class="profile-item__meta">{{ $address->fullAddress() }}</p>
                                </div>
                                @if ($address->is_mac_dinh)
                                    <span class="profile-badge"><i class="fa-solid fa-check"></i> Mac dinh</span>
                                @endif
                            </div>
                            <form action="{{ route('profile.addresses.update', $address) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <div class="profile-grid">
                                    <div class="profile-field"><label>Nguoi nhan</label><input type="text" name="ten_nguoi_nhan" value="{{ $address->ten_nguoi_nhan }}" required></div>
                                    <div class="profile-field"><label>So dien thoai</label><input type="text" name="so_dien_thoai" value="{{ $address->so_dien_thoai }}" required></div>
                                    <div class="profile-field"><label>Tinh thanh</label><input type="text" name="tinh_thanh" value="{{ $address->tinh_thanh }}" required></div>
                                    <div class="profile-field"><label>Quan huyen</label><input type="text" name="quan_huyen" value="{{ $address->quan_huyen }}" required></div>
                                    <div class="profile-field"><label>Phuong xa</label><input type="text" name="phuong_xa" value="{{ $address->phuong_xa }}"></div>
                                    <div class="profile-field">
                                        <label>Loai dia chi</label>
                                        <select name="loai_dia_chi">
                                            <option value="nha" @selected($address->loai_dia_chi === 'nha')>Nha rieng</option>
                                            <option value="cong_ty" @selected($address->loai_dia_chi === 'cong_ty')>Cong ty</option>
                                            <option value="khac" @selected($address->loai_dia_chi === 'khac')>Khac</option>
                                        </select>
                                    </div>
                                    <div class="profile-field" style="grid-column:1 / -1"><label>Dia chi cu the</label><textarea name="dia_chi_cu_the" required>{{ $address->dia_chi_cu_the }}</textarea></div>
                                </div>
                                <div class="profile-actions">
                                    <label class="text-secondary"><input type="checkbox" name="is_mac_dinh" value="1" @checked($address->is_mac_dinh)> Mac dinh</label>
                                    <button class="profile-btn" type="submit"><i class="fa-solid fa-floppy-disk"></i> Luu</button>
                                </div>
                            </form>
                            <div class="profile-actions">
                                @unless ($address->is_mac_dinh)
                                    <form action="{{ route('profile.addresses.default', $address) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <button class="profile-btn profile-btn--ghost" type="submit">Dat mac dinh</button>
                                    </form>
                                @endunless
                                <form action="{{ route('profile.addresses.destroy', $address) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button class="profile-btn profile-btn--danger" type="submit">Xoa dia chi</button>
                                </form>
                            </div>
                        </div>
                    @empty
                        <div class="profile-empty">Chua co dia chi nao.</div>
                    @endforelse
                </div>
            @elseif ($activeTab === 'wishlist')
                <div class="profile-panel__head">
                    <h2 class="profile-panel__title">Wishlist</h2>
                    <a class="profile-btn profile-btn--ghost" href="{{ route('products.index') }}"><i class="fa-solid fa-plus"></i> Them san pham</a>
                </div>
                <div class="profile-list">
                    @forelse ($wishlistItems as $item)
                        @php($product = $item->sanPham)
                        @if ($product)
                            <div class="profile-item profile-product">
                                <img src="{{ asset($product->mainImagePath()) }}" alt="{{ $product->ten }}">
                                <div>
                                    <h3 class="profile-item__title">{{ $product->ten }}</h3>
                                    <p class="profile-item__meta">{{ $product->danhMuc?->ten ?? 'Gaming Gear' }} · {{ $product->thuongHieu?->ten ?? 'SKT' }}</p>
                                    <div class="profile-product__price">{{ $product->formattedPrice() }}</div>
                                </div>
                                <form action="{{ route('wishlist.destroy', $item) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <a class="profile-btn profile-btn--ghost" href="{{ route('products.show', $product) }}">Chi tiet</a>
                                    <button class="profile-btn profile-btn--danger" type="submit">Xoa</button>
                                </form>
                            </div>
                        @endif
                    @empty
                        <div class="profile-empty">Wishlist dang trong.</div>
                    @endforelse
                </div>
            @elseif ($activeTab === 'orders')
                <div class="profile-panel__head">
                    <h2 class="profile-panel__title">Don hang</h2>
                </div>
                <div class="profile-list">
                    @forelse ($orders as $order)
                        <div class="profile-item">
                            <div class="profile-item__top">
                                <div>
                                    <h3 class="profile-item__title">#{{ $order->ma_don }}</h3>
                                    <p class="profile-item__meta">{{ $order->ngay_tao?->format('d/m/Y H:i') }} · {{ $order->trang_thai }}</p>
                                </div>
                                <strong class="profile-product__price">{{ number_format($order->tong_tien, 0, ',', '.') }}d</strong>
                            </div>
                            <ul class="profile-order-lines">
                                @foreach ($order->chiTiet as $line)
                                    <li>{{ $line->ten_san_pham }} x{{ $line->so_luong }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @empty
                        <div class="profile-empty">Chua co don hang nao.</div>
                    @endforelse
                </div>
            @elseif ($activeTab === 'reviews')
                <div class="profile-panel__head">
                    <h2 class="profile-panel__title">Danh gia cua toi</h2>
                </div>
                <div class="profile-list">
                    @forelse ($reviews as $review)
                        <div class="profile-item">
                            <div class="profile-item__top">
                                <div>
                                    <h3 class="profile-item__title">{{ $review->sanPham?->ten ?? 'San pham' }}</h3>
                                    <p class="profile-item__meta">{{ $review->ngay_tao?->format('d/m/Y') }} · {{ $review->so_sao }} sao</p>
                                </div>
                                @if ($review->sanPham)
                                    <a class="profile-btn profile-btn--ghost" href="{{ route('products.show', $review->sanPham) }}">Xem</a>
                                @endif
                            </div>
                            <p class="profile-item__meta">{{ $review->noi_dung ?: 'Khong co noi dung.' }}</p>
                        </div>
                    @empty
                        <div class="profile-empty">Chua co danh gia nao.</div>
                    @endforelse
                </div>
            @elseif ($activeTab === 'security')
                <div class="profile-panel__head">
                    <h2 class="profile-panel__title">Bao mat tai khoan</h2>
                </div>
                <form action="{{ route('profile.password') }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <div class="profile-grid">
                        <div class="profile-field">
                            <label>Mat khau hien tai</label>
                            <input type="password" name="current_password" required>
                        </div>
                        <div class="profile-field">
                            <label>Mat khau moi</label>
                            <input type="password" name="password" required>
                        </div>
                        <div class="profile-field">
                            <label>Xac nhan mat khau moi</label>
                            <input type="password" name="password_confirmation" required>
                        </div>
                    </div>
                    <div class="profile-actions">
                        <button class="profile-btn" type="submit"><i class="fa-solid fa-key"></i> Doi mat khau</button>
                    </div>
                </form>
            @endif
        </section>
    </div>
</main>
@endsection
