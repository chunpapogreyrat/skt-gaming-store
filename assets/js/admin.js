/* ==========================================
   SKT ADMIN — shared JS
   Sidebar toggle + user dropdown menu
========================================== */
(function () {
    'use strict';

    /* ----- Sidebar toggle ----- */
    var toggle = document.getElementById('sidebarToggle');
    if (toggle) {
        toggle.addEventListener('click', function () {
            var sb = document.getElementById('adminSidebar');
            if (sb) sb.classList.toggle('is-open');
        });
    }

    /* ----- User dropdown ----- */
    var userBox = document.querySelector('.admin-topbar__user');
    if (!userBox) return;

    // Lấy thông tin sẵn có
    var avatarEl = userBox.querySelector('.admin-topbar__avatar');
    var nameEl   = userBox.querySelector('.admin-topbar__user-name');
    var roleEl   = userBox.querySelector('.admin-topbar__user-role');
    var avatar = avatarEl ? avatarEl.getAttribute('src') : '../assets/images/avatars/truong.jpg';
    var name   = nameEl ? nameEl.textContent.trim() : 'Admin SKT';
    var role   = roleEl ? roleEl.textContent.trim() : 'Quản trị viên';

    // Biến userBox thành trigger có thể bấm
    userBox.classList.add('admin-user-menu');
    userBox.style.cursor = 'pointer';

    // Thêm mũi tên
    var caret = document.createElement('i');
    caret.className = 'fa-solid fa-chevron-down admin-user-menu__caret';
    userBox.appendChild(caret);

    // Tạo panel
    var panel = document.createElement('div');
    panel.className = 'admin-user-menu__panel';
    panel.innerHTML =
        '<div class="admin-user-menu__head">' +
            '<img class="admin-user-menu__avatar" src="' + avatar + '" alt="">' +
            '<div>' +
                '<div class="admin-user-menu__name">' + name + '</div>' +
                '<div class="admin-user-menu__role"><i class="fa-solid fa-shield-halved"></i> ' + role + '</div>' +
            '</div>' +
        '</div>' +
        '<a href="dashboard.html" class="admin-user-menu__profile-btn"><i class="fa-solid fa-gauge-high"></i> Về Dashboard</a>' +
        '<div class="admin-user-menu__divider"></div>' +
        '<a href="../profile.html" class="admin-user-menu__item"><span class="admin-user-menu__ico"><i class="fa-solid fa-id-badge"></i></span> Hồ sơ cá nhân <i class="fa-solid fa-chevron-right admin-user-menu__arr"></i></a>' +
        '<a href="revenue.html" class="admin-user-menu__item"><span class="admin-user-menu__ico"><i class="fa-solid fa-chart-line"></i></span> Báo cáo doanh thu <i class="fa-solid fa-chevron-right admin-user-menu__arr"></i></a>' +
        '<a href="#" class="admin-user-menu__item"><span class="admin-user-menu__ico"><i class="fa-solid fa-gear"></i></span> Cài đặt hệ thống <i class="fa-solid fa-chevron-right admin-user-menu__arr"></i></a>' +
        '<a href="#" class="admin-user-menu__item"><span class="admin-user-menu__ico"><i class="fa-solid fa-moon"></i></span> Giao diện & trợ năng <i class="fa-solid fa-chevron-right admin-user-menu__arr"></i></a>' +
        '<div class="admin-user-menu__divider"></div>' +
        '<a href="../login.html" class="admin-user-menu__item admin-user-menu__item--logout"><span class="admin-user-menu__ico"><i class="fa-solid fa-right-from-bracket"></i></span> Đăng xuất</a>' +
        '<div class="admin-user-menu__foot">SKT Admin Panel · v2.0</div>';
    userBox.appendChild(panel);

    // Bỏ link logout cũ (đã có trong panel)
    var oldLogout = userBox.querySelector('.admin-topbar__logout');
    if (oldLogout) oldLogout.style.display = 'none';

    // Toggle
    userBox.addEventListener('click', function (e) {
        if (e.target.closest('.admin-user-menu__panel')) return; // bấm trong panel thì không toggle
        e.stopPropagation();
        userBox.classList.toggle('is-open');
    });
    document.addEventListener('click', function (e) {
        if (!userBox.contains(e.target)) userBox.classList.remove('is-open');
    });
    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') userBox.classList.remove('is-open');
    });
})();
