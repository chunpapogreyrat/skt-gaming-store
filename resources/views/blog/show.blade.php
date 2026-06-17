@extends('layouts.app')

@section('title', $baiViet->tieu_de . ' - Góc Game Thủ YUKI')

@php
    $catColors = [
        'setup' => '#22d3ee', 'review' => '#fbbf24', 'huong-dan' => '#34d399',
        'tin-tuc' => '#ff2d55', 'esports' => '#a855f7',
    ];
    $catIcons = [
        'setup' => 'fa-desktop', 'review' => 'fa-star', 'huong-dan' => 'fa-book-open',
        'tin-tuc' => 'fa-bolt', 'esports' => 'fa-trophy',
    ];
    $accent = $catColors[$baiViet->danh_muc] ?? '#ff2d55';
@endphp

@push('styles')
<style>
    .article-wrap { padding:26px 0 64px; }

    .article-head { max-width:860px; margin:0 auto 26px; text-align:center; }
    .article-cat { display:inline-flex; align-items:center; gap:7px; padding:6px 14px; border-radius:999px; font-size:.76rem; font-weight:800;
        letter-spacing:.04em; text-transform:uppercase; margin-bottom:18px; }
    .article-title { color:#fff; font-family:Orbitron, sans-serif; font-weight:800; font-size:clamp(1.7rem,3.6vw,2.7rem); line-height:1.18; margin:0 0 18px; }
    .article-meta { display:flex; align-items:center; justify-content:center; flex-wrap:wrap; gap:14px; color:#8b94a3; font-size:.86rem; }
    .article-meta__author { display:flex; align-items:center; gap:9px; color:#dce2ec; font-weight:600; }
    .article-avatar { width:34px; height:34px; border-radius:50%; display:grid; place-items:center; font-size:.8rem; font-weight:800; color:#fff;
        background:linear-gradient(135deg,#ff2d55,#a855f7); }
    .article-meta__dot::before { content:'•'; margin-right:14px; opacity:.5; }

    .article-cover { max-width:1040px; margin:0 auto 36px; border-radius:18px; overflow:hidden; border:1px solid rgba(255,255,255,.08);
        aspect-ratio:21/9; }
    .article-cover img { width:100%; height:100%; object-fit:cover; }

    .article-layout { max-width:1040px; margin:0 auto; display:grid; grid-template-columns:minmax(0,1fr) 300px; gap:40px; align-items:start; }

    /* Typography nội dung */
    .article-body { color:#cfd6e0; font-size:1.06rem; line-height:1.85; }
    .article-body p { margin:0 0 20px; }
    .article-body h3 { color:#fff; font-family:Orbitron, sans-serif; font-size:1.28rem; margin:34px 0 14px; padding-left:14px; border-left:3px solid var(--art-accent); }
    .article-body ul { margin:0 0 20px; padding-left:4px; list-style:none; }
    .article-body ul li { position:relative; padding-left:26px; margin-bottom:10px; }
    .article-body ul li::before { content:'\f00c'; font-family:'Font Awesome 6 Free'; font-weight:900; color:var(--art-accent); position:absolute; left:0; top:2px; font-size:.82rem; }
    .article-body strong { color:#fff; }
    .article-body em { color:#ff8fa3; font-style:normal; }
    .article-body a { color:var(--art-accent); }

    .article-share { display:flex; align-items:center; gap:12px; margin-top:34px; padding-top:22px; border-top:1px solid rgba(255,255,255,.08); flex-wrap:wrap; }
    .article-share span { color:#8b94a3; font-size:.88rem; }
    .article-share a { width:38px; height:38px; border-radius:10px; display:grid; place-items:center; color:#cbd5e1; background:rgba(255,255,255,.05); border:1px solid rgba(255,255,255,.1); text-decoration:none; transition:.18s; }
    .article-share a:hover { color:#fff; border-color:var(--art-accent); transform:translateY(-2px); }

    /* Sidebar */
    .article-aside { position:sticky; top:90px; display:flex; flex-direction:column; gap:18px; }
    .aside-box { border:1px solid rgba(255,255,255,.08); background:#0c0e15; border-radius:16px; padding:20px; }
    .aside-box__title { color:#fff; font-weight:800; font-size:.96rem; margin:0 0 16px; display:flex; align-items:center; gap:8px; }
    .aside-box__title i { color:var(--red,#ff2d55); }
    .aside-post { display:flex; gap:12px; text-decoration:none; margin-bottom:14px; }
    .aside-post:last-child { margin-bottom:0; }
    .aside-post__thumb { width:64px; height:54px; border-radius:9px; overflow:hidden; flex:0 0 auto; }
    .aside-post__thumb img { width:100%; height:100%; object-fit:cover; }
    .aside-post__t { color:#dce2ec; font-size:.84rem; line-height:1.4; font-weight:600; transition:.15s;
        display:-webkit-box; -webkit-line-clamp:2; -webkit-box-orient:vertical; overflow:hidden; }
    .aside-post:hover .aside-post__t { color:#ff8fa3; }
    .aside-cta { background:radial-gradient(600px 200px at 0% 0%, rgba(255,45,85,.22), transparent), #0c0e15; text-align:center; }
    .aside-cta p { color:#aeb6c2; font-size:.88rem; line-height:1.6; margin:0 0 16px; }

    /* Bài liên quan */
    .related-wrap { max-width:1040px; margin:54px auto 0; }
    .related-wrap__title { color:#fff; font-family:Orbitron, sans-serif; font-size:1.3rem; margin:0 0 20px; }
    .related-grid { display:grid; grid-template-columns:repeat(3,minmax(0,1fr)); gap:20px; }
    .rel-card { border-radius:14px; overflow:hidden; background:#0c0e15; border:1px solid rgba(255,255,255,.08); transition:.2s; text-decoration:none; display:block; }
    .rel-card:hover { transform:translateY(-4px); border-color:rgba(255,45,85,.4); }
    .rel-card__media { aspect-ratio:16/10; overflow:hidden; }
    .rel-card__media img { width:100%; height:100%; object-fit:cover; }
    .rel-card__b { padding:14px 15px 16px; }
    .rel-card__t { color:#fff; font-weight:700; font-size:.95rem; line-height:1.4; display:-webkit-box; -webkit-line-clamp:2; -webkit-box-orient:vertical; overflow:hidden; }

    @media (max-width:920px){ .article-layout{grid-template-columns:1fr;} .article-aside{position:static;} .related-grid{grid-template-columns:repeat(2,1fr);} .article-cover{aspect-ratio:16/9;} }
    @media (max-width:560px){ .related-grid{grid-template-columns:1fr;} }
</style>
@endpush

@section('content')
<nav class="breadcrumb-bar container-fluid px-4 px-xl-5">
    <ol class="breadcrumb-bar__list">
        <li><a href="{{ route('home') }}"><i class="fa-solid fa-house"></i> Trang chủ</a></li>
        <li><a href="{{ route('blog.index') }}">Góc game thủ</a></li>
        <li class="breadcrumb-bar__active">{{ \Illuminate\Support\Str::limit($baiViet->tieu_de, 40) }}</li>
    </ol>
</nav>

<main class="article-wrap container-fluid px-4 px-xl-5" style="--art-accent: {{ $accent }};">
    <header class="article-head">
        <span class="article-cat" style="color:{{ $accent }}; background:{{ $accent }}22;">
            <i class="fa-solid {{ $catIcons[$baiViet->danh_muc] ?? 'fa-tag' }}"></i> {{ $baiViet->tenDanhMuc() }}
        </span>
        <h1 class="article-title">{{ $baiViet->tieu_de }}</h1>
        <div class="article-meta">
            <span class="article-meta__author"><span class="article-avatar">{{ mb_substr($baiViet->tac_gia, 0, 1) }}</span> {{ $baiViet->tac_gia }}</span>
            <span class="article-meta__dot">{{ $baiViet->ngayDangFormatted() }}</span>
            <span class="article-meta__dot"><i class="fa-regular fa-clock"></i> {{ $baiViet->thoi_gian_doc }} phút đọc</span>
            <span class="article-meta__dot"><i class="fa-regular fa-eye"></i> {{ number_format($baiViet->luot_xem) }} lượt xem</span>
        </div>
    </header>

    <div class="article-cover">
        <img src="{{ asset($baiViet->anhBiaUrl()) }}" alt="{{ $baiViet->tieu_de }}">
    </div>

    <div class="article-layout">
        <article class="article-body">
            {!! $baiViet->noi_dung !!}

            <div class="article-share">
                <span>Chia sẻ bài viết:</span>
                <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(route('blog.show', $baiViet)) }}" target="_blank" rel="noopener" title="Facebook"><i class="fa-brands fa-facebook-f"></i></a>
                <a href="https://twitter.com/intent/tweet?url={{ urlencode(route('blog.show', $baiViet)) }}&text={{ urlencode($baiViet->tieu_de) }}" target="_blank" rel="noopener" title="X"><i class="fa-brands fa-x-twitter"></i></a>
                <a href="{{ route('blog.index') }}" title="Quay lại blog"><i class="fa-solid fa-arrow-left"></i></a>
            </div>
        </article>

        <aside class="article-aside">
            <div class="aside-box">
                <h4 class="aside-box__title"><i class="fa-solid fa-clock-rotate-left"></i> Bài mới nhất</h4>
                @foreach ($moiNhat as $m)
                    <a href="{{ route('blog.show', $m) }}" class="aside-post">
                        <span class="aside-post__thumb"><img src="{{ asset($m->anhBiaUrl()) }}" alt=""></span>
                        <span class="aside-post__t">{{ $m->tieu_de }}</span>
                    </a>
                @endforeach
            </div>
            <div class="aside-box aside-cta">
                <h4 class="aside-box__title"><i class="fa-solid fa-bag-shopping"></i> Nâng cấp gear?</h4>
                <p>Khám phá chuột, bàn phím và phụ kiện chính hãng đang có tại YUKI Gaming Store.</p>
                <a href="{{ route('products.index') }}" class="store-btn w-100"><i class="fa-solid fa-arrow-right-long"></i> Mua sắm ngay</a>
            </div>
        </aside>
    </div>

    @if ($lienQuan->count())
        <section class="related-wrap">
            <h3 class="related-wrap__title"><i class="fa-solid fa-newspaper" style="color:var(--art-accent)"></i> Bài viết liên quan</h3>
            <div class="related-grid">
                @foreach ($lienQuan as $rel)
                    <a href="{{ route('blog.show', $rel) }}" class="rel-card">
                        <div class="rel-card__media"><img src="{{ asset($rel->anhBiaUrl()) }}" alt="{{ $rel->tieu_de }}"></div>
                        <div class="rel-card__b"><div class="rel-card__t">{{ $rel->tieu_de }}</div></div>
                    </a>
                @endforeach
            </div>
        </section>
    @endif
</main>
@endsection
