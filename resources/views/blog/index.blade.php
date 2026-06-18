@extends('layouts.app')

@section('title', 'Góc Game Thủ - Blog YUKI Gaming Store')

@php
    // Màu nhấn theo danh mục (chip)
    $catColors = [
        'setup'     => '#22d3ee',
        'review'    => '#fbbf24',
        'huong-dan' => '#34d399',
        'tin-tuc'   => '#ff2d55',
        'esports'   => '#a855f7',
    ];
    $catIcons = [
        'setup'     => 'fa-desktop',
        'review'    => 'fa-star',
        'huong-dan' => 'fa-book-open',
        'tin-tuc'   => 'fa-bolt',
        'esports'   => 'fa-trophy',
    ];
@endphp

@push('styles')
<style>
    .blog-wrap { padding: 30px 0 64px; }

    /* HERO HEADER */
    .blog-hero { position: relative; border-radius: 18px; overflow: hidden; padding: 48px 38px; margin-bottom: 30px;
        background: radial-gradient(1200px 400px at 12% -10%, rgba(255,45,85,.22), transparent 60%),
                    radial-gradient(900px 380px at 95% 120%, rgba(168,85,247,.18), transparent 55%),
                    linear-gradient(135deg, #0c0e15, #14101a 60%, #0b0d13);
        border: 1px solid rgba(255,255,255,.08); }
    .blog-hero::after { content:''; position:absolute; inset:0; background-image:
        linear-gradient(rgba(255,255,255,.035) 1px, transparent 1px),
        linear-gradient(90deg, rgba(255,255,255,.035) 1px, transparent 1px);
        background-size: 38px 38px; mask: radial-gradient(60% 120% at 50% 0%, #000, transparent); pointer-events:none; }
    .blog-hero__eyebrow { display:inline-flex; align-items:center; gap:8px; color:#ff8fa3; font-weight:800; letter-spacing:.14em; text-transform:uppercase; font-size:.74rem; margin-bottom:14px; }
    .blog-hero__eyebrow i { color: var(--red, #ff2d55); }
    .blog-hero h1 { color:#fff; font-family:Orbitron, sans-serif; font-weight:800; font-size:clamp(2.1rem, 5vw, 3.6rem); line-height:1.05; margin:0 0 14px; }
    .blog-hero h1 span { background:linear-gradient(90deg,#ff2d55,#a855f7); -webkit-background-clip:text; background-clip:text; -webkit-text-fill-color:transparent; }
    .blog-hero p { color:#c4cbd6; max-width:640px; line-height:1.75; margin:0 0 24px; }
    .blog-search { display:flex; gap:10px; max-width:520px; position:relative; z-index:1; }
    .blog-search input { flex:1; background:rgba(0,0,0,.4); border:1px solid rgba(255,255,255,.14); border-radius:12px; padding:13px 16px; color:#fff; font-size:.95rem; outline:none; transition:.2s; }
    .blog-search input:focus { border-color:var(--red,#ff2d55); box-shadow:0 0 0 3px rgba(255,45,85,.16); }
    .blog-search button { background:linear-gradient(135deg,#ff2d55,#c81e44); border:0; border-radius:12px; color:#fff; padding:0 20px; font-weight:700; cursor:pointer; transition:.2s; }
    .blog-search button:hover { filter:brightness(1.1); }

    /* CHIP LỌC */
    .blog-cats { display:flex; flex-wrap:wrap; gap:10px; margin-bottom:26px; }
    .blog-chip { display:inline-flex; align-items:center; gap:8px; padding:9px 16px; border-radius:999px; text-decoration:none;
        border:1px solid rgba(255,255,255,.12); background:rgba(255,255,255,.03); color:#cbd5e1; font-weight:600; font-size:.86rem; transition:.18s; }
    .blog-chip:hover { color:#fff; border-color:rgba(255,255,255,.3); transform:translateY(-1px); }
    .blog-chip.is-active { background:#fff; color:#0b0d13; border-color:#fff; }
    .blog-chip__count { font-size:.72rem; opacity:.7; }

    /* FEATURED */
    .blog-featured { display:grid; grid-template-columns:1.15fr .85fr; gap:0; border-radius:18px; overflow:hidden; margin-bottom:36px;
        border:1px solid rgba(255,255,255,.08); background:#0c0e15; }
    .blog-featured__media { position:relative; min-height:380px; }
    .blog-featured__media img { width:100%; height:100%; object-fit:cover; }
    .blog-featured__media::after { content:''; position:absolute; inset:0; background:linear-gradient(90deg, transparent 55%, #0c0e15); }
    .blog-featured__body { padding:38px 40px; display:flex; flex-direction:column; justify-content:center; }
    .blog-featured__flag { display:inline-flex; align-items:center; gap:7px; align-self:flex-start; color:#ff2d55; font-weight:800; text-transform:uppercase; letter-spacing:.1em; font-size:.72rem; margin-bottom:16px; }
    .blog-featured__title { color:#fff; font-family:Orbitron, sans-serif; font-size:clamp(1.5rem,2.6vw,2.2rem); line-height:1.18; margin:0 0 16px; }
    .blog-featured__title a { color:inherit; text-decoration:none; }
    .blog-featured__title a:hover { color:#ff8fa3; }
    .blog-featured__excerpt { color:#aeb6c2; line-height:1.7; margin:0 0 22px; }

    .blog-meta { display:flex; align-items:center; flex-wrap:wrap; gap:14px; color:#8b94a3; font-size:.83rem; }
    .blog-meta__author { display:flex; align-items:center; gap:9px; color:#dce2ec; font-weight:600; }
    .blog-avatar { width:30px; height:30px; border-radius:50%; display:grid; place-items:center; font-size:.74rem; font-weight:800; color:#fff;
        background:linear-gradient(135deg,#ff2d55,#a855f7); }
    .blog-meta__dot::before { content:'•'; margin-right:14px; opacity:.5; }

    .blog-cat-tag { display:inline-flex; align-items:center; gap:6px; padding:5px 11px; border-radius:999px; font-size:.72rem; font-weight:800;
        letter-spacing:.02em; }

    /* GRID */
    .blog-grid { display:grid; grid-template-columns:repeat(3, minmax(0,1fr)); gap:22px; }
    .blog-card { display:flex; flex-direction:column; border-radius:16px; overflow:hidden; background:#0c0e15; border:1px solid rgba(255,255,255,.08);
        transition:transform .22s ease, border-color .22s ease, box-shadow .22s ease; }
    .blog-card:hover { transform:translateY(-5px); border-color:rgba(255,45,85,.4); box-shadow:0 18px 40px rgba(0,0,0,.45); }
    .blog-card__media { position:relative; aspect-ratio:16/10; overflow:hidden; }
    .blog-card__media img { width:100%; height:100%; object-fit:cover; transition:transform .4s ease; }
    .blog-card:hover .blog-card__media img { transform:scale(1.06); }
    .blog-card__cat { position:absolute; top:12px; left:12px; }
    .blog-card__body { padding:18px 18px 20px; display:flex; flex-direction:column; flex:1; }
    .blog-card__title { color:#fff; font-weight:700; font-size:1.06rem; line-height:1.35; margin:0 0 9px; }
    .blog-card__title a { color:inherit; text-decoration:none; }
    .blog-card__title a:hover { color:#ff8fa3; }
    .blog-card__excerpt { color:#9aa3b1; font-size:.88rem; line-height:1.6; margin:0 0 16px;
        display:-webkit-box; -webkit-line-clamp:3; -webkit-box-orient:vertical; overflow:hidden; }
    .blog-card__foot { margin-top:auto; }

    .blog-empty { text-align:center; padding:70px 20px; color:#8b94a3; border:1px dashed rgba(255,255,255,.14); border-radius:16px; }
    .blog-empty i { font-size:2.4rem; color:#3a4150; margin-bottom:12px; }

    .blog-pagination { margin-top:34px; }

    @media (max-width:980px){ .blog-grid{grid-template-columns:repeat(2,minmax(0,1fr));} .blog-featured{grid-template-columns:1fr;} .blog-featured__media{min-height:240px;} .blog-featured__media::after{background:linear-gradient(180deg,transparent 50%,#0c0e15);} }
    @media (max-width:600px){ .blog-grid{grid-template-columns:1fr;} .blog-hero{padding:34px 22px;} .blog-featured__body{padding:26px 22px;} }
</style>
@endpush

@section('content')
<nav class="breadcrumb-bar container-fluid px-4 px-xl-5">
    <ol class="breadcrumb-bar__list">
        <li><a href="{{ route('home') }}"><i class="fa-solid fa-house"></i> Trang chủ</a></li>
        <li class="breadcrumb-bar__active">Góc game thủ</li>
    </ol>
</nav>

<main class="blog-wrap container-fluid px-4 px-xl-5">
    {{-- HERO --}}
    <section class="blog-hero">
        <span class="blog-hero__eyebrow"><i class="fa-solid fa-bolt"></i> Blog YUKI Gaming</span>
        <h1>Góc <span>Game Thủ</span></h1>
        <p>Kiến thức chọn gear, review thực chiến, mẹo build setup và tin esports — tất cả để bạn chơi hay hơn và setup đẹp hơn.</p>
        <form class="blog-search" action="{{ route('blog.index') }}" method="GET">
            <input type="text" name="q" value="{{ $tuKhoa }}" placeholder="Tìm bài viết, ví dụ: chọn chuột, switch, setup...">
            <button type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
        </form>
    </section>

    {{-- LỌC DANH MỤC --}}
    <div class="blog-cats">
        <a href="{{ route('blog.index') }}" class="blog-chip {{ ! $danhMucActive ? 'is-active' : '' }}">
            <i class="fa-solid fa-layer-group"></i> Tất cả <span class="blog-chip__count">{{ $tongBai }}</span>
        </a>
        @foreach ($danhMucs as $slug => $label)
            <a href="{{ route('blog.index', ['danh_muc' => $slug]) }}" class="blog-chip {{ $danhMucActive === $slug ? 'is-active' : '' }}">
                <i class="fa-solid {{ $catIcons[$slug] ?? 'fa-tag' }}"></i> {{ $label }}
                <span class="blog-chip__count">{{ $demTheoDanhMuc[$slug] ?? 0 }}</span>
            </a>
        @endforeach
    </div>

    {{-- BÀI NỔI BẬT --}}
    @if ($featured)
        <article class="blog-featured">
            <div class="blog-featured__media">
                <img src="{{ asset($featured->anhBiaUrl()) }}" alt="{{ $featured->tieu_de }}">
            </div>
            <div class="blog-featured__body">
                <span class="blog-featured__flag"><i class="fa-solid fa-fire"></i> Bài nổi bật</span>
                <span class="blog-cat-tag" style="color:{{ $catColors[$featured->danh_muc] ?? '#ff2d55' }}; background:{{ ($catColors[$featured->danh_muc] ?? '#ff2d55') }}22; align-self:flex-start; margin-bottom:14px;">
                    <i class="fa-solid {{ $catIcons[$featured->danh_muc] ?? 'fa-tag' }}"></i> {{ $featured->tenDanhMuc() }}
                </span>
                <h2 class="blog-featured__title"><a href="{{ route('blog.show', $featured) }}">{{ $featured->tieu_de }}</a></h2>
                <p class="blog-featured__excerpt">{{ $featured->mo_ta_ngan }}</p>
                <div class="blog-meta">
                    <span class="blog-meta__author"><span class="blog-avatar">{{ mb_substr($featured->tac_gia, 0, 1) }}</span> {{ $featured->tac_gia }}</span>
                    <span class="blog-meta__dot">{{ $featured->ngayDangFormatted() }}</span>
                    <span class="blog-meta__dot"><i class="fa-regular fa-clock"></i> {{ $featured->thoi_gian_doc }} phút đọc</span>
                </div>
                <div style="margin-top:24px;">
                    <a href="{{ route('blog.show', $featured) }}" class="store-btn"><i class="fa-solid fa-arrow-right-long"></i> Đọc bài viết</a>
                </div>
            </div>
        </article>
    @endif

    {{-- LƯỚI BÀI VIẾT --}}
    @if ($baiViets->count())
        <div class="blog-grid">
            @foreach ($baiViets as $bv)
                <article class="blog-card">
                    <a href="{{ route('blog.show', $bv) }}" class="blog-card__media">
                        <img src="{{ asset($bv->anhBiaUrl()) }}" alt="{{ $bv->tieu_de }}">
                        <span class="blog-card__cat">
                            <span class="blog-cat-tag" style="color:{{ $catColors[$bv->danh_muc] ?? '#ff2d55' }}; background:#0b0d13cc; border:1px solid {{ ($catColors[$bv->danh_muc] ?? '#ff2d55') }}66;">
                                <i class="fa-solid {{ $catIcons[$bv->danh_muc] ?? 'fa-tag' }}"></i> {{ $bv->tenDanhMuc() }}
                            </span>
                        </span>
                    </a>
                    <div class="blog-card__body">
                        <h3 class="blog-card__title"><a href="{{ route('blog.show', $bv) }}">{{ $bv->tieu_de }}</a></h3>
                        <p class="blog-card__excerpt">{{ $bv->mo_ta_ngan }}</p>
                        <div class="blog-card__foot">
                            <div class="blog-meta">
                                <span class="blog-meta__author"><span class="blog-avatar">{{ mb_substr($bv->tac_gia, 0, 1) }}</span> {{ $bv->tac_gia }}</span>
                                <span class="blog-meta__dot"><i class="fa-regular fa-clock"></i> {{ $bv->thoi_gian_doc }}'</span>
                            </div>
                        </div>
                    </div>
                </article>
            @endforeach
        </div>

        <div class="blog-pagination store-pagination">{{ $baiViets->links() }}</div>
    @else
        <div class="blog-empty">
            <i class="fa-solid fa-newspaper d-block"></i>
            <p>Không tìm thấy bài viết phù hợp.</p>
            <a href="{{ route('blog.index') }}" class="store-btn store-btn--ghost mt-2">Xem tất cả bài viết</a>
        </div>
    @endif
</main>
@endsection
