/* ==========================================
   #region AUTH
========================================== */
function initTogglePassword() {
    document.querySelectorAll('.toggle-password').forEach(function (btn) {
        btn.addEventListener('click', function () {
            var container = this.closest('.auth-field') || this.closest('.input-group');
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
                // blink animation feedback
                btn.classList.add('is-blink');
                setTimeout(function () { btn.classList.remove('is-blink'); }, 400);
            }
        });
    });
}
/* #endregion */

/* ==========================================
   #region AUTH PARALLAX (banner bg follows mouse)
========================================== */
function initAuthParallax() {
    var section = document.querySelector('.auth-section');
    var bg      = document.getElementById('authBannerBg');
    if (!section || !bg) return;

    section.addEventListener('mousemove', function (e) {
        var x = (e.clientX / window.innerWidth  - 0.5);
        var y = (e.clientY / window.innerHeight - 0.5);
        // move opposite to cursor for depth
        bg.style.transform = 'scale(1.1) translate(' + (-x * 24) + 'px, ' + (-y * 24) + 'px)';
    });
    section.addEventListener('mouseleave', function () {
        bg.style.transform = 'scale(1.1) translate(0,0)';
    });
}
/* #endregion */

/* ==========================================
   #region NAVBAR
========================================== */
function initNavActive() {
    // Lấy tên trang, bỏ query/hash/đuôi .html (server có thể bỏ .html)
    function base(p) {
        var name = (p || '').split('?')[0].split('#')[0].split('/').pop();
        return (name || 'index').replace(/\.html$/i, '').toLowerCase() || 'index';
    }
    var cur = base(location.pathname);
    // detail thuộc nhóm sản phẩm → sáng "Gaming Gear"
    var map = { products: 'products', detail: 'products', setups: 'setups', about: 'about', contact: 'contact' };
    var target = map[cur];
    if (!target) return;
    document.querySelectorAll('.navbar__link').forEach(function (a) {
        if (base(a.getAttribute('href') || '') === target) a.classList.add('navbar__link--active');
    });
}

function initNavbar() {
    initNavActive();
    var toggle = document.getElementById('navToggle');
    var menu   = document.getElementById('navMenu');
    if (!toggle || !menu) return;
    toggle.addEventListener('click', function () { menu.classList.toggle('is-open'); });
    document.addEventListener('click', function (e) {
        if (!toggle.contains(e.target) && !menu.contains(e.target)) {
            menu.classList.remove('is-open');
        }
    });

    // Mobile: chạm menu cha để mở/đóng cấp 2 (hover không dùng được trên cảm ứng)
    document.querySelectorAll('.navbar__has-drop > .navbar__link').forEach(function (link) {
        link.addEventListener('click', function (e) {
            if (window.innerWidth <= 992) {
                e.preventDefault();
                link.parentElement.classList.toggle('is-open');
            }
        });
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
    setInterval(function () { next.click(); }, 2500);
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

    // Khởi tạo AOS chủ yếu để dùng CSS transitions của nó (không auto trigger riêng)
    AOS.init({
        duration: 750,
        easing: 'ease-out-cubic',
        once: false,
        mirror: true,
        offset: 80,
        disableMutationObserver: true
    });

    // Bộ quan sát riêng: bật/tắt hiệu ứng mỗi khi phần tử vào/ra khung nhìn
    // -> chạy lại cả khi cuộn XUỐNG lẫn cuộn LÊN (khắc phục hạn chế của AOS)
    var els = document.querySelectorAll('[data-aos]');
    if (!('IntersectionObserver' in window) || !els.length) return;

    var io = new IntersectionObserver(function (entries) {
        entries.forEach(function (en) {
            if (en.isIntersecting) {
                en.target.classList.add('aos-animate');
            } else {
                en.target.classList.remove('aos-animate');
            }
        });
    }, { threshold: 0.12, rootMargin: '0px 0px -8% 0px' });

    els.forEach(function (el) { io.observe(el); });

    window.addEventListener('load', function () { AOS.refresh(); });
}
/* #endregion */

/* ==========================================
   #region HERO PARTICLES (tsParticles neon)
========================================== */
function initHeroParticles() {
    var hero = document.querySelector('.hero-slider');
    if (!hero || typeof tsParticles === 'undefined') return;

    // tạo lớp hạt nằm trên nền, dưới nội dung
    var layer = document.createElement('div');
    layer.id = 'heroParticles';
    layer.className = 'hero-particles';
    hero.appendChild(layer);

    tsParticles.load({
        id: 'heroParticles',
        options: {
            fpsLimit: 60,
            fullScreen: { enable: false },
            particles: {
                number: { value: 45, density: { enable: true, area: 900 } },
                color: { value: ['#ff003c', '#00e5ff', '#ffffff'] },
                shape: { type: 'circle' },
                opacity: { value: { min: 0.2, max: 0.6 } },
                size: { value: { min: 1, max: 3 } },
                links: { enable: true, distance: 130, color: '#ff003c', opacity: 0.22, width: 1 },
                move: { enable: true, speed: 0.9, outModes: { default: 'out' } }
            },
            detectRetina: true
        }
    });
}
/* #endregion */

/* ==========================================
   #region SITE BACKGROUND (cyber grid + glow trôi)
========================================== */
function initSiteBackground() {
    // bỏ qua trang đăng nhập/đăng ký (có nền riêng)
    if (document.querySelector('.auth-section')) return;
    if (document.querySelector('.site-bg')) return;

    var bg = document.createElement('div');
    bg.className = 'site-bg';
    bg.setAttribute('aria-hidden', 'true');
    bg.innerHTML =
        '<div class="site-bg__grid"></div>' +
        '<div class="site-bg__glow site-bg__glow--1"></div>' +
        '<div class="site-bg__glow site-bg__glow--2"></div>' +
        '<div class="site-bg__glow site-bg__glow--3"></div>';
    document.body.prepend(bg);
}
/* #endregion */

/* ==========================================
   #region BACK TO TOP
========================================== */
function initBackToTop() {
    var btn = document.createElement('button');
    btn.className = 'back-to-top';
    btn.id = 'backToTop';
    btn.setAttribute('aria-label', 'Lên đầu trang');
    btn.innerHTML = '<i class="fa-solid fa-chevron-up"></i>';
    document.body.appendChild(btn);

    window.addEventListener('scroll', function () {
        btn.classList.toggle('is-show', window.scrollY > 500);
    });
    btn.addEventListener('click', function () {
        window.scrollTo({ top: 0, behavior: 'smooth' });
    });
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
   #region FLY-TO-CART (paper plane)
========================================== */
function flyPaperPlane(fromEl) {
    var cartIcon = document.getElementById('openCartBtn');
    if (!cartIcon || !fromEl) return;

    var fromRect = fromEl.getBoundingClientRect();
    var cartRect = cartIcon.getBoundingClientRect();

    var startX = fromRect.left + fromRect.width / 2;
    var startY = fromRect.top + fromRect.height / 2;
    var endX   = cartRect.left + cartRect.width / 2;
    var endY   = cartRect.top + cartRect.height / 2;

    var plane = document.createElement('div');
    plane.className = 'fly-plane';
    plane.innerHTML = '<i class="fa-solid fa-paper-plane"></i>';
    plane.style.left = startX + 'px';
    plane.style.top  = startY + 'px';
    document.body.appendChild(plane);

    // angle so the plane points toward the cart
    var angle = Math.atan2(endY - startY, endX - startX) * 180 / Math.PI;
    plane.style.transform = 'translate(-50%, -50%) rotate(' + angle + 'deg) scale(1)';

    requestAnimationFrame(function () {
        plane.classList.add('is-flying');
        plane.style.left = endX + 'px';
        plane.style.top  = endY + 'px';
        plane.style.transform = 'translate(-50%, -50%) rotate(' + angle + 'deg) scale(.3)';
        plane.style.opacity = '0';
    });

    setTimeout(function () {
        plane.remove();
        cartIcon.classList.add('cart-bouncing');
        setTimeout(function () { cartIcon.classList.remove('cart-bouncing'); }, 500);
    }, 750);
}

/* Read product data from any card type */
function readCardData(card) {
    if (!card) return null;
    var nameEl  = card.querySelector('.p-card__name, .deal-card__name, .top-card__name, .wishlist-card__name');
    var priceEl = card.querySelector('.p-card__price, .deal-card__price, .deal-card__new, .top-card__price, .wishlist-card__price');
    var imgEl   = card.querySelector('img');
    return {
        name:  nameEl  ? nameEl.textContent.trim()  : 'Sản phẩm',
        price: priceEl ? priceEl.textContent.trim() : '0đ',
        img:   imgEl   ? imgEl.getAttribute('src')  : ''
    };
}

/* Parse "5.990.000đ" -> 5990000 */
function parsePrice(str) {
    return parseInt((str || '').replace(/[^\d]/g, ''), 10) || 0;
}
function formatPrice(num) {
    return num.toLocaleString('vi-VN') + 'đ';
}

/* Add a product to cart drawer (or bump qty if exists) */
function addToCart(data) {
    var list = document.getElementById('cartList');
    if (!list || !data) return;

    // If same product already in cart -> increment its qty
    var existing = null;
    list.querySelectorAll('.cart-item').forEach(function (it) {
        var n = it.querySelector('.cart-item__name');
        if (n && n.textContent.trim() === data.name) existing = it;
    });

    if (existing) {
        var input = existing.querySelector('.qty-input input');
        if (input) input.value = (parseInt(input.value) || 1) + 1;
    } else {
        var item = document.createElement('div');
        item.className = 'cart-item';
        item.innerHTML =
            '<div class="cart-item__img"><img src="' + data.img + '" alt=""></div>' +
            '<div class="cart-item__info">' +
                '<h6 class="cart-item__name">' + data.name + '</h6>' +
                '<span class="cart-item__price">' + data.price + '</span>' +
                '<p class="cart-item__variant">Phân loại: Mặc định</p>' +
            '</div>' +
            '<div class="cart-item__actions">' +
                '<div class="qty-input">' +
                    '<button type="button" class="qty-input__btn">−</button>' +
                    '<input type="text" value="1" readonly>' +
                    '<button type="button" class="qty-input__btn">+</button>' +
                '</div>' +
                '<button type="button" class="cart-item__remove" aria-label="Xóa"><i class="fa-solid fa-trash-can"></i></button>' +
            '</div>';
        list.appendChild(item);
    }
    updateCartCount();
}

function initFlyToCart() {
    // LARAVEL OVERRIDE: giỏ hàng do server xử lý (handler [data-product-id] trong app.blade.php).
    // KHÔNG tự thêm giỏ client-side (tránh thêm trùng 2 lần + chặn nút "Chi tiết").
    // CHỈ export animation bay-vào-giỏ để app.blade.php gọi sau khi POST thành công.
    window.skSktFlyPaperPlane = flyPaperPlane;
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
    var list     = document.getElementById('cartList');
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

    // Delegated events (works for items added later too)
    if (list) {
        list.addEventListener('click', function (e) {
            // Remove with confirm
            var rm = e.target.closest('.cart-item__remove');
            if (rm) {
                var item = rm.closest('.cart-item');
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
                return;
            }
            // Qty +/-
            var qtyBtn = e.target.closest('.qty-input__btn');
            if (qtyBtn) {
                var group = qtyBtn.closest('.qty-input');
                var input = group.querySelector('input');
                var isPlus = qtyBtn.textContent.trim() === '+';
                var n = parseInt(input.value) || 1;
                input.value = isPlus ? n + 1 : Math.max(1, n - 1);
                updateCartCount();
            }
        });
    }

    updateCartCount();
}

/* Badge + drawer count = total quantity; also recompute total price */
function updateCartCount() {
    var items = document.querySelectorAll('#cartList .cart-item');
    var totalQty = 0;
    var totalPrice = 0;

    items.forEach(function (it) {
        var input = it.querySelector('.qty-input input');
        var qty   = input ? (parseInt(input.value) || 1) : 1;
        var priceEl = it.querySelector('.cart-item__price');
        totalQty   += qty;
        totalPrice += parsePrice(priceEl ? priceEl.textContent : '') * qty;
    });

    var badge      = document.getElementById('cartBadge');
    var titleCount = document.getElementById('cartCount');
    if (badge)      badge.textContent = totalQty;
    if (titleCount) titleCount.textContent = totalQty;

    var totalEl = document.querySelector('.cart-drawer__total-value');
    if (totalEl) totalEl.innerHTML = formatPrice(totalPrice).replace('đ', '<sup>đ</sup>');

    // hide badge if empty
    if (badge) badge.style.display = totalQty > 0 ? '' : 'none';
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

    // Detail add to cart — paper plane fly + add to cart with qty
    var addCartBtn = document.getElementById('detailAddCart');
    if (addCartBtn) {
        addCartBtn.addEventListener('click', function () {
            // ảnh để bay: slide đang active, fallback ảnh đầu tiên
            var galleryImg = document.querySelector('.detail-gallery__main .owl-item.active img')
                          || document.querySelector('.detail-gallery__slide img');
            if (galleryImg) flyPaperPlane(galleryImg);

            // dữ liệu sản phẩm từ trang detail
            var nameEl  = document.querySelector('.detail-info__title');
            var priceEl = document.querySelector('.detail-info__price');
            var imgEl   = document.querySelector('.detail-gallery__slide img');
            var qtyEl   = document.getElementById('detailQtyInput');
            var qty     = qtyEl ? (parseInt(qtyEl.value) || 1) : 1;

            var data = {
                name:  nameEl  ? nameEl.textContent.trim()  : 'Sản phẩm',
                price: priceEl ? priceEl.textContent.trim() : '0đ',
                img:   imgEl   ? imgEl.getAttribute('src')  : ''
            };
            setTimeout(function () {
                for (var i = 0; i < qty; i++) addToCart(data);
            }, 400);
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
   #region PROFILE TABS
========================================== */
function initProfileTabs() {
    var links  = document.querySelectorAll('.profile-sidebar__link[data-tab]');
    var panels = document.querySelectorAll('.profile-tab[data-panel]');
    if (!links.length || !panels.length) return;

    function activate(tab) {
        // sidebar active state
        document.querySelectorAll('.profile-sidebar__link[data-tab]').forEach(function (l) {
            l.classList.toggle('is-active', l.dataset.tab === tab);
        });
        // panels
        panels.forEach(function (p) {
            p.classList.toggle('is-active', p.dataset.panel === tab);
        });
        // scroll up a bit
        window.scrollTo({ top: 280, behavior: 'smooth' });
    }

    // sidebar buttons
    links.forEach(function (link) {
        link.addEventListener('click', function () {
            activate(link.dataset.tab);
        });
    });

    // any inner element with data-tab (e.g. "Xem tất cả", "Chỉnh sửa")
    document.querySelectorAll('[data-tab]').forEach(function (el) {
        if (el.classList.contains('profile-sidebar__link')) return;
        el.addEventListener('click', function (e) {
            e.preventDefault();
            activate(el.dataset.tab);
        });
    });
}
/* #endregion */

/* ==========================================
   #region FAKE AUTH (demo: admin / 12456)
========================================== */
var FAKE_USER = { username: 'admin', password: '12456' };

function initFakeAuth() {
    var emailEl = document.getElementById('loginEmail');
    var passEl  = document.getElementById('loginPass');
    if (!emailEl || !passEl) return; // chỉ chạy ở trang login
    var form = emailEl.closest('form');
    if (!form) return;

    var submitBtn = form.querySelector('.auth-form__btn-submit');
    var msg = document.createElement('div');
    msg.className = 'auth-msg';
    if (submitBtn) form.insertBefore(msg, submitBtn);

    form.addEventListener('submit', function (e) {
        e.preventDefault();
        var u = emailEl.value.trim();
        var p = passEl.value;

        if (u === FAKE_USER.username && p === FAKE_USER.password) {
            try { localStorage.setItem('yuki_user', u); } catch (err) {}
            // Hiện modal Tarik chào mừng — KHÔNG tự tắt, bấm màn hình mới đóng rồi về trang chủ
            var m = document.getElementById('tarikModal');
            if (!m) { window.location.href = 'index.html'; return; }
            m.style.display = 'flex';
            setTimeout(function () { m.classList.add('tarik-modal--visible'); }, 20);
            setTimeout(function () {
                document.addEventListener('click', function onClk(e) {
                    if (e.target.closest('.tarik-modal__cta')) return; // nút CTA tự điều hướng
                    document.removeEventListener('click', onClk);
                    m.classList.remove('tarik-modal--visible');
                    setTimeout(function () { m.style.display = 'none'; window.location.href = 'index.html'; }, 400);
                });
            }, 120);
        } else {
            msg.className = 'auth-msg auth-msg--err';
            msg.innerHTML = '<i class="fa-solid fa-circle-exclamation"></i> Sai tài khoản hoặc mật khẩu! (admin / 12456)';
            form.classList.add('auth-shake');
            setTimeout(function () { form.classList.remove('auth-shake'); }, 500);
        }
    });
}
/* #endregion */

/* ==========================================
   #region AUTH STATE (gating đăng nhập)
========================================== */
function isLoggedIn() {
    try { return !!localStorage.getItem('yuki_user'); } catch (e) { return false; }
}

function getUserName() {
    try {
        var u = localStorage.getItem('yuki_user') || '';
        if (u.indexOf('@') > -1) u = u.split('@')[0];
        return u ? u.charAt(0).toUpperCase() + u.slice(1) : 'Game Thủ';
    } catch (e) { return 'Game Thủ'; }
}

function initAuthState() {
    // LARAVEL OVERRIDE: auth do server (session) quản lý, navbar @auth render sẵn user dropdown.
    // Bỏ qua logic localStorage (yuki_user) để không ghi đè link user về login.html.
    return;
    /* eslint-disable no-unreachable */
    var loggedIn = isLoggedIn();

    var userLink = document.querySelector('.navbar__actions a.navbar__icon-btn');
    if (userLink) {
        if (loggedIn) {
            buildUserDropdown(userLink);
        } else {
            // Chưa đăng nhập: giữ link tới login
            userLink.setAttribute('href', 'login.html');
            userLink.setAttribute('title', 'Đăng nhập');
            var icon = userLink.querySelector('i');
            if (icon) icon.className = 'fa-regular fa-user';
        }
    }

    // Bảo vệ trang profile: chưa đăng nhập thì đá về login
    var onProfile = /profile\.html$/i.test(window.location.pathname);
    if (onProfile && !loggedIn) {
        window.location.replace('login.html');
        return;
    }

    // Đăng xuất: xóa session rồi về trang chủ
    var logoutBtn = document.querySelector('.profile-sidebar__link--logout');
    if (logoutBtn) {
        logoutBtn.addEventListener('click', function (e) {
            e.preventDefault();
            try { localStorage.removeItem('yuki_user'); } catch (err) {}
            window.location.href = 'index.html';
        });
    }
}

/* ----- USER DROPDOWN (kiểu Facebook, phong cách YUKI) ----- */
function buildUserDropdown(userLink) {
    var name = getUserName();
    var initial = name.charAt(0).toUpperCase();

    // Bọc lại trong wrapper
    var wrap = document.createElement('div');
    wrap.className = 'user-menu';

    // Nút avatar
    var trigger = document.createElement('button');
    trigger.type = 'button';
    trigger.className = 'navbar__icon-btn user-menu__trigger';
    trigger.setAttribute('aria-label', 'Tài khoản');
    trigger.innerHTML = '<span class="user-menu__avatar">' + initial + '</span>';

    // Panel
    var panel = document.createElement('div');
    panel.className = 'user-menu__panel';
    panel.innerHTML =
        '<div class="user-menu__head">' +
            '<span class="user-menu__avatar user-menu__avatar--lg">' + initial + '</span>' +
            '<div class="user-menu__head-info">' +
                '<div class="user-menu__name">' + name + '</div>' +
                '<div class="user-menu__rank"><i class="fa-solid fa-bolt"></i> Game thủ YUKI</div>' +
            '</div>' +
        '</div>' +
        '<a href="profile.html" class="user-menu__profile-btn"><i class="fa-solid fa-id-badge"></i> Xem trang cá nhân</a>' +
        '<div class="user-menu__divider"></div>' +
        '<a href="order-history.html" class="user-menu__item"><span class="user-menu__ico"><i class="fa-solid fa-box-archive"></i></span> Đơn hàng của tôi <i class="fa-solid fa-chevron-right user-menu__arr"></i></a>' +
        '<a href="profile.html" class="user-menu__item"><span class="user-menu__ico"><i class="fa-solid fa-heart"></i></span> Sản phẩm yêu thích <i class="fa-solid fa-chevron-right user-menu__arr"></i></a>' +
        '<a href="contact.html" class="user-menu__item"><span class="user-menu__ico"><i class="fa-solid fa-circle-question"></i></span> Trợ giúp & hỗ trợ <i class="fa-solid fa-chevron-right user-menu__arr"></i></a>' +
        '<div class="user-menu__divider"></div>' +
        '<button type="button" class="user-menu__item user-menu__item--logout" id="userMenuLogout"><span class="user-menu__ico"><i class="fa-solid fa-right-from-bracket"></i></span> Đăng xuất</button>' +
        '<div class="user-menu__foot">YUKI Gaming Store · v2.0</div>';

    wrap.appendChild(trigger);
    wrap.appendChild(panel);
    userLink.replaceWith(wrap);

    // Toggle
    trigger.addEventListener('click', function (e) {
        e.stopPropagation();
        wrap.classList.toggle('is-open');
    });
    document.addEventListener('click', function (e) {
        if (!wrap.contains(e.target)) wrap.classList.remove('is-open');
    });
    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') wrap.classList.remove('is-open');
    });

    // Logout
    panel.querySelector('#userMenuLogout').addEventListener('click', function () {
        try { localStorage.removeItem('yuki_user'); } catch (err) {}
        window.location.href = 'index.html';
    });
}
/* #endregion */

/* ==========================================
   #region PRODUCT LINKS (mọi sản phẩm -> detail.html)
========================================== */
function initProductLinks() {
    var cards = document.querySelectorAll('.p-card, .deal-card, .top-card, .wishlist-card');
    cards.forEach(function (card) {
        card.style.cursor = 'pointer';
        card.addEventListener('click', function (e) {
            // bỏ qua khi bấm nút hành động / link / swatch
            if (e.target.closest('button, a, .swatch, .p-card__quick, .wishlist-card__heart')) return;
            window.location.href = 'detail.html';
        });
    });
}
/* #endregion */

/* ==========================================
   #region SETUPS FILTER (Góc Game Thủ)
========================================== */
function initSetupsFilter() {
    var btns  = document.querySelectorAll('.setups-filter__btn');
    var cards = document.querySelectorAll('.setup-card');
    if (!btns.length || !cards.length) return;

    btns.forEach(function (btn) {
        btn.addEventListener('click', function () {
            btns.forEach(function (b) { b.classList.remove('is-active'); });
            btn.classList.add('is-active');

            var cat = btn.dataset.cat;
            cards.forEach(function (card) {
                var show = (cat === 'all' || card.dataset.cat === cat);
                card.classList.toggle('is-hidden', !show);
            });

            if (typeof AOS !== 'undefined') AOS.refresh();
        });
    });
}
/* #endregion */

/* ==========================================
   #region COUNT-UP STATS (About page)
========================================== */
function initCountUp() {
    var nums = document.querySelectorAll('.about-stat__num[data-count]');
    if (!nums.length) return;

    function animate(el) {
        var target = parseInt(el.dataset.count, 10) || 0;
        var dur = 1600;
        var start = null;
        function step(ts) {
            if (!start) start = ts;
            var p = Math.min((ts - start) / dur, 1);
            // easeOutQuart
            var eased = 1 - Math.pow(1 - p, 4);
            var val = Math.floor(eased * target);
            el.textContent = val.toLocaleString('vi-VN');
            if (p < 1) requestAnimationFrame(step);
            else el.textContent = target.toLocaleString('vi-VN');
        }
        requestAnimationFrame(step);
    }

    if ('IntersectionObserver' in window) {
        var obs = new IntersectionObserver(function (entries) {
            entries.forEach(function (en) {
                if (en.isIntersecting) {
                    animate(en.target);
                    obs.unobserve(en.target);
                }
            });
        }, { threshold: 0.4 });
        nums.forEach(function (n) { obs.observe(n); });
    } else {
        nums.forEach(animate);
    }
}
/* #endregion */

/* ==========================================
   #region CART PAGE (trang giỏ hàng)
========================================== */
function initCartPage() {
    var list = document.querySelector('.cart-page__list');
    if (!list) return; // chỉ chạy ở cart.html

    var FREE_SHIP = 500000;       // mốc freeship
    var discountRate = 0;          // % giảm theo coupon

    var fmt = function (n) { return n.toLocaleString('vi-VN') + 'đ'; };

    function recompute(bumpEl) {
        var rows = list.querySelectorAll('.cart-page__item');
        var subtotal = 0, totalQty = 0;

        rows.forEach(function (row) {
            var price = parseInt(row.dataset.price, 10) || 0;
            var input = row.querySelector('.cart-page__qty-input');
            var qty   = input ? (parseInt(input.value) || 1) : 1;
            var line  = price * qty;
            subtotal += line;
            totalQty += qty;
            var lineEl = row.querySelector('.cart-page__line-total');
            if (lineEl) lineEl.textContent = fmt(line);
        });

        var discount = Math.round(subtotal * discountRate);
        var total = subtotal - discount;

        var subEl = document.getElementById('cartPageSubtotal');
        var disEl = document.querySelector('.cart-page__summary-row .txt-red');
        var totEl = document.getElementById('cartPageTotal');
        if (subEl) subEl.textContent = fmt(subtotal);
        if (disEl) disEl.textContent = '-' + fmt(discount);
        if (totEl) totEl.textContent = total.toLocaleString('vi-VN') + ' VND';

        // bump animation
        if (totEl) { totEl.classList.remove('is-bumped'); void totEl.offsetWidth; totEl.classList.add('is-bumped'); }
        if (bumpEl) { bumpEl.classList.remove('is-bumped'); void bumpEl.offsetWidth; bumpEl.classList.add('is-bumped'); }

        // freeship progress
        var fill = document.getElementById('cartPageProgressFill');
        var note = document.getElementById('cartPageProgressNote');
        var pct = Math.min(100, subtotal / FREE_SHIP * 100);
        if (fill) fill.style.width = pct + '%';
        if (note) {
            note.innerHTML = subtotal >= FREE_SHIP
                ? '<i class="fa-solid fa-truck-fast"></i> Ban duoc giao hang mien phi!'
                : 'Mua them ' + fmt(FREE_SHIP - subtotal) + ' de duoc FREESHIP!';
        }

        // empty state
        var empty = document.getElementById('cartPageEmpty');
        if (empty) empty.classList.toggle('is-show', rows.length === 0);

        // sync navbar badge
        var badge = document.getElementById('cartBadge');
        if (badge) { badge.textContent = totalQty; badge.style.display = totalQty > 0 ? '' : 'none'; }
    }

    // Delegated clicks: qty +/- và remove
    list.addEventListener('click', function (e) {
        var row = e.target.closest('.cart-page__item');
        if (!row) return;

        if (e.target.closest('[data-cart-plus]')) {
            var inp = row.querySelector('.cart-page__qty-input');
            inp.value = (parseInt(inp.value) || 1) + 1;
            recompute(row.querySelector('.cart-page__line-total'));
            return;
        }
        if (e.target.closest('[data-cart-minus]')) {
            var inp2 = row.querySelector('.cart-page__qty-input');
            inp2.value = Math.max(1, (parseInt(inp2.value) || 1) - 1);
            recompute(row.querySelector('.cart-page__line-total'));
            return;
        }
        if (e.target.closest('.cart-page__remove')) {
            var nameEl = row.querySelector('.cart-page__name');
            var name = nameEl ? nameEl.textContent.trim() : 'san pham nay';
            (typeof showConfirm === 'function' ? showConfirm(name) : Promise.resolve(confirm('Xoa?')))
                .then(function (ok) {
                    if (!ok) return;
                    row.classList.add('is-removing');
                    setTimeout(function () { row.remove(); recompute(); }, 300);
                });
        }
    });

    // Coupon
    var couponBtn = document.getElementById('cartCouponBtn');
    if (couponBtn) {
        couponBtn.addEventListener('click', function () {
            var input = document.getElementById('cartCoupon');
            var msg   = document.getElementById('cartCouponMsg');
            var code  = (input.value || '').trim().toUpperCase();
            var codes = { 'YUKISALE': 0.1, 'YUKI50': 0.5, 'GAMING5': 0.05 };

            if (codes[code]) {
                discountRate = codes[code];
                if (msg) { msg.className = 'cart-page__coupon-msg is-ok'; msg.textContent = 'Ap dung ma "' + code + '" thanh cong! Giam ' + (discountRate * 100) + '%.'; }
            } else {
                discountRate = 0;
                if (msg) { msg.className = 'cart-page__coupon-msg is-err'; msg.textContent = 'Ma uu dai khong hop le!'; }
            }
            recompute();
        });
    }

    recompute();
}
/* #endregion */

/* ==========================================
   #region REGISTER (demo)
========================================== */
function initFakeRegister() {
    var form = document.getElementById('registerForm');
    if (!form) return;
    var name  = document.getElementById('regName');
    var email = document.getElementById('regEmail');
    var p1    = document.getElementById('regPass');
    var p2    = document.getElementById('regPass2');

    var msg = document.createElement('div');
    msg.className = 'auth-msg';
    var submitBtn = form.querySelector('.auth-form__btn-submit');
    if (submitBtn) form.insertBefore(msg, submitBtn);

    form.addEventListener('submit', function (e) {
        e.preventDefault();
        if (p1.value !== p2.value) {
            msg.className = 'auth-msg auth-msg--err';
            msg.innerHTML = '<i class="fa-solid fa-circle-exclamation"></i> Mật khẩu xác nhận không khớp!';
            form.classList.add('auth-shake');
            setTimeout(function () { form.classList.remove('auth-shake'); }, 500);
            return;
        }
        msg.className = 'auth-msg auth-msg--ok';
        msg.innerHTML = '<i class="fa-solid fa-circle-check"></i> Tạo tài khoản thành công! Đang đăng nhập...';
        try { localStorage.setItem('yuki_user', (email.value || name.value || '').trim()); } catch (err) {}
        setTimeout(function () { window.location.href = 'index.html'; }, 1000);
    });
}
/* #endregion */

/* ==========================================
   #region FORGOT PASSWORD
========================================== */
function initForgotPassword() {
    var form = document.getElementById('forgotForm');
    var email = document.getElementById('forgotEmail');
    var msg = document.getElementById('forgotMsg');
    if (!form || !email) return;

    form.addEventListener('submit', function (e) {
        e.preventDefault();
        if (!email.value.trim()) { return; }
        if (msg) {
            msg.className = 'auth-msg auth-msg--ok';
            msg.innerHTML = '<i class="fa-solid fa-circle-check"></i> Đã gửi link đặt lại tới ' + email.value.trim() + '. Vui lòng kiểm tra email!';
        }
        var btn = form.querySelector('.auth-form__btn-submit');
        if (btn) { btn.textContent = 'ĐÃ GỬI ✓'; }
        email.value = '';
    });
}
/* #endregion */

/* ==========================================
   #region SHOP / PRODUCTS FILTER
========================================== */
function initShop() {
    var grid = document.getElementById('shopGrid');
    if (!grid) return;

    var cards   = Array.prototype.slice.call(grid.querySelectorAll('.p-card'));
    var catBtns = document.querySelectorAll('#shopCats .shop-cat');
    var priceBtns = document.querySelectorAll('#shopPrice .shop-cat');
    var countEl = document.getElementById('shopCount');
    var emptyEl = document.getElementById('shopEmpty');
    var sortEl  = document.getElementById('shopSort');

    var state = { cat: 'all', min: 0, max: 999999999 };

    function apply() {
        var shown = 0;
        cards.forEach(function (c) {
            var price = parseInt(c.dataset.price, 10) || 0;
            var okCat = (state.cat === 'all' || c.dataset.cat === state.cat);
            var okPrice = (price >= state.min && price <= state.max);
            var show = okCat && okPrice;
            c.classList.toggle('is-hidden', !show);
            if (show) shown++;
        });
        if (countEl) countEl.textContent = shown;
        if (emptyEl) emptyEl.classList.toggle('is-show', shown === 0);
        if (typeof AOS !== 'undefined') AOS.refresh();
    }

    catBtns.forEach(function (btn) {
        btn.addEventListener('click', function () {
            catBtns.forEach(function (b) { b.classList.remove('is-active'); });
            btn.classList.add('is-active');
            state.cat = btn.dataset.cat;
            apply();
        });
    });
    priceBtns.forEach(function (btn) {
        btn.addEventListener('click', function () {
            priceBtns.forEach(function (b) { b.classList.remove('is-active'); });
            btn.classList.add('is-active');
            state.min = parseInt(btn.dataset.min, 10) || 0;
            state.max = parseInt(btn.dataset.max, 10) || 999999999;
            apply();
        });
    });

    // Sort
    function priceOf(c) { return parseInt(c.dataset.price, 10) || 0; }
    if (sortEl) {
        sortEl.addEventListener('change', function () {
            var v = sortEl.value;
            var sorted = cards.slice();
            if (v === 'price-asc')  sorted.sort(function (a, b) { return priceOf(a) - priceOf(b); });
            else if (v === 'price-desc') sorted.sort(function (a, b) { return priceOf(b) - priceOf(a); });
            else if (v === 'name')  sorted.sort(function (a, b) { return (a.dataset.name || '').localeCompare(b.dataset.name || ''); });
            sorted.forEach(function (c) { grid.appendChild(c); });
        });
    }

    // Preselect category from ?cat=
    var params = new URLSearchParams(window.location.search);
    var qcat = params.get('cat');
    if (qcat) {
        var match = Array.prototype.slice.call(catBtns).filter(function (b) { return b.dataset.cat === qcat; })[0];
        if (match) {
            catBtns.forEach(function (b) { b.classList.remove('is-active'); });
            match.classList.add('is-active');
            state.cat = qcat;
        }
    }

    // count "all" badge
    var allBadge = document.getElementById('catCountAll');
    if (allBadge) allBadge.textContent = cards.length;

    apply();
}
/* #endregion */

/* ==========================================
   #region CHECKOUT PAGE
========================================== */
function initCheckout() {
    var form = document.getElementById('checkoutForm');
    if (!form) return; // chỉ chạy ở checkout.html

    // [YUKI] Vô hiệu hoá handler demo tĩnh: trang checkout dùng JS RIÊNG trong blade
    // (submit thật lên server, coupon AJAX thật, tự cập nhật phí ship). Tránh xung đột
    // (handler cũ preventDefault submit + đọc sai name="ship" + coupon giả).
    return;

    var FREE_SHIP_MIN = 500000;
    var discountRate = 0;
    var fmt = function (n) { return n.toLocaleString('vi-VN') + 'đ'; };

    function subtotal() {
        var s = 0;
        document.querySelectorAll('.co-sum-item').forEach(function (it) {
            s += parseInt(it.dataset.price, 10) || 0;
        });
        return s;
    }
    function shipFee() {
        var sel = form.querySelector('input[name="ship"]:checked');
        var fee = sel ? (parseInt(sel.value, 10) || 0) : 0;
        // freeship tiêu chuẩn nếu đạt mốc
        if (sel && sel.value === '0') return 0;
        return fee;
    }

    function recompute() {
        var sub = subtotal();
        var ship = shipFee();
        var discount = Math.round(sub * discountRate);
        var total = sub + ship - discount;

        var subEl = document.getElementById('coSubtotal');
        var shipEl = document.getElementById('coShip');
        var disEl = document.getElementById('coDiscount');
        var totEl = document.getElementById('coTotal');
        if (subEl) subEl.textContent = fmt(sub);
        if (shipEl) shipEl.textContent = ship === 0 ? 'Miễn phí' : fmt(ship);
        if (disEl) disEl.textContent = '-' + fmt(discount);
        if (totEl) totEl.textContent = fmt(total);
    }

    // Chọn option (ship/pay): toggle is-selected
    form.querySelectorAll('.co-option').forEach(function (opt) {
        opt.addEventListener('click', function () {
            var input = opt.querySelector('input');
            if (!input) return;
            input.checked = true;
            // bỏ chọn các option cùng nhóm
            form.querySelectorAll('input[name="' + input.name + '"]').forEach(function (i) {
                i.closest('.co-option').classList.toggle('is-selected', i.checked);
            });
            recompute();
        });
    });

    // Coupon
    var couponBtn = document.getElementById('coCouponBtn');
    if (couponBtn) {
        couponBtn.addEventListener('click', function () {
            var code = (document.getElementById('coCoupon').value || '').trim().toUpperCase();
            var msg = document.getElementById('coCouponMsg');
            var codes = { 'YUKISALE': 0.1, 'YUKI50': 0.5, 'GAMING5': 0.05 };
            if (codes[code]) {
                discountRate = codes[code];
                if (msg) { msg.className = 'co-coupon-msg is-ok'; msg.textContent = 'Áp dụng mã "' + code + '" — giảm ' + (discountRate * 100) + '%.'; }
            } else {
                discountRate = 0;
                if (msg) { msg.className = 'co-coupon-msg is-err'; msg.textContent = 'Mã ưu đãi không hợp lệ!'; }
            }
            recompute();
        });
    }

    // Đặt hàng -> hiện overlay thành công
    form.addEventListener('submit', function (e) {
        e.preventDefault();
        if (!form.checkValidity()) { form.reportValidity(); return; }
        var overlay = document.getElementById('orderSuccess');
        var codeEl = document.getElementById('orderCode');
        if (codeEl) {
            var rnd = Math.floor(100000 + Math.random() * 900000);
            codeEl.textContent = '#YUKI-' + rnd;
        }
        if (overlay) {
            overlay.classList.add('is-open');
            document.body.classList.add('is-locked');
        }
    });

    recompute();
}
/* #endregion */

/* ==========================================
   #region CONTACT FORM
========================================== */
function initContactForm() {
    var form = document.getElementById('contactForm');
    var ok   = document.getElementById('contactSuccess');
    if (!form) return;

    form.addEventListener('submit', function (e) {
        e.preventDefault();
        if (ok) ok.classList.add('is-show');
        var btn = form.querySelector('.contact-form__submit');
        if (btn) {
            var original = btn.innerHTML;
            btn.innerHTML = 'ĐÃ GỬI <i class="fa-solid fa-check ms-2"></i>';
            setTimeout(function () { btn.innerHTML = original; }, 2500);
        }
        // reset fields (giữ lại thông báo)
        form.querySelectorAll('input, textarea').forEach(function (f) { f.value = ''; });
        setTimeout(function () { if (ok) ok.classList.remove('is-show'); }, 4000);
    });
}
/* #endregion */

/* ==========================================
   #region AUTH TRANSITIONS
   Slide ngang (login ↔ register) và xoay tại chỗ (login ↔ forgot)
   Dùng data-transition="slide-left|slide-right|spin" + data-slide-to="url"
========================================== */
function initAuthTransitions() {
    var SLIDE_MS = 480;
    var SPIN_MS  = 420;

    /* đọc loại enter từ query string ?_et= */
    var qs        = new URLSearchParams(location.search);
    var enterType = qs.get('_et') || 'slide-right';
    var panel     = document.getElementById('authPanel');

    /* --- enter animation khi trang load (chỉ khi còn dùng #authPanel) --- */
    if (panel) {
        var startCSS = '';
        if (enterType === 'slide-left')  startCSS = 'translateX(-110%)';
        if (enterType === 'slide-right') startCSS = 'translateX(110%)';
        if (enterType === 'spin')        startCSS = 'perspective(900px) rotateY(-90deg) scale(0.85)';

        panel.style.transform  = startCSS;
        panel.style.opacity    = '0';
        panel.style.transition = 'none';

        requestAnimationFrame(function () {
            requestAnimationFrame(function () {
                var dur = (enterType === 'spin') ? SPIN_MS : SLIDE_MS;
                panel.style.transition =
                    'transform ' + dur + 'ms cubic-bezier(0.25,0.46,0.45,0.94),' +
                    'opacity '   + (dur * 0.55) + 'ms ease';
                panel.style.transform = (enterType === 'spin')
                    ? 'perspective(900px) rotateY(0deg) scale(1)'
                    : 'translateX(0)';
                panel.style.opacity = '1';
            });
        });
    }

    /* --- exit + navigate --- */
    function goTo(url, exitType) {
        var exitCSS, enterNext, dur;

        if (exitType === 'slide-left') {
            exitCSS   = 'translateX(-110%)';
            enterNext = 'slide-right';
            dur       = SLIDE_MS;
        } else if (exitType === 'slide-right') {
            exitCSS   = 'translateX(110%)';
            enterNext = 'slide-left';
            dur       = SLIDE_MS;
        } else {
            exitCSS   = 'perspective(900px) rotateY(90deg) scale(0.85)';
            enterNext = 'spin';
            dur       = SPIN_MS;
        }

        panel.style.transition =
            'transform ' + dur + 'ms cubic-bezier(0.55,0.055,0.675,0.19),' +
            'opacity '   + (dur * 0.45) + 'ms ease ' + (dur * 0.3) + 'ms';
        panel.style.transform = exitCSS;
        panel.style.opacity   = '0';

        setTimeout(function () {
            var sep = url.indexOf('?') > -1 ? '&' : '?';
            location.href = url + sep + '_et=' + enterNext;
        }, dur + 30);
    }

    document.querySelectorAll('[data-transition]').forEach(function (el) {
        el.addEventListener('click', function (e) {
            e.preventDefault();
            var target = this.dataset.slideTo || this.getAttribute('href');
            goTo(target, this.dataset.transition);
        });
    });

}
/* #endregion */

/* ==========================================
   #region AUTH SWITCHER — Double-slider (login ↔ register) + forgot
   Panel màu trượt ngang; quên mật khẩu hiện đè lên form login.
========================================== */
function initAuthSwitcher() {
    var box = document.getElementById('sliderAuth');
    if (!box) return;

    function show(view) {
        box.classList.remove('is-register', 'is-forgot');
        if (view === 'register') box.classList.add('is-register');
        else if (view === 'forgot') box.classList.add('is-forgot');
        try { history.replaceState(null, '', '#' + view); } catch (e) {}
    }

    // Nút ghost trên overlay
    var goReg = document.getElementById('goRegister');
    var goLog = document.getElementById('goLogin');
    if (goReg) goReg.addEventListener('click', function () { show('register'); });
    if (goLog) goLog.addEventListener('click', function () { show('login'); });

    // Link trong form (mobile switch + quên mật khẩu + quay lại)
    box.querySelectorAll('[data-auth-view]').forEach(function (link) {
        link.addEventListener('click', function (e) {
            e.preventDefault();
            show(this.dataset.authView);
        });
    });

    // Hash ban đầu
    var initial = (location.hash || '').replace('#', '');
    if (initial === 'register' || initial === 'forgot') show(initial);
}
/* #endregion */

/* ==========================================
   INIT
========================================== */
document.addEventListener('DOMContentLoaded', function () {
    initTogglePassword();
    initFakeAuth();
    initFakeRegister();
    initAuthState();
    initProductLinks();
    initSetupsFilter();
    initCountUp();
    initCartPage();
    initCheckout();
    initForgotPassword();
    initShop();
    initContactForm();
    initSiteBackground();
    initHeroParticles();
    initBackToTop();
    initNavbar();
    initHeroSlider();
    initSaleCarousel();
    initCountdown();
    initAOS();
    initSearchOverlay();
    initCartDrawer();
    initFlyToCart();
    initDetailPage();
    initProfileTabs();
    initAuthParallax();
    initAuthTransitions();
    initAuthSwitcher();
});
