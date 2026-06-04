@extends('layouts.store')

@section('title', '404 - SKT Gaming Store')

@push('styles')
<style>
    .notfound-page { min-height: 620px; display: grid; align-items: center; padding: 50px 0; }
    .notfound-shell { display: grid; grid-template-columns: minmax(0, .95fr) minmax(0, 1.05fr); gap: 28px; align-items: center; }
    .notfound-code { color: #ff315d; font-family: Orbitron, sans-serif; font-size: clamp(5rem, 18vw, 12rem); line-height: .85; text-shadow: 0 0 30px rgba(255,0,60,.24); }
    .notfound-title { color: #fff; font-family: Orbitron, sans-serif; font-size: clamp(2rem, 5vw, 4rem); margin: 14px 0; }
    .notfound-text { color: #cbd5e1; line-height: 1.75; max-width: 560px; }
    .notfound-actions { display: flex; flex-wrap: wrap; gap: 10px; margin-top: 20px; }
    .notfound-panel { border: 1px solid rgba(255,255,255,.08); background: rgba(12,14,20,.78); border-radius: 8px; padding: 18px; }
    .notfound-panel h2 { color: #fff; font-family: Orbitron, sans-serif; font-size: 1.15rem; margin-bottom: 14px; }
    .notfound-products { display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 12px; }
    .notfound-product { display: grid; grid-template-columns: 74px 1fr; gap: 10px; align-items: center; color: inherit; text-decoration: none; border: 1px solid rgba(255,255,255,.08); background: rgba(255,255,255,.035); border-radius: 8px; padding: 10px; }
    .notfound-product:hover { border-color: rgba(0,229,255,.32); }
    .notfound-product img { width: 74px; height: 74px; object-fit: cover; border-radius: 6px; }
    .notfound-product strong { display: block; color: #fff; font-size: .92rem; line-height: 1.35; }
    .notfound-product span { color: #ff6b88; font-weight: 800; font-size: .86rem; }
    @media (max-width: 992px) { .notfound-shell { grid-template-columns: 1fr; } }
    @media (max-width: 560px) { .notfound-products { grid-template-columns: 1fr; } }
</style>
@endpush

@section('content')
<main class="notfound-page container-fluid px-4 px-xl-5">
    <div class="notfound-shell">
        <section>
            <div class="notfound-code">404</div>
            <h1 class="notfound-title">Trang khong ton tai.</h1>
            <p class="notfound-text">Duong dan ban mo da bi doi, bi xoa hoac khong co trong SKT Gaming Store. Quay lai danh sach san pham de tiep tuc mua sam.</p>
            <div class="notfound-actions">
                <a class="store-btn" href="{{ route('home') }}"><i class="fa-solid fa-house"></i> Trang chu</a>
                <a class="store-btn store-btn--ghost" href="{{ route('products.index') }}"><i class="fa-solid fa-bag-shopping"></i> San pham</a>
                <a class="store-btn store-btn--ghost" href="{{ route('static.contact') }}"><i class="fa-solid fa-headset"></i> Lien he</a>
            </div>
        </section>

        <aside class="notfound-panel">
            <h2>San pham goi y</h2>
            <div class="notfound-products">
                @forelse ($suggestedProducts ?? collect() as $product)
                    <a class="notfound-product" href="{{ route('products.show', $product) }}">
                        <img src="{{ asset($product->mainImagePath()) }}" alt="{{ $product->ten }}">
                        <div>
                            <strong>{{ $product->ten }}</strong>
                            <span>{{ $product->formattedPrice() }}</span>
                        </div>
                    </a>
                @empty
                    <a class="notfound-product" href="{{ route('products.index') }}">
                        <img src="{{ asset('assets/images/library/logo.png') }}" alt="SKT Gaming">
                        <div>
                            <strong>Kho gear SKT</strong>
                            <span>Xem ngay</span>
                        </div>
                    </a>
                @endforelse
            </div>
        </aside>
    </div>
</main>
@endsection
