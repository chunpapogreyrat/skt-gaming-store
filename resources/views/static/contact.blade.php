@extends('layouts.app')

@section('title', 'Lien he - YUKI Gaming Store')

@push('styles')
<style>
    .contact-page { padding: 34px 0 58px; }
    .contact-head { display: grid; grid-template-columns: 1fr 420px; gap: 24px; align-items: stretch; margin-bottom: 24px; }
    .contact-hero { border: 1px solid rgba(255,255,255,.08); background: rgba(12,14,20,.78); border-radius: 8px; padding: 28px; display: flex; flex-direction: column; justify-content: center; }
    .contact-hero h1 { color: #fff; font-family: Orbitron, sans-serif; font-size: clamp(2rem, 5vw, 4rem); margin: 0 0 12px; }
    .contact-hero p { color: #cbd5e1; max-width: 680px; line-height: 1.75; margin: 0; }
    .contact-media { border-radius: 8px; overflow: hidden; border: 1px solid rgba(255,255,255,.08); min-height: 280px; }
    .contact-media img { width: 100%; height: 100%; object-fit: cover; }
    .contact-grid { display: grid; grid-template-columns: 360px 1fr; gap: 20px; }
    .contact-card { border: 1px solid rgba(255,255,255,.08); background: rgba(12,14,20,.78); border-radius: 8px; padding: 20px; }
    .contact-card h2 { color: #fff; font-family: Orbitron, sans-serif; font-size: 1.15rem; margin-bottom: 16px; }
    .contact-method { display: flex; gap: 12px; padding: 14px 0; border-bottom: 1px solid rgba(255,255,255,.08); color: #cbd5e1; }
    .contact-method:last-child { border-bottom: 0; }
    .contact-method i { color: #67e8f9; font-size: 1.15rem; padding-top: 3px; }
    .contact-method strong { display: block; color: #fff; margin-bottom: 4px; }
    .contact-form { display: grid; gap: 12px; }
    .contact-form__row { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; }
    .contact-form input, .contact-form textarea, .contact-form select { width: 100%; background: rgba(10,12,16,.8); border: 1px solid rgba(255,255,255,.1); border-radius: 8px; color: #fff; padding: 11px 12px; outline: none; }
    .contact-form textarea { min-height: 160px; resize: vertical; }
    .contact-form input:focus, .contact-form textarea:focus, .contact-form select:focus { border-color: #ff315d; }
    .contact-map { margin-top: 20px; border: 1px solid rgba(255,255,255,.08); background: rgba(255,255,255,.035); border-radius: 8px; min-height: 180px; display: grid; place-items: center; color: #94a3b8; text-align: center; padding: 24px; }
    @media (max-width: 992px) { .contact-head, .contact-grid { grid-template-columns: 1fr; } }
    @media (max-width: 640px) { .contact-form__row { grid-template-columns: 1fr; } }
</style>
@endpush

@section('content')
<nav class="breadcrumb-bar container-fluid px-4 px-xl-5">
    <ol class="breadcrumb-bar__list">
        <li><a href="{{ route('home') }}"><i class="fa-solid fa-house"></i> Trang chu</a></li>
        <li class="breadcrumb-bar__active">Lien he</li>
    </ol>
</nav>

<main class="contact-page container-fluid px-4 px-xl-5">
    <section class="contact-head">
        <div class="contact-hero">
            <h1>Lien he SKT</h1>
            <p>Can tu van gear, kiem tra ton kho, bao hanh hoac build setup? Gui thong tin cho team SKT, chung toi se phan hoi trong gio lam viec.</p>
        </div>
        <div class="contact-media">
            <img src="{{ asset('assets/images/banners/mouse-banner.jpg') }}" alt="Gaming mouse banner">
        </div>
    </section>

    <section class="contact-grid">
        <aside class="contact-card">
            <h2>Kenh ho tro</h2>
            <div class="contact-method">
                <i class="fa-solid fa-phone"></i>
                <div><strong>Hotline</strong><span>0900 000 000</span></div>
            </div>
            <div class="contact-method">
                <i class="fa-solid fa-envelope"></i>
                <div><strong>Email</strong><span>support@skt-gaming.test</span></div>
            </div>
            <div class="contact-method">
                <i class="fa-solid fa-location-dot"></i>
                <div><strong>Showroom</strong><span>Quan 1, TP HCM</span></div>
            </div>
            <div class="contact-method">
                <i class="fa-solid fa-clock"></i>
                <div><strong>Gio lam viec</strong><span>09:00 - 21:00, Thu 2 - Chu nhat</span></div>
            </div>
        </aside>

        <div class="contact-card">
            <h2>Gui yeu cau</h2>
            <form class="contact-form" action="mailto:support@skt-gaming.test" method="GET">
                <div class="contact-form__row">
                    <input type="text" name="name" placeholder="Ho ten" required>
                    <input type="email" name="email" placeholder="Email" required>
                </div>
                <div class="contact-form__row">
                    <input type="text" name="phone" placeholder="So dien thoai">
                    <select name="topic">
                        <option value="tu-van">Tu van san pham</option>
                        <option value="bao-hanh">Bao hanh</option>
                        <option value="setup">Build setup</option>
                    </select>
                </div>
                <textarea name="body" placeholder="Noi dung can ho tro" required></textarea>
                <button class="store-btn" type="submit"><i class="fa-solid fa-paper-plane"></i> Gui lien he</button>
            </form>
            <div class="contact-map">
                <div>
                    <i class="fa-solid fa-map-location-dot fa-2x mb-2"></i>
                    <div>YUKI Gaming Store · Quan 1 · TP HCM</div>
                </div>
            </div>
        </div>
    </section>
</main>
@endsection
