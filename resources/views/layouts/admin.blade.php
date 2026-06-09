<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'YUKI Admin')</title>

    <x-admin.head-assets />
</head>

<body class="admin-body">
<div class="admin-layout">

    <x-admin.sidebar />

    <div class="admin-main">

        <x-admin.topbar />

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

<x-admin.foot-scripts />

</body>
</html>
