@php
    $discount = $product->discountPercent();
    $image = asset($product->mainImagePath());
@endphp

<a href="{{ route('products.show', $product) }}" class="p-card store-link-card" data-cat="{{ $product->danhMuc?->slug }}" data-price="{{ (int) $product->gia_ban }}" data-name="{{ $product->ten }}">
    @if ($discount)
        <span class="p-card__tag p-card__tag--sale">-{{ $discount }}%</span>
    @elseif ($product->is_hot)
        <span class="p-card__tag p-card__tag--hot">HOT</span>
    @endif

    <div class="p-card__media">
        <img src="{{ $image }}" alt="{{ $product->ten }}">
        <span class="p-card__quick"><i class="fa-solid fa-eye"></i> Chi tiết</span>
    </div>
    <div class="p-card__body">
        <span class="p-card__brand">{{ $product->thuongHieu?->ten ?? 'SKT' }}</span>
        <h6 class="p-card__name">{{ $product->ten }}</h6>
        <p class="p-card__desc">{{ $product->mo_ta_ngan }}</p>
        <span class="p-card__feature">
            {{ $product->danhMuc?->ten ?? 'Gaming Gear' }} · {{ number_format($product->diem_danh_gia, 1) }} sao
        </span>
        <div class="p-card__bottom">
            <div class="p-card__prices">
                <span class="p-card__price">{{ $product->formattedPrice() }}</span>
                @if ($product->formattedOldPrice())
                    <del class="p-card__old">{{ $product->formattedOldPrice() }}</del>
                @endif
            </div>
        </div>
    </div>
</a>
