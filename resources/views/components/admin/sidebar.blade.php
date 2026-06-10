{{-- Sidebar khu quản trị --}}
<aside class="admin-sidebar" id="adminSidebar">
    <div class="admin-sidebar__brand">
        <span class="admin-sidebar__brand-yuki">YUKI</span> ADMIN
        <span class="admin-sidebar__badge">v2.0</span>
    </div>
    <nav class="admin-sidebar__nav">
        <p class="admin-sidebar__label">Tổng quan</p>
        <a href="{{ route('admin.dashboard') }}" class="admin-sidebar__link @yield('nav-dashboard')"><i class="fa-solid fa-gauge-high"></i> Dashboard</a>
        <a href="{{ route('admin.revenue') }}" class="admin-sidebar__link @yield('nav-revenue')"><i class="fa-solid fa-chart-line"></i> Doanh thu</a>
        <p class="admin-sidebar__label">Quản lý</p>
        <a href="{{ route('admin.categories.index') }}" class="admin-sidebar__link @yield('nav-categories')"><i class="fa-solid fa-layer-group"></i> Danh mục</a>
        <a href="{{ route('admin.products.index') }}" class="admin-sidebar__link @yield('nav-products')"><i class="fa-solid fa-box"></i> Sản phẩm</a>
        <a href="{{ route('admin.orders.index') }}" class="admin-sidebar__link @yield('nav-orders')"><i class="fa-solid fa-receipt"></i> Đơn hàng</a>
        <a href="{{ route('admin.users.index') }}" class="admin-sidebar__link @yield('nav-users')"><i class="fa-solid fa-users"></i> Tài khoản</a>
        <a href="{{ route('admin.coupons.index') }}" class="admin-sidebar__link @yield('nav-coupons')"><i class="fa-solid fa-ticket"></i> Mã giảm giá</a>
        <a href="{{ route('admin.suppliers.index') }}" class="admin-sidebar__link @yield('nav-suppliers')"><i class="fa-solid fa-truck-ramp-box"></i> Nhà phân phối</a>
        <a href="{{ route('admin.contacts.index') }}" class="admin-sidebar__link @yield('nav-contacts')"><i class="fa-solid fa-envelope-open-text"></i> Liên hệ</a>
        <a href="{{ route('admin.setups.index') }}" class="admin-sidebar__link @yield('nav-setups')"><i class="fa-solid fa-display"></i> Setup trưng bày</a>
    </nav>
    <div class="admin-sidebar__foot">
        <a href="{{ route('home') }}" class="admin-sidebar__link"><i class="fa-solid fa-arrow-left"></i> Về cửa hàng</a>
    </div>
</aside>
