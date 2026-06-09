{{-- Thanh trên cùng khu quản trị --}}
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
            <div class="admin-topbar__user-name">{{ auth()->user()->ho_ten ?? 'Admin YUKI' }}</div>
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
