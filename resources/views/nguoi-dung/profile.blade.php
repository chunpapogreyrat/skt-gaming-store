@extends('layouts.app')

@section('title', 'Tài khoản của tôi - YUKI Gaming Store')

@section('content')
@php
    $rankMap = ['bronze' => 'Bronze Member', 'silver' => 'Silver Member', 'gold' => 'Gold Member', 'diamond' => 'Diamond Member'];
    $rankLabel = $rankMap[$user->hang_thanh_vien] ?? 'Thành viên';
    $namThamGia = optional($user->created_at)->format('Y') ?? date('Y');
    $ngaySinh = $user->ngay_sinh ? \Illuminate\Support\Carbon::parse($user->ngay_sinh)->format('Y-m-d') : '';
    $initials = mb_strtoupper(mb_substr($user->ho_ten ?? 'YUKI', 0, 2));
    $dangXuLy = $orders->whereNotIn('trang_thai_don_hang', ['da_giao', 'da_huy'])->count();
    $statusMap = [
        'cho_xac_nhan' => ['Chờ xác nhận', 'order-status--shipping'],
        'dang_chuan_bi' => ['Đang chuẩn bị', 'order-status--shipping'],
        'dang_giao' => ['Đang giao', 'order-status--shipping'],
        'da_giao' => ['Hoàn thành', 'order-status--done'],
        'da_huy' => ['Đã hủy', 'order-status--cancel'],
    ];
    // Map activeTab (server) -> data-tab (thiết kế)
    $tabAlias = ['profile' => 'info', 'addresses' => 'address', 'security' => 'password', 'reviews' => 'orders'];
    $active = $tabAlias[$activeTab] ?? $activeTab;
    $tabKeys = ['overview', 'info', 'orders', 'address', 'wishlist', 'password'];
    if (! in_array($active, $tabKeys, true)) { $active = 'overview'; }
@endphp

<main class="container-fluid px-4 px-xl-5 profile-page">

    @if (session('success'))
        <div class="alert alert-success my-3 py-2 small"><i class="fa-solid fa-circle-check me-1"></i>{{ session('success') }}</div>
    @endif

    {{-- USER HEADER CARD --}}
    <div class="profile-hero" data-aos="fade-up">
        <div class="profile-hero__user">
            <div class="profile-hero__avatar">
                @if ($user->avatar)
                    <img src="{{ asset($user->avatar) }}" alt="Avatar">
                @else
                    <span style="width:100%;height:100%;display:grid;place-items:center;font-family:var(--font-h);font-weight:800;font-size:1.6rem;color:#fff;background:linear-gradient(135deg,var(--red),var(--cyber-cyan,#00e5ff));">{{ $initials }}</span>
                @endif
                <span class="profile-hero__edit"><i class="fa-solid fa-camera"></i></span>
            </div>
            <div class="profile-hero__info">
                <h2 class="profile-hero__name">{{ $user->ho_ten }}</h2>
                <p class="profile-hero__meta">
                    <span><i class="fa-regular fa-calendar"></i> Thành viên từ {{ $namThamGia }}</span>
                    <span class="profile-hero__rank"><i class="fa-solid fa-crown"></i> {{ $rankLabel }}</span>
                </p>
            </div>
        </div>
        <div class="profile-hero__points">
            <span class="profile-hero__points-label">ĐIỂM THƯỞNG</span>
            <span class="profile-hero__points-value">{{ number_format($user->diem_tich_luy) }}</span>
        </div>
    </div>

    {{-- STATS ROW --}}
    <div class="profile-stats" data-aos="fade-up" data-aos-delay="60">
        <div class="stat-card">
            <div class="stat-card__icon stat-card__icon--red"><i class="fa-solid fa-box"></i></div>
            <div class="stat-card__info">
                <span class="stat-card__label">Tổng đơn hàng</span>
                <span class="stat-card__value">{{ $stats['orders'] }}</span>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-card__icon stat-card__icon--blue"><i class="fa-solid fa-spinner"></i></div>
            <div class="stat-card__info">
                <span class="stat-card__label">Đang xử lý</span>
                <span class="stat-card__value">{{ $dangXuLy }}</span>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-card__icon stat-card__icon--pink"><i class="fa-solid fa-heart"></i></div>
            <div class="stat-card__info">
                <span class="stat-card__label">Wishlist</span>
                <span class="stat-card__value">{{ $stats['wishlist'] }}</span>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-card__icon stat-card__icon--gold"><i class="fa-solid fa-coins"></i></div>
            <div class="stat-card__info">
                <span class="stat-card__label">Điểm thưởng</span>
                <span class="stat-card__value">{{ number_format($user->diem_tich_luy) }}</span>
            </div>
        </div>
    </div>

    <div class="row g-4">

        {{-- SIDEBAR --}}
        <aside class="col-lg-3" data-aos="fade-right">
            <div class="profile-sidebar">
                <button class="profile-sidebar__link {{ $active === 'overview' ? 'is-active' : '' }}" data-tab="overview">
                    <i class="fa-solid fa-table-cells-large"></i> <span>Tổng quan</span>
                </button>
                <button class="profile-sidebar__link {{ $active === 'info' ? 'is-active' : '' }}" data-tab="info">
                    <i class="fa-solid fa-user"></i> <span>Thông tin cá nhân</span>
                </button>
                <button class="profile-sidebar__link {{ $active === 'orders' ? 'is-active' : '' }}" data-tab="orders">
                    <i class="fa-solid fa-bag-shopping"></i> <span>Đơn hàng</span>
                </button>
                <button class="profile-sidebar__link {{ $active === 'address' ? 'is-active' : '' }}" data-tab="address">
                    <i class="fa-solid fa-location-dot"></i> <span>Địa chỉ giao hàng</span>
                </button>
                <button class="profile-sidebar__link {{ $active === 'wishlist' ? 'is-active' : '' }}" data-tab="wishlist">
                    <i class="fa-solid fa-heart"></i> <span>Wishlist</span>
                </button>
                <button class="profile-sidebar__link {{ $active === 'password' ? 'is-active' : '' }}" data-tab="password">
                    <i class="fa-solid fa-lock"></i> <span>Đổi mật khẩu</span>
                </button>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="profile-sidebar__link profile-sidebar__link--logout w-100 border-0 bg-transparent text-start">
                        <i class="fa-solid fa-right-from-bracket"></i> <span>Đăng xuất</span>
                    </button>
                </form>
            </div>
        </aside>

        {{-- CONTENT --}}
        <section class="col-lg-9" data-aos="fade-up" data-aos-delay="80">

            {{-- TAB: TỔNG QUAN --}}
            <div class="profile-tab {{ $active === 'overview' ? 'is-active' : '' }}" data-panel="overview">
                <div class="profile-panel mb-4">
                    <div class="profile-panel__head">
                        <h5 class="profile-panel__title m-0"><i class="fa-solid fa-bag-shopping"></i> Đơn Hàng Gần Đây</h5>
                        <a href="{{ route('orders.index') }}" class="profile-link">Xem tất cả <i class="fa-solid fa-angle-right"></i></a>
                    </div>
                    <div class="table-responsive">
                        <table class="profile-table">
                            <thead>
                                <tr><th>Mã đơn</th><th>Ngày đặt</th><th>Tổng tiền</th><th>Trạng thái</th><th>Chi tiết</th></tr>
                            </thead>
                            <tbody>
                                @forelse ($orders->take(3) as $order)
                                    @php [$stLabel, $stClass] = $statusMap[$order->trang_thai_don_hang] ?? ['Đang xử lý', '']; @endphp
                                    <tr>
                                        <td class="order-code">{{ $order->ma_don_hang }}</td>
                                        <td>{{ optional($order->created_at)->format('d/m/Y') }}</td>
                                        <td class="order-total">{{ number_format($order->tong_tien) }}đ</td>
                                        <td><span class="order-status {{ $stClass }}">{{ $stLabel }}</span></td>
                                        <td><a href="{{ route('orders.show', $order->ma_don_hang) }}" class="order-view">Xem chi tiết <i class="fa-solid fa-eye"></i></a></td>
                                    </tr>
                                @empty
                                    <tr><td colspan="5" class="text-center text-secondary py-3">Chưa có đơn hàng nào.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="profile-panel mb-4">
                    <div class="profile-panel__head">
                        <h5 class="profile-panel__title m-0"><i class="fa-solid fa-heart"></i> Wishlist Gần Đây</h5>
                        <button class="profile-link" data-tab="wishlist">Xem tất cả <i class="fa-solid fa-angle-right"></i></button>
                    </div>
                    <div class="wishlist-grid">
                        @forelse ($wishlistItems->take(3) as $item)
                            @if ($item->sanPham)
                            <div class="wishlist-card">
                                <form action="{{ route('wishlist.destroy', $item->id) }}" method="POST">
                                    @csrf @method('DELETE')
                                    <button class="wishlist-card__heart" type="submit"><i class="fa-solid fa-heart"></i></button>
                                </form>
                                <a href="{{ route('products.show', $item->sanPham->slug) }}" class="wishlist-card__img"><img src="{{ asset($item->sanPham->mainImagePath()) }}" alt="{{ $item->sanPham->ten }}"></a>
                                <div class="wishlist-card__body">
                                    <h6 class="wishlist-card__name">{{ $item->sanPham->ten }}</h6>
                                    <span class="wishlist-card__price">{{ $item->sanPham->formattedPrice() }}</span>
                                    <form action="{{ route('cart.add') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="san_pham_id" value="{{ $item->sanPham->id }}">
                                        <input type="hidden" name="so_luong" value="1">
                                        <button class="profile-btn profile-btn--outline w-100" type="submit">Thêm vào giỏ</button>
                                    </form>
                                </div>
                            </div>
                            @endif
                        @empty
                            <p class="text-secondary">Chưa có sản phẩm yêu thích.</p>
                        @endforelse
                    </div>
                </div>

                <div class="row g-4">
                    <div class="col-md-6">
                        <div class="profile-panel h-100">
                            <h5 class="profile-panel__title"><i class="fa-solid fa-location-dot"></i> Địa Chỉ Mặc Định</h5>
                            @php $diaChiMacDinh = $addresses->firstWhere('is_mac_dinh', true) ?? $addresses->first(); @endphp
                            @if ($diaChiMacDinh)
                                <p class="profile-address__name">{{ $diaChiMacDinh->ten_nguoi_nhan }} — {{ $diaChiMacDinh->loai_dia_chi ?? 'Nhà riêng' }}</p>
                                <p class="profile-address__text">{{ $diaChiMacDinh->dia_chi_cu_the }}, {{ $diaChiMacDinh->phuong_xa }}, {{ $diaChiMacDinh->quan_huyen }}, {{ $diaChiMacDinh->tinh_thanh }}</p>
                                <p class="profile-address__phone"><i class="fa-solid fa-phone"></i> {{ $diaChiMacDinh->so_dien_thoai }}</p>
                            @else
                                <p class="profile-address__text">Bạn chưa có địa chỉ giao hàng.</p>
                            @endif
                            <button class="profile-link" data-tab="address"><i class="fa-solid fa-pen"></i> Quản lý địa chỉ</button>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="profile-panel h-100">
                            <h5 class="profile-panel__title"><i class="fa-solid fa-shield-halved"></i> Bảo Mật Tài Khoản</h5>
                            <p class="profile-address__text">Thay đổi mật khẩu thường xuyên để bảo vệ tài khoản và thông tin mua hàng của bạn.</p>
                            <button class="profile-btn profile-btn--outline" data-tab="password">ĐỔI MẬT KHẨU</button>
                        </div>
                    </div>
                </div>
            </div>

            {{-- TAB: THÔNG TIN CÁ NHÂN --}}
            <div class="profile-tab {{ $active === 'info' ? 'is-active' : '' }}" data-panel="info">
                <div class="profile-panel">
                    <h5 class="profile-panel__title"><i class="fa-solid fa-id-card"></i> Thông Tin Cá Nhân</h5>
                    <form class="profile-form" action="{{ route('profile.update') }}" method="POST">
                        @csrf @method('PATCH')
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="profile-form__label">Họ và tên</label>
                                <input type="text" name="ho_ten" class="profile-form__input" value="{{ old('ho_ten', $user->ho_ten) }}" required>
                                @error('ho_ten') <div class="auth-error-msg">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="profile-form__label">Email</label>
                                <input type="email" name="email" class="profile-form__input" value="{{ old('email', $user->email) }}" required>
                                @error('email') <div class="auth-error-msg">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="profile-form__label">Số điện thoại</label>
                                <input type="text" name="so_dien_thoai" class="profile-form__input" value="{{ old('so_dien_thoai', $user->so_dien_thoai) }}">
                            </div>
                            <div class="col-md-6">
                                <label class="profile-form__label">Ngày sinh</label>
                                <input type="date" name="ngay_sinh" class="profile-form__input" value="{{ old('ngay_sinh', $ngaySinh) }}">
                            </div>
                            <div class="col-md-6">
                                <label class="profile-form__label">Giới tính</label>
                                <select class="profile-form__input" name="gioi_tinh">
                                    <option value="nam" @selected($user->gioi_tinh === 'nam')>Nam</option>
                                    <option value="nu" @selected($user->gioi_tinh === 'nu')>Nữ</option>
                                    <option value="khac" @selected($user->gioi_tinh === 'khac')>Khác</option>
                                </select>
                            </div>
                            <div class="col-md-6 d-flex align-items-end">
                                <button class="profile-btn profile-btn--primary w-100" type="submit">CẬP NHẬT THÔNG TIN</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            {{-- TAB: ĐƠN HÀNG --}}
            <div class="profile-tab {{ $active === 'orders' ? 'is-active' : '' }}" data-panel="orders">
                <div class="profile-panel">
                    <h5 class="profile-panel__title"><i class="fa-solid fa-bag-shopping"></i> Tất Cả Đơn Hàng</h5>
                    <div class="table-responsive">
                        <table class="profile-table">
                            <thead>
                                <tr><th>Mã đơn</th><th>Ngày đặt</th><th>Tổng tiền</th><th>Trạng thái</th><th>Chi tiết</th></tr>
                            </thead>
                            <tbody>
                                @forelse ($orders as $order)
                                    @php [$stLabel, $stClass] = $statusMap[$order->trang_thai_don_hang] ?? ['Đang xử lý', '']; @endphp
                                    <tr>
                                        <td class="order-code">{{ $order->ma_don_hang }}</td>
                                        <td>{{ optional($order->created_at)->format('d/m/Y') }}</td>
                                        <td class="order-total">{{ number_format($order->tong_tien) }}đ</td>
                                        <td><span class="order-status {{ $stClass }}">{{ $stLabel }}</span></td>
                                        <td><a href="{{ route('orders.show', $order->ma_don_hang) }}" class="order-view">Xem chi tiết <i class="fa-solid fa-eye"></i></a></td>
                                    </tr>
                                @empty
                                    <tr><td colspan="5" class="text-center text-secondary py-3">Chưa có đơn hàng nào.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            {{-- TAB: ĐỊA CHỈ --}}
            <div class="profile-tab {{ $active === 'address' ? 'is-active' : '' }}" data-panel="address">
                <div class="profile-panel">
                    <div class="profile-panel__head">
                        <h5 class="profile-panel__title m-0"><i class="fa-solid fa-location-dot"></i> Sổ Địa Chỉ</h5>
                    </div>
                    @forelse ($addresses as $addr)
                        <div class="address-card {{ $addr->is_mac_dinh ? 'address-card--default' : '' }}">
                            @if ($addr->is_mac_dinh)<span class="address-card__tag">Mặc định</span>@endif
                            <p class="address-card__name">{{ $addr->ten_nguoi_nhan }} — {{ $addr->loai_dia_chi ?? 'Nhà riêng' }}</p>
                            <p class="address-card__text">{{ $addr->dia_chi_cu_the }}, {{ $addr->phuong_xa }}, {{ $addr->quan_huyen }}, {{ $addr->tinh_thanh }}</p>
                            <p class="address-card__phone"><i class="fa-solid fa-phone"></i> {{ $addr->so_dien_thoai }}</p>
                            <div class="address-card__actions">
                                @unless ($addr->is_mac_dinh)
                                    <form action="{{ route('profile.addresses.default', $addr->id) }}" method="POST">
                                        @csrf @method('PATCH')
                                        <button class="profile-link" type="submit"><i class="fa-solid fa-star"></i> Đặt mặc định</button>
                                    </form>
                                @endunless
                                <form action="{{ route('profile.addresses.destroy', $addr->id) }}" method="POST" onsubmit="return confirm('Xóa địa chỉ này?')">
                                    @csrf @method('DELETE')
                                    <button class="profile-link profile-link--danger" type="submit"><i class="fa-solid fa-trash"></i> Xóa</button>
                                </form>
                            </div>
                        </div>
                    @empty
                        <p class="profile-address__text mb-4">Bạn chưa có địa chỉ nào. Thêm địa chỉ mới bên dưới.</p>
                    @endforelse

                    <h5 class="profile-panel__title mt-4"><i class="fa-solid fa-plus"></i> Thêm Địa Chỉ Mới</h5>
                    <form class="profile-form" action="{{ route('profile.addresses.store') }}" method="POST">
                        @csrf
                        <div class="row g-3">
                            <div class="col-md-6"><label class="profile-form__label">Người nhận</label><input type="text" name="ten_nguoi_nhan" class="profile-form__input" required></div>
                            <div class="col-md-6"><label class="profile-form__label">Số điện thoại</label><input type="text" name="so_dien_thoai" class="profile-form__input" required></div>
                            <div class="col-md-4"><label class="profile-form__label">Tỉnh / Thành</label><input type="text" name="tinh_thanh" class="profile-form__input" required></div>
                            <div class="col-md-4"><label class="profile-form__label">Quận / Huyện</label><input type="text" name="quan_huyen" class="profile-form__input" required></div>
                            <div class="col-md-4"><label class="profile-form__label">Phường / Xã</label><input type="text" name="phuong_xa" class="profile-form__input" required></div>
                            <div class="col-md-8"><label class="profile-form__label">Địa chỉ cụ thể</label><input type="text" name="dia_chi_cu_the" class="profile-form__input" required></div>
                            <div class="col-md-4"><label class="profile-form__label">Loại</label><input type="text" name="loai_dia_chi" class="profile-form__input" placeholder="Nhà riêng / Công ty"></div>
                            <div class="col-12"><button class="profile-btn profile-btn--primary" type="submit">LƯU ĐỊA CHỈ</button></div>
                        </div>
                    </form>
                </div>
            </div>

            {{-- TAB: WISHLIST --}}
            <div class="profile-tab {{ $active === 'wishlist' ? 'is-active' : '' }}" data-panel="wishlist">
                <div class="profile-panel">
                    <h5 class="profile-panel__title"><i class="fa-solid fa-heart"></i> Sản Phẩm Yêu Thích</h5>
                    <div class="wishlist-grid wishlist-grid--full">
                        @forelse ($wishlistItems as $item)
                            @if ($item->sanPham)
                            <div class="wishlist-card">
                                <form action="{{ route('wishlist.destroy', $item->id) }}" method="POST">
                                    @csrf @method('DELETE')
                                    <button class="wishlist-card__heart" type="submit"><i class="fa-solid fa-heart"></i></button>
                                </form>
                                <a href="{{ route('products.show', $item->sanPham->slug) }}" class="wishlist-card__img"><img src="{{ asset($item->sanPham->mainImagePath()) }}" alt="{{ $item->sanPham->ten }}"></a>
                                <div class="wishlist-card__body">
                                    <h6 class="wishlist-card__name">{{ $item->sanPham->ten }}</h6>
                                    <span class="wishlist-card__price">{{ $item->sanPham->formattedPrice() }}</span>
                                    <form action="{{ route('cart.add') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="san_pham_id" value="{{ $item->sanPham->id }}">
                                        <input type="hidden" name="so_luong" value="1">
                                        <button class="profile-btn profile-btn--outline w-100" type="submit">Thêm vào giỏ</button>
                                    </form>
                                </div>
                            </div>
                            @endif
                        @empty
                            <p class="text-secondary">Chưa có sản phẩm yêu thích. <a href="{{ route('products.index') }}">Khám phá sản phẩm</a>.</p>
                        @endforelse
                    </div>
                </div>
            </div>

            {{-- TAB: ĐỔI MẬT KHẨU --}}
            <div class="profile-tab {{ $active === 'password' ? 'is-active' : '' }}" data-panel="password">
                <div class="profile-panel">
                    <h5 class="profile-panel__title"><i class="fa-solid fa-lock"></i> Đổi Mật Khẩu</h5>
                    <form class="profile-form profile-form--narrow" action="{{ route('profile.password') }}" method="POST">
                        @csrf @method('PATCH')
                        <div class="mb-3">
                            <label class="profile-form__label">Mật khẩu hiện tại</label>
                            <input type="password" name="current_password" class="profile-form__input" placeholder="••••••••" required>
                            @error('current_password') <div class="auth-error-msg">{{ $message }}</div> @enderror
                        </div>
                        <div class="mb-3">
                            <label class="profile-form__label">Mật khẩu mới</label>
                            <input type="password" name="password" class="profile-form__input" placeholder="••••••••" required>
                            @error('password') <div class="auth-error-msg">{{ $message }}</div> @enderror
                        </div>
                        <div class="mb-3">
                            <label class="profile-form__label">Xác nhận mật khẩu mới</label>
                            <input type="password" name="password_confirmation" class="profile-form__input" placeholder="••••••••" required>
                        </div>
                        <button class="profile-btn profile-btn--primary" type="submit">CẬP NHẬT MẬT KHẨU</button>
                    </form>
                </div>
            </div>

        </section>
    </div>
</main>
@endsection
