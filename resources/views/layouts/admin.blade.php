<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'SKT Admin')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;500;700;900&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/admin.css') }}">
    @stack('styles')
</head>

<body class="admin-body">
<div class="admin-layout">

    {{-- #region ADMIN SIDEBAR --}}
    <aside class="admin-sidebar" id="adminSidebar">
        <div class="admin-sidebar__brand">
            <span class="admin-sidebar__brand-skt">SKT</span> ADMIN
            <span class="admin-sidebar__badge">v2.0</span>
        </div>
        <nav class="admin-sidebar__nav">
            <p class="admin-sidebar__label">Tổng quan</p>
            <a href="{{ route('admin.dashboard') }}" class="admin-sidebar__link @yield('nav-dashboard')"><i class="fa-solid fa-gauge-high"></i> Dashboard</a>
            <p class="admin-sidebar__label">Quản lý</p>
            <a href="{{ route('admin.products.index') }}" class="admin-sidebar__link @yield('nav-products')"><i class="fa-solid fa-box"></i> Sản phẩm</a>
            <a href="{{ route('admin.orders.index') }}" class="admin-sidebar__link @yield('nav-orders')"><i class="fa-solid fa-receipt"></i> Đơn hàng</a>
            <a href="{{ route('admin.users.index') }}" class="admin-sidebar__link @yield('nav-users')"><i class="fa-solid fa-users"></i> Tài khoản</a>
            <a href="{{ route('admin.coupons.index') }}" class="admin-sidebar__link @yield('nav-coupons')"><i class="fa-solid fa-ticket"></i> Mã giảm giá</a>
            <a href="{{ route('admin.setups.index') }}" class="admin-sidebar__link @yield('nav-setups')"><i class="fa-solid fa-display"></i> Setup trưng bày</a>
        </nav>
        <div class="admin-sidebar__foot">
            <a href="{{ route('home') }}" class="admin-sidebar__link"><i class="fa-solid fa-arrow-left"></i> Về cửa hàng</a>
        </div>
    </aside>
    {{-- #endregion --}}

    <div class="admin-main">

        {{-- #region ADMIN TOPBAR --}}
        <header class="admin-topbar">
            <button class="admin-topbar__toggle" id="sidebarToggle"><i class="fa-solid fa-bars"></i></button>
            <div class="admin-topbar__search">
                <i class="fa-solid fa-magnifying-glass"></i>
                <input type="text" placeholder="Tìm kiếm...">
            </div>
            <div class="admin-topbar__spacer"></div>
            <button class="admin-topbar__icon-btn"><i class="fa-regular fa-bell"></i><span class="admin-topbar__dot"></span></button>
            <div class="admin-topbar__user">
                <img class="admin-topbar__avatar" src="{{ asset('assets/images/avatars/truong.jpg') }}" alt="Admin">
                <div>
                    <div class="admin-topbar__user-name">{{ auth()->user()->ho_ten ?? 'Admin SKT' }}</div>
                    <div class="admin-topbar__user-role">Quản trị viên</div>
                </div>
                <form action="{{ route('logout') }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="admin-topbar__logout" title="Đăng xuất" style="background:none;border:none;">
                        <i class="fa-solid fa-right-from-bracket"></i>
                    </button>
                </form>
            </div>
        </header>
        {{-- #endregion --}}

        <main class="admin-content">
            @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            @yield('content')
        </main>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.getElementById('sidebarToggle')?.addEventListener('click', function () {
        document.getElementById('adminSidebar').classList.toggle('is-open');
    });
</script>
@stack('scripts')
</body>

</html>
