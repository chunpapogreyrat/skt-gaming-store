<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'YUKI Gaming Store - Đỉnh Cao Trải Nghiệm')</title>

    <x-head-assets />
</head>

<body class="dark-theme">

    {{-- Các thành phần dùng chung — tách thành Blade Component (resources/views/components/) --}}
    <x-announcement-bar />
    <x-navbar />

    @yield('content')

    <x-site-footer />
    <x-search-overlay />
    <x-cart-drawer :items="$cartDrawerItems ?? []" :total="$cartDrawerTotal ?? 0" :count="$cartDrawerCount ?? 0" />
    <x-confirm-modal />
    <x-cart-scripts />

    <x-foot-scripts />

</body>
</html>
