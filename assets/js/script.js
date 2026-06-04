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
    AOS.init({
        duration: 750,
        easing: 'ease-out-cubic',
        once: false,        // chạy lại mỗi lần phần tử vào khung nhìn
        mirror: true,       // animate cả khi cuộn LÊN (phần tử rời khung nhìn)
        offset: 80,
        anchorPlacement: 'top-bottom'
    });

    // refresh khi ảnh/layout đổi để tính lại vị trí trigger
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
    // Event delegation: hoạt động kể cả với card thêm sau, không phụ thuộc thứ tự init
    document.addEventListener('click', function (e) {
        var btn = e.target.closest('.p-card__quick');
        if (!btn) return;
        e.preventDefault();
        e.stopPropagation();
        flyPaperPlane(btn);
        var card = btn.closest('.p-card');
        setTimeout(function () { addToCart(readCardData(card)); }, 400);
    }, true); // capture phase: chạy TRƯỚC handler điều hướng của .p-card
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
            msg.className = 'auth-msg auth-msg--ok';
            msg.innerHTML = '<i class="fa-solid fa-circle-check"></i> Đăng nhập thành công! Đang chuyển hướng...';
            try { localStorage.setItem('skt_user', u); } catch (err) {}
            setTimeout(function () { window.location.href = 'index.html'; }, 900);
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
    try { return !!localStorage.getItem('skt_user'); } catch (e) { return false; }
}

function initAuthState() {
    var loggedIn = isLoggedIn();

    // Icon profile: đã login -> profile.html, chưa login -> login.html
    var userLink = document.querySelector('.navbar__actions a.navbar__icon-btn');
    if (userLink) {
        userLink.setAttribute('href', loggedIn ? 'profile.html' : 'login.html');
        userLink.setAttribute('title', loggedIn ? 'Tài khoản của tôi' : 'Đăng nhập');
        var icon = userLink.querySelector('i');
        if (icon) {
            icon.className = loggedIn ? 'fa-solid fa-user' : 'fa-regular fa-user';
        }
        userLink.classList.toggle('navbar__icon-btn--active', loggedIn);
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
            try { localStorage.removeItem('skt_user'); } catch (err) {}
            window.location.href = 'index.html';
        });
    }
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

    var fmt = function (n) { return n.toLocaleString('vi-VN') + 'd'; };

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
            var codes = { 'SKTSALE': 0.1, 'SKT50': 0.5, 'GAMING5': 0.05 };

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
   INIT
========================================== */
document.addEventListener('DOMContentLoaded', function () {
    initTogglePassword();
    initFakeAuth();
    initAuthState();
    initProductLinks();
    initSetupsFilter();
    initCountUp();
    initCartPage();
    initContactForm();
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
});
