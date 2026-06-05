@extends('layouts.app')

@section('title', 'Setups gaming - SKT Gaming Store')

@push('styles')
<style>
    .setups-page { padding: 34px 0 58px; }
    .setups-head { display: grid; grid-template-columns: minmax(0, 1fr) 320px; gap: 20px; align-items: end; margin-bottom: 24px; }
    .setups-head h1 { color: #fff; font-family: Orbitron, sans-serif; font-size: clamp(2.2rem, 5vw, 4.2rem); margin: 0 0 10px; }
    .setups-head p { color: #cbd5e1; line-height: 1.75; margin: 0; max-width: 760px; }
    .setups-filter { border: 1px solid rgba(255,255,255,.08); background: rgba(12,14,20,.78); border-radius: 8px; padding: 14px; display: grid; gap: 10px; }
    .setups-filter a { color: #cbd5e1; text-decoration: none; border-radius: 6px; padding: 9px 10px; display: flex; justify-content: space-between; gap: 10px; }
    .setups-filter a:hover { color: #fff; background: rgba(255,0,60,.14); }
    .setups-grid { display: grid; grid-template-columns: repeat(3, minmax(0, 1fr)); gap: 18px; }
    .setup-card { position: relative; min-height: 360px; overflow: hidden; border-radius: 8px; border: 1px solid rgba(255,255,255,.08); background: #090b10; }
    .setup-card img { width: 100%; height: 100%; min-height: 360px; object-fit: cover; transition: transform .35s ease; }
    .setup-card:hover img { transform: scale(1.04); }
    .setup-card__body { position: absolute; inset: auto 0 0; padding: 18px; background: linear-gradient(180deg, rgba(5,7,12,0), rgba(5,7,12,.92)); }
    .setup-card__tag { display: inline-flex; align-items: center; gap: 6px; color: #67e8f9; background: rgba(0,229,255,.12); border: 1px solid rgba(0,229,255,.18); border-radius: 999px; padding: 5px 9px; font-size: .78rem; font-weight: 800; margin-bottom: 10px; }
    .setup-card__title { color: #fff; font-family: Orbitron, sans-serif; font-size: 1.2rem; margin: 0 0 8px; }
    .setup-card__text { color: #cbd5e1; margin: 0 0 12px; font-size: .92rem; line-height: 1.55; }
    .setups-cta { margin-top: 24px; display: grid; grid-template-columns: 1fr auto; gap: 16px; align-items: center; border: 1px solid rgba(255,255,255,.08); background: rgba(12,14,20,.78); border-radius: 8px; padding: 20px; }
    .setups-cta h2 { color: #fff; font-family: Orbitron, sans-serif; font-size: 1.25rem; margin: 0 0 6px; }
    .setups-cta p { color: #94a3b8; margin: 0; }
    @media (max-width: 1100px) { .setups-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); } .setups-head { grid-template-columns: 1fr; } }
    @media (max-width: 680px) { .setups-grid, .setups-cta { grid-template-columns: 1fr; } .setup-card, .setup-card img { min-height: 300px; } }
</style>
@endpush

@section('content')
<nav class="breadcrumb-bar container-fluid px-4 px-xl-5">
    <ol class="breadcrumb-bar__list">
        <li><a href="{{ route('home') }}"><i class="fa-solid fa-house"></i> Trang chu</a></li>
        <li class="breadcrumb-bar__active">Setups</li>
    </ol>
</nav>

<main class="setups-page container-fluid px-4 px-xl-5">
    <section class="setups-head">
        <div>
            <h1>Setups gaming</h1>
            <p>Cac goc may duoc chon theo phong cach va muc dich su dung: FPS, lam viec, stream, minimal desk hoac white build.</p>
        </div>
        <div class="setups-filter">
            <a href="{{ route('products.index', ['category' => 'mice']) }}"><span>Chuot gaming</span><i class="fa-solid fa-arrow-right"></i></a>
            <a href="{{ route('products.index', ['category' => 'keyboard']) }}"><span>Ban phim co</span><i class="fa-solid fa-arrow-right"></i></a>
            <a href="{{ route('products.index', ['category' => 'mousepad']) }}"><span>Lot chuot</span><i class="fa-solid fa-arrow-right"></i></a>
        </div>
    </section>

    <section class="setups-grid">
        @foreach ($setups as $setup)
            @php
                $title = data_get($setup, 'tieu_de', 'Gaming setup');
                $category = data_get($setup, 'danh_muc', 'other');
                $image = data_get($setup, 'hinh_anh', 'assets/images/setups/setup-1.jpg');
                $label = ucwords(str_replace('_', ' ', $category));
            @endphp
            <article class="setup-card" id="setup-{{ data_get($setup, 'thu_tu', $loop->iteration) }}">
                <img src="{{ asset($image) }}" alt="{{ $title }}">
                <div class="setup-card__body">
                    <span class="setup-card__tag"><i class="fa-solid fa-desktop"></i> {{ $label }}</span>
                    <h2 class="setup-card__title">{{ $title }}</h2>
                    <p class="setup-card__text">Goi y combo theo mau sac, khong gian ban va nhom gear dang co san trong store.</p>
                    <a class="store-btn store-btn--ghost" href="{{ route('products.index') }}">Xem gear</a>
                </div>
            </article>
        @endforeach
    </section>

    <section class="setups-cta">
        <div>
            <h2>Can build setup rieng?</h2>
            <p>Gui phong cach, ngan sach va game ban choi de SKT goi y combo phu hop.</p>
        </div>
        <a class="store-btn" href="{{ route('static.contact') }}"><i class="fa-solid fa-headset"></i> Lien he tu van</a>
    </section>
</main>
@endsection
