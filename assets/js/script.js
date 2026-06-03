/* ==========================================
   #region AUTH
========================================== */
function initTogglePassword() {
    document.querySelectorAll('.toggle-password').forEach(function (btn) {
        btn.addEventListener('click', function () {
            var container = this.closest('.input-group');
            if (!container) return;
            var input = container.querySelector('input');
            var icon  = this.querySelector('i');
            if (input && icon) {
                if (input.type === 'password') {
                    input.type = 'text';
                    icon.classList.replace('fa-eye', 'fa-eye-slash');
                } else {
                    input.type = 'password';
                    icon.classList.replace('fa-eye-slash', 'fa-eye');
                }
            }
        });
    });
}
/* #endregion */

/* ==========================================
   #region NAVBAR
========================================== */
function initNavbar() {
    var toggle = document.getElementById('navToggle');
    var menu   = document.getElementById('navMenu');
    if (!toggle || !menu) return;
    toggle.addEventListener('click', function () { menu.classList.toggle('is-open'); });
    document.addEventListener('click', function (e) {
        if (!toggle.contains(e.target) && !menu.contains(e.target)) {
            menu.classList.remove('is-open');
        }
    });
}
/* #endregion */

/* ==========================================
   #region HERO SLIDER
========================================== */
function initHeroSlider() {
    var next      = document.getElementById('nextBtn');
    var prev      = document.getElementById('prevBtn');
    var track     = document.getElementById('heroTrack');
    var heroTitle = document.getElementById('heroTitle');
    var heroDesc  = document.getElementById('heroDesc');
    if (!track || !next || !prev) return;

    function updateHero() {
        var items  = track.querySelectorAll('.hero-card');
        var active = items[1];
        if (!active) return;
        heroTitle.innerText = active.dataset.title;
        heroDesc.innerText  = active.dataset.desc;
        var heroBg = document.getElementById('heroBg');
        if (heroBg) {
            heroBg.style.backgroundImage    = active.style.backgroundImage;
            heroBg.style.backgroundSize     = 'cover';
            heroBg.style.backgroundPosition = 'center';
            heroBg.style.filter             = 'blur(24px) brightness(0.25)';
        }
    }

    next.addEventListener('click', function () {
        var items = track.querySelectorAll('.hero-card');
        track.appendChild(items[0]);
        updateHero();
    });
    prev.addEventListener('click', function () {
        var items = track.querySelectorAll('.hero-card');
        track.prepend(items[items.length - 1]);
        updateHero();
    });
    setInterval(function () { next.click(); }, 6000);
    updateHero();
}
/* #endregion */

/* ==========================================
   #region SALE OWL CAROUSEL
========================================== */
function initSaleCarousel() {
    if (typeof $ === 'undefined' || typeof $.fn.owlCarousel === 'undefined') return;

    var $car = $('.sale-carousel').owlCarousel({
        loop: true,
        margin: 12,
        nav: false,
        dots: false,
        autoplay: true,
        autoplayTimeout: 4500,
        autoplayHoverPause: true,
        responsive: {
            0:   { items: 1 },
            576: { items: 2 },
            992: { items: 3 }
        }
    });

    $('#salePrev').on('click', function () { $car.trigger('prev.owl.carousel'); });
    $('#saleNext').on('click', function () { $car.trigger('next.owl.carousel'); });
}
/* #endregion */

/* ==========================================
   #region COUNTDOWN
========================================== */
function initCountdown() {
    var hEl = document.getElementById('timerH');
    var mEl = document.getElementById('timerM');
    var sEl = document.getElementById('timerS');
    if (!hEl) return;
    var total = 2 * 3600 + 41 * 60 + 15;
    setInterval(function () {
        if (total <= 0) return;
        total--;
        hEl.textContent = String(Math.floor(total / 3600)).padStart(2, '0');
        mEl.textContent = String(Math.floor((total % 3600) / 60)).padStart(2, '0');
        sEl.textContent = String(total % 60).padStart(2, '0');
    }, 1000);
}
/* #endregion */

/* ==========================================
   #region AOS
========================================== */
function initAOS() {
    if (typeof AOS === 'undefined') return;
    AOS.init({ duration: 700, easing: 'ease-out-cubic', once: true, offset: 60 });
}
/* #endregion */

/* ==========================================
   #region SEARCH OVERLAY
========================================== */
function initSearchOverlay() {
    var overlay  = document.getElementById('searchOverlay');
    var openBtn  = document.getElementById('openSearchBtn');
    var closeBtn = document.getElementById('closeSearchBtn');
    var backdrop = document.getElementById('searchBackdrop');
    var input    = document.getElementById('searchInput');
    if (!overlay || !openBtn) return;

    function open()  {
        overlay.classList.add('is-open');
        overlay.setAttribute('aria-hidden', 'false');
        document.body.classList.add('is-locked');
        setTimeout(function () { if (input) input.focus(); }, 350);
    }
    function close() {
        overlay.classList.remove('is-open');
        overlay.setAttribute('aria-hidden', 'true');
        document.body.classList.remove('is-locked');
    }

    openBtn.addEventListener('click', open);
    closeBtn && closeBtn.addEventListener('click', close);
    backdrop && backdrop.addEventListener('click', close);
    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape' && overlay.classList.contains('is-open')) close();
    });
}
/* #endregion */

/* ==========================================
   #region CONFIRM MODAL
========================================== */
var _confirmResolve = null;

function showConfirm(productName) {
    var modal    = document.getElementById('confirmModal');
    var textEl   = document.getElementById('confirmText');
    var okBtn    = document.getElementById('confirmOk');
    var cancelBtn = document.getElementById('confirmCancel');
    var backdrop = document.getElementById('confirmBackdrop');
    if (!modal) return Promise.resolve(false);

    if (productName) {
        textEl.textContent = 'Bạn có chắc chắn muốn xóa "' + productName + '" khỏi giỏ hàng không?';
    }

    modal.classList.add('is-open');

    return new Promise(function (resolve) {
        _confirmResolve = resolve;

        function close(result) {
            modal.classList.remove('is-open');
            _confirmResolve = null;
            okBtn.removeEventListener('click', onOk);
            cancelBtn.removeEventListener('click', onCancel);
            backdrop.removeEventListener('click', onCancel);
            resolve(result);
        }

        function onOk()     { close(true); }
        function onCancel() { close(false); }

        okBtn.addEventListener('click', onOk);
        cancelBtn.addEventListener('click', onCancel);
        backdrop.addEventListener('click', onCancel);
    });
}
/* #endregion */

/* ==========================================
   #region FLY-TO-CART
========================================== */
function flyToCart(imgEl) {
    var cartIcon = document.getElementById('openCartBtn');
    if (!cartIcon || !imgEl) return;

    var imgRect  = imgEl.getBoundingClientRect();
    var cartRect = cartIcon.getBoundingClientRect();

    var clone = document.createElement('div');
    clone.className = 'fly-clone';
    clone.style.width  = imgRect.width + 'px';
    clone.style.height = imgRect.height + 'px';
    clone.style.left   = imgRect.left + 'px';
    clone.style.top    = imgRect.top + 'px';
    clone.style.backgroundImage = 'url(' + imgEl.src + ')';
    clone.style.backgroundSize = 'contain';
    clone.style.backgroundRepeat = 'no-repeat';
    clone.style.backgroundPosition = 'center';
    clone.style.backgroundColor = '#1a1c24';
    document.body.appendChild(clone);

    requestAnimationFrame(function () {
        clone.classList.add('is-flying');
        clone.style.left = cartRect.left + (cartRect.width / 2) + 'px';
        clone.style.top  = cartRect.top + (cartRect.height / 2) + 'px';
    });

    setTimeout(function () {
        clone.remove();
        cartIcon.classList.add('cart-bouncing');
        setTimeout(function () { cartIcon.classList.remove('cart-bouncing'); }, 500);
    }, 700);
}

function initFlyToCart() {
    document.querySelectorAll('.p-card__quick').forEach(function (btn) {
        btn.addEventListener('click', function (e) {
            e.preventDefault();
            e.stopPropagation();
            var card = btn.closest('.p-card');
            var img  = card ? card.querySelector('.p-card__media img') : null;
            if (img) flyToCart(img);
        });
    });
}
/* #endregion */

/* ==========================================
   #region CART DRAWER
========================================== */
function initCartDrawer() {
    var drawer   = document.getElementById('cartDrawer');
    var openBtn  = document.getElementById('openCartBtn');
    var closeBtn = document.getElementById('closeCartBtn');
    var backdrop = document.getElementById('cartBackdrop');
    if (!drawer || !openBtn) return;

    function open()  {
        drawer.classList.add('is-open');
        drawer.setAttribute('aria-hidden', 'false');
        document.body.classList.add('is-locked');
    }
    function close() {
        drawer.classList.remove('is-open');
        drawer.setAttribute('aria-hidden', 'true');
        document.body.classList.remove('is-locked');
    }

    openBtn.addEventListener('click', open);
    closeBtn && closeBtn.addEventListener('click', close);
    backdrop && backdrop.addEventListener('click', close);
    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape' && drawer.classList.contains('is-open')) close();
    });

    // Remove item with confirm dialog
    document.querySelectorAll('.cart-item__remove').forEach(function (btn) {
        btn.addEventListener('click', function () {
            var item = btn.closest('.cart-item');
            if (!item) return;
            var nameEl = item.querySelector('.cart-item__name');
            var name   = nameEl ? nameEl.textContent.trim() : 'sản phẩm này';

            showConfirm(name).then(function (confirmed) {
                if (!confirmed) return;
                item.style.transition = 'opacity .3s, transform .3s';
                item.style.opacity = '0';
                item.style.transform = 'translateX(30px)';
                setTimeout(function () { item.remove(); updateCartCount(); }, 300);
            });
        });
    });

    // Qty +/-
    document.querySelectorAll('.qty-input').forEach(function (group) {
        var input = group.querySelector('input');
        var btns  = group.querySelectorAll('.qty-input__btn');
        if (btns.length < 2 || !input) return;
        btns[0].addEventListener('click', function () {
            var n = Math.max(1, (parseInt(input.value) || 1) - 1);
            input.value = n;
        });
        btns[1].addEventListener('click', function () {
            input.value = (parseInt(input.value) || 1) + 1;
        });
    });
}

function updateCartCount() {
    var count = document.querySelectorAll('#cartList .cart-item').length;
    var badge = document.getElementById('cartBadge');
    var titleCount = document.getElementById('cartCount');
    if (badge) badge.textContent = count;
    if (titleCount) titleCount.textContent = count;
}
/* #endregion */

/* ==========================================
   #region DETAIL PAGE
========================================== */
function initDetailPage() {
    if (typeof $ === 'undefined' || typeof $.fn.owlCarousel === 'undefined') return;

    // Gallery carousel
    var $gallery = $('.detail-gallery__main');
    if ($gallery.length) {
        $gallery.owlCarousel({
            items: 1, loop: true, nav: true, dots: false, smartSpeed: 400,
            navText: ['<i class="fa-solid fa-chevron-left"></i>', '<i class="fa-solid fa-chevron-right"></i>']
        });

        // Thumb click → go to slide
        document.querySelectorAll('.detail-gallery__thumb').forEach(function (tb) {
            tb.addEventListener('click', function () {
                var idx = parseInt(tb.dataset.idx);
                $gallery.trigger('to.owl.carousel', [idx, 300]);
                document.querySelectorAll('.detail-gallery__thumb').forEach(function (t) { t.classList.remove('is-active'); });
                tb.classList.add('is-active');
            });
        });

        // Sync thumb active on slide change
        $gallery.on('changed.owl.carousel', function (e) {
            var idx = e.item.index - e.relatedTarget._clones.length / 2;
            var total = e.item.count;
            idx = ((idx % total) + total) % total;
            document.querySelectorAll('.detail-gallery__thumb').forEach(function (t, i) {
                t.classList.toggle('is-active', i === idx);
            });
        });
    }

    // Related products carousel
    $('.related-carousel').owlCarousel({
        loop: true, margin: 14, nav: true, dots: false,
        autoplay: true, autoplayTimeout: 5000, autoplayHoverPause: true,
        navText: ['<i class="fa-solid fa-chevron-left"></i>', '<i class="fa-solid fa-chevron-right"></i>'],
        responsive: { 0: { items: 1 }, 576: { items: 2 }, 992: { items: 4 } }
    });

    // Detail qty +/-
    var qtyMinus = document.getElementById('detailQtyMinus');
    var qtyPlus  = document.getElementById('detailQtyPlus');
    var qtyInput = document.getElementById('detailQtyInput');
    if (qtyMinus && qtyPlus && qtyInput) {
        qtyMinus.addEventListener('click', function () {
            qtyInput.value = Math.max(1, (parseInt(qtyInput.value) || 1) - 1);
        });
        qtyPlus.addEventListener('click', function () {
            qtyInput.value = (parseInt(qtyInput.value) || 1) + 1;
        });
    }

    // Star pick
    var starPick = document.getElementById('starPick');
    if (starPick) {
        var stars = starPick.querySelectorAll('i');
        stars.forEach(function (s) {
            s.addEventListener('click', function () {
                var val = parseInt(s.dataset.val);
                stars.forEach(function (st, i) {
                    st.classList.toggle('is-active', i < val);
                });
            });
            s.addEventListener('mouseenter', function () {
                var val = parseInt(s.dataset.val);
                stars.forEach(function (st, i) {
                    st.style.color = i < val ? '#ffc107' : '#333';
                });
            });
        });
        starPick.addEventListener('mouseleave', function () {
            stars.forEach(function (st) {
                st.style.color = st.classList.contains('is-active') ? '#ffc107' : '#333';
            });
        });
    }

    // Detail add to cart — fly to cart icon
    var addCartBtn = document.getElementById('detailAddCart');
    if (addCartBtn) {
        addCartBtn.addEventListener('click', function () {
            var galleryImg = document.querySelector('.detail-gallery__slide.active img, .detail-gallery__main .owl-item.active img');
            if (galleryImg) flyToCart(galleryImg);
        });
    }

    // Color swatch click
    document.querySelectorAll('.detail-swatch').forEach(function (sw) {
        sw.addEventListener('click', function () {
            document.querySelectorAll('.detail-swatch').forEach(function (s) { s.classList.remove('is-active'); });
            sw.classList.add('is-active');
        });
    });
}
/* #endregion */

/* ==========================================
   INIT
========================================== */
document.addEventListener('DOMContentLoaded', function () {
    initTogglePassword();
    initNavbar();
    initHeroSlider();
    initSaleCarousel();
    initCountdown();
    initAOS();
    initSearchOverlay();
    initCartDrawer();
    initFlyToCart();
    initDetailPage();
});
