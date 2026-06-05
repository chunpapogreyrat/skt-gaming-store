@extends('layouts.app')

@section('title', 'Gioi thieu - SKT Gaming Store')

@push('styles')
<style>
    .static-hero { min-height: 440px; display: grid; align-items: end; padding: 56px 0; background: linear-gradient(180deg, rgba(5,7,12,.25), rgba(5,7,12,.92)), url("{{ asset('assets/images/slider/1.jpg') }}") center/cover no-repeat; }
    .static-hero__eyebrow { color: #67e8f9; font-weight: 800; letter-spacing: .08em; text-transform: uppercase; }
    .static-hero__title { max-width: 760px; color: #fff; font-family: Orbitron, sans-serif; font-size: clamp(2.1rem, 5vw, 4.8rem); line-height: 1.02; margin: 10px 0 14px; }
    .static-hero__text { max-width: 680px; color: #cbd5e1; font-size: 1.04rem; }
    .static-band { padding: 58px 0; }
    .static-title { color: #fff; font-family: Orbitron, sans-serif; font-size: 1.8rem; margin-bottom: 16px; }
    .static-copy { color: #94a3b8; line-height: 1.8; }
    .static-stats { display: grid; grid-template-columns: repeat(3, minmax(0, 1fr)); gap: 14px; }
    .static-stat { border: 1px solid rgba(255,255,255,.08); background: rgba(12,14,20,.76); border-radius: 8px; padding: 20px; }
    .static-stat strong { display: block; color: #fff; font-size: 2rem; font-family: Orbitron, sans-serif; }
    .static-stat span { color: #94a3b8; text-transform: uppercase; font-size: .78rem; letter-spacing: .05em; }
    .static-values { display: grid; grid-template-columns: repeat(4, minmax(0, 1fr)); gap: 14px; }
    .static-value { border: 1px solid rgba(255,255,255,.08); background: rgba(255,255,255,.035); border-radius: 8px; padding: 18px; }
    .static-value i { color: #ff315d; font-size: 1.35rem; margin-bottom: 12px; }
    .static-value h3 { color: #fff; font-size: 1rem; margin-bottom: 8px; }
    .static-value p { color: #94a3b8; margin: 0; font-size: .92rem; line-height: 1.65; }
    .static-split { display: grid; grid-template-columns: 1fr 1fr; gap: 24px; align-items: center; }
    .static-split img { width: 100%; aspect-ratio: 16/10; object-fit: cover; border-radius: 8px; border: 1px solid rgba(255,255,255,.08); }
    @media (max-width: 992px) { .static-values { grid-template-columns: repeat(2, minmax(0, 1fr)); } .static-split { grid-template-columns: 1fr; } }
    @media (max-width: 640px) { .static-stats, .static-values { grid-template-columns: 1fr; } .static-hero { min-height: 360px; } }
</style>
@endpush

@section('content')
<section class="static-hero">
    <div class="container-fluid px-4 px-xl-5">
        <span class="static-hero__eyebrow">SKT Gaming Store</span>
        <h1 class="static-hero__title">Gear chuan thi dau cho ban gaming nghiem tuc.</h1>
        <p class="static-hero__text">SKT tap trung vao chuot, ban phim, lot chuot, man hinh va phu kien co hieu nang that, phu hop ca FPS lan setup lam viec hang ngay.</p>
        <a class="store-btn mt-3" href="{{ route('products.index') }}"><i class="fa-solid fa-bag-shopping"></i> Xem san pham</a>
    </div>
</section>

<main class="container-fluid px-4 px-xl-5">
    <section class="static-band">
        <div class="static-split">
            <div>
                <h2 class="static-title">Chon gear bang trai nghiem, khong chay theo ten goi.</h2>
                <p class="static-copy">Moi san pham trong store duoc sap xep theo nhu cau thuc te: FPS, tracking, click latency, switch feel, control/speed surface va do ben. Muc tieu la giup nguoi dung tim dung mon do nhanh hon, it phai doi tra hon.</p>
                <p class="static-copy">Store uu tien hang co thong so ro rang, hinh anh day du va mo ta ngan gon de ban co the so sanh truc tiep trong danh sach san pham.</p>
            </div>
            <img src="{{ asset('assets/images/banners/keyboard-banner.jpg') }}" alt="Gaming keyboard banner">
        </div>
    </section>

    <section class="static-band pt-0">
        <div class="static-stats">
            <div class="static-stat"><strong>{{ $stats['products'] }}</strong><span>San pham active</span></div>
            <div class="static-stat"><strong>{{ $stats['hotProducts'] }}</strong><span>Dang ban chay</span></div>
            <div class="static-stat"><strong>{{ $stats['saleProducts'] }}</strong><span>Dang sale</span></div>
        </div>
    </section>

    <section class="static-band pt-0">
        <h2 class="static-title">Gia tri van hanh</h2>
        <div class="static-values">
            <div class="static-value">
                <i class="fa-solid fa-gauge-high"></i>
                <h3>Hieu nang</h3>
                <p>Uu tien latency, cam giac bam, trong luong va do on dinh khi dung lau.</p>
            </div>
            <div class="static-value">
                <i class="fa-solid fa-layer-group"></i>
                <h3>Lua chon ro rang</h3>
                <p>Danh muc, filter, sort va tag sale/hot giup so sanh nhanh hon.</p>
            </div>
            <div class="static-value">
                <i class="fa-solid fa-shield-halved"></i>
                <h3>Hang chinh hang</h3>
                <p>Tap trung vao san pham co nguon goc, hinh anh va cau hinh minh bach.</p>
            </div>
            <div class="static-value">
                <i class="fa-solid fa-headset"></i>
                <h3>Ho tro setup</h3>
                <p>Goi y combo theo phong cach ban choi va khong gian ban dang co.</p>
            </div>
        </div>
    </section>
</main>
@endsection
