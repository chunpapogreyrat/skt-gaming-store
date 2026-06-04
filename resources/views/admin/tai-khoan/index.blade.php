@extends('layouts.admin')

@section('title', 'Quản lý tài khoản - SKT Admin')
@section('nav-users', 'is-active')

@section('content')
<h1 class="admin-page-title">Quản lý tài khoản</h1>
<p class="admin-page-sub">{{ $taiKhoans->total() }} tài khoản</p>

<section class="admin-table-wrap">
    <div class="admin-table-wrap__head">
        <h3 class="admin-panel__title">Danh sách tài khoản</h3>
        <form method="GET">
            <select name="role" class="admin-status-select" onchange="this.form.submit()">
                <option value="">Tất cả vai trò</option>
                <option value="user" @selected(request('role')=='user')>Khách hàng</option>
                <option value="admin" @selected(request('role')=='admin')>Quản trị viên</option>
            </select>
        </form>
    </div>
    <table class="admin-table">
        <thead><tr><th>Người dùng</th><th>Email</th><th>SĐT</th><th>Vai trò</th><th>Trạng thái</th><th>Thao tác</th></tr></thead>
        <tbody>
            @forelse($taiKhoans as $tk)
            <tr class="admin-table__row">
                <td><div class="admin-table__product">
                    <img class="admin-table__thumb" style="border-radius:50%" src="{{ $tk->avatar ? asset('assets/images/users/'.$tk->avatar) : asset('assets/images/avatars/truong.jpg') }}" alt="">
                    <div class="admin-table__name">{{ $tk->ho_ten }}</div>
                </div></td>
                <td>{{ $tk->email }}</td>
                <td>{{ $tk->so_dien_thoai ?? '—' }}</td>
                <td><span class="admin-badge admin-badge--{{ $tk->role=='admin'?'cancel':'prep' }}">{{ $tk->role=='admin'?'Admin':'Khách' }}</span></td>
                <td><span class="admin-badge admin-badge--{{ ($tk->is_active ?? true)?'done':'stock-out' }}">{{ ($tk->is_active ?? true)?'Hoạt động':'Đã khóa' }}</span></td>
                <td>
                    <form method="POST" action="{{ route('admin.users.status', $tk->id) }}">
                        @csrf @method('PUT')
                        <button class="admin-icon-btn admin-icon-btn--danger" title="Đổi trạng thái"><i class="fa-solid fa-{{ ($tk->is_active ?? true)?'ban':'unlock' }}"></i></button>
                    </form>
                </td>
            </tr>
            @empty
            <tr class="admin-table__row"><td colspan="6" class="admin-table__muted">Không có tài khoản</td></tr>
            @endforelse
        </tbody>
    </table>
    <div class="admin-pagination">{{ $taiKhoans->links() }}</div>
</section>
@endsection
