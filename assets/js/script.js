/* ==========================================
   #region AUTH
========================================== */
function initTogglePassword() {
    document.querySelectorAll('.toggle-password').forEach(function (btn) {
        btn.addEventListener('click', function () {
            const container = this.closest('.input-group');
            if (!container) return;
            const input = container.querySelector('input');
            const icon  = this.querySelector('i');
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
    const toggle = document.getElementById('navToggle');
    const menu   = document.getElementById('navMenu');
    if (!toggle || !menu) return;

    toggle.addEventListener('click', function () {
        menu.classList.toggle('is-open');
    });

    document.addEventListener('click', function (e) {
        if (!toggle.contains(e.target) && !menu.contains(e.target)) {
            menu.classList.remove('is-open');
        }
    });
}
/* #endregion */

/* ==========================================
   #region HERO
========================================== */
function initHeroSlider() {
    const next      = document.getElementById('nextBtn');
    const prev      = document.getElementById('prevBtn');
    const track     = document.getElementById('heroTrack');
    const heroTitle = document.getElementById('heroTitle');
    const heroDesc  = document.getElementById('heroDesc');

    if (!track || !next || !prev) return;

    function updateHero() {
        const items  = track.querySelectorAll('.hero-card');
        const active = items[1];
        if (!active) return;

        heroTitle.innerText = active.dataset.title;
        heroDesc.innerText  = active.dataset.desc;

        const heroBg = document.getElementById('heroBg');
        if (heroBg) {
            heroBg.style.backgroundImage    = active.style.backgroundImage;
            heroBg.style.backgroundSize     = 'cover';
            heroBg.style.backgroundPosition = 'center';
            heroBg.style.filter             = 'blur(24px) brightness(0.25)';
        }
    }

    next.addEventListener('click', function () {
        const items = track.querySelectorAll('.hero-card');
        track.appendChild(items[0]);
        updateHero();
    });

    prev.addEventListener('click', function () {
        const items = track.querySelectorAll('.hero-card');
        track.prepend(items[items.length - 1]);
        updateHero();
    });

    setInterval(function () { next.click(); }, 6000);

    updateHero();
}
/* #endregion */

/* ==========================================
   #region SALE SLIDER
========================================== */
function initSaleSlider() {
    var wrap  = document.querySelector('.sale-track-wrap');
    var track = document.getElementById('saleTrack');
    var prev  = document.getElementById('salePrev');
    var next  = document.getElementById('saleNext');
    if (!wrap || !track) return;

    var VISIBLE  = 3;
    var GAP      = 12;
    var current  = 0;
    var cards    = track.querySelectorAll('.sale-card');
    var maxSlide = cards.length - VISIBLE;

    function setWidths() {
        var w = (wrap.offsetWidth - GAP * (VISIBLE - 1)) / VISIBLE;
        cards.forEach(function (c) { c.style.width = w + 'px'; c.style.minWidth = w + 'px'; });
        return w;
    }

    var cardW = setWidths();
    window.addEventListener('resize', function () { cardW = setWidths(); slide(); });

    function slide() {
        track.style.transform = 'translateX(-' + current * (cardW + GAP) + 'px)';
    }

    next && next.addEventListener('click', function () { if (current < maxSlide) { current++; slide(); } });
    prev && prev.addEventListener('click', function () { if (current > 0) { current--; slide(); } });
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

    var total = 2 * 3600 + 45 * 60 + 7;
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
   INIT
========================================== */
document.addEventListener('DOMContentLoaded', function () {
    initTogglePassword();
    initNavbar();
    initHeroSlider();
    initSaleSlider();
    initCountdown();
});
