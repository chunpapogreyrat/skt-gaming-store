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
   #region DEALS CAROUSEL (Owl Carousel)
========================================== */
function initDealsCarousel() {
    if (typeof $ === 'undefined' || typeof $.fn.owlCarousel === 'undefined') return;
    $('.deals-carousel').owlCarousel({
        loop:      true,
        margin:    12,
        nav:       true,
        dots:      true,
        autoplay:  true,
        autoplayTimeout: 4000,
        autoplayHoverPause: true,
        navText: [
            '<i class="fa-solid fa-chevron-left"></i>',
            '<i class="fa-solid fa-chevron-right"></i>'
        ],
        responsive: {
            0:   { items: 1 },
            576: { items: 2 },
            992: { items: 3 }
        }
    });
}
/* #endregion */

/* ==========================================
   #region COUNTDOWN TIMER
========================================== */
function initCountdown() {
    var hEl = document.getElementById('timerH');
    var mEl = document.getElementById('timerM');
    var sEl = document.getElementById('timerS');
    if (!hEl) return;
    var total = 5 * 3600 + 59 * 60 + 59;
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
   #region AOS (Animate On Scroll)
========================================== */
function initAOS() {
    if (typeof AOS === 'undefined') return;
    AOS.init({
        duration: 700,
        easing:   'ease-out-cubic',
        once:     true,
        offset:   60
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
    initDealsCarousel();
    initCountdown();
    initAOS();
});
