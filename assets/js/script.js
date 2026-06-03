/* ==========================================
   AUTH MODULE
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

/* ==========================================
   HERO SLIDER
========================================== */
const HERO_SLIDES = [
    {
        badge: 'SẢN PHẨM MỚI NHẤT',
        titleLines: ['RAZER', 'HUNTSMAN', '<span class="hero__hl">V3 PRO MINI</span>'],
        desc: 'Thế hệ bàn phím mini tiên tiến nhất từ Razer. Công tắc quang học thế hệ 2 cho tốc độ phản hồi cực đại và độ bền không tưởng.',
        img: 'assets/images/huntsmanv3pro.jpg',
        bg:  'assets/images/slider/1.jpg',
    },
    {
        badge: 'HOT NHẤT THÁNG',
        titleLines: ['FINALMOUSE', 'MAYA X', '<span class="hero__hl">FNATIC</span>'],
        desc: 'Chuột gaming siêu nhẹ dành riêng cho game thủ Esports chuyên nghiệp. Sensor PAW3395 bậc nhất thế giới, trọng lượng chỉ 41g.',
        img: 'assets/images/mayaxfnatic.jpg',
        bg:  'assets/images/slider/2.jpg',
    },
    {
        badge: 'BÁN CHẠY SỐ 1',
        titleLines: ['WOOTING', '60HE', '<span class="hero__hl">ANALOG</span>'],
        desc: 'Bàn phím Hall Effect đầu tiên với Rapid Trigger. Công nghệ analog tiên tiến nhất cho game thủ Esports tranh đấu đỉnh cao.',
        img: 'assets/images/wooting60he.jpg',
        bg:  'assets/images/slider/3.jpg',
    },
    {
        badge: 'ĐỘC QUYỀN',
        titleLines: ['BENQ ZOWIE', 'XL2566K', '<span class="hero__hl">360HZ</span>'],
        desc: 'Màn hình 360Hz chuyên dụng cho Esports. DyAc+ technology giúp hình ảnh cực mượt, không bóng mờ, phản hồi 0.5ms.',
        img: 'assets/images/BenqXL2566K.jpg',
        bg:  'assets/images/slider/4.jpg',
    },
];

let currentSlide   = 0;
let heroAutoTimer  = null;

function goToSlide(idx) {
    const slide    = HERO_SLIDES[idx];
    const imgEl    = document.getElementById('heroMainImg');
    const bgEl     = document.getElementById('heroBg');
    const badgeEl  = document.getElementById('heroBadge');
    const titleEl  = document.getElementById('heroTitle');
    const descEl   = document.getElementById('heroDesc');

    if (!imgEl) return;

    [badgeEl, titleEl, descEl, imgEl].forEach(el => {
        if (el) { el.style.opacity = '0'; el.style.transform = 'translateY(10px)'; }
    });

    setTimeout(function () {
        if (bgEl)    bgEl.style.backgroundImage = "url('" + slide.bg + "')";
        if (badgeEl) badgeEl.textContent = slide.badge;
        if (titleEl) titleEl.innerHTML   = slide.titleLines.join('<br>');
        if (descEl)  descEl.textContent  = slide.desc;
        if (imgEl)   imgEl.src           = slide.img;

        [badgeEl, titleEl, descEl, imgEl].forEach(el => {
            if (el) { el.style.opacity = '1'; el.style.transform = ''; }
        });

        document.querySelectorAll('.hero-dot').forEach(function (d, i) {
            d.classList.toggle('active', i === idx);
        });

        renderHeroThumbs(idx);
    }, 340);

    currentSlide = idx;
}

function renderHeroThumbs(activeIdx) {
    const container = document.getElementById('heroThumbs');
    if (!container) return;
    container.innerHTML = '';
    for (var i = 1; i <= 2; i++) {
        var idx   = (activeIdx + i) % HERO_SLIDES.length;
        var slide = HERO_SLIDES[idx];
        var div   = document.createElement('div');
        div.className = 'hero-thumb';
        div.innerHTML = '<img src="' + slide.img + '" alt="">';
        div.addEventListener('click', (function (capturedIdx) {
            return function () {
                clearInterval(heroAutoTimer);
                goToSlide(capturedIdx);
                startHeroAuto();
            };
        })(idx));
        container.appendChild(div);
    }
}

function startHeroAuto() {
    heroAutoTimer = setInterval(function () {
        goToSlide((currentSlide + 1) % HERO_SLIDES.length);
    }, 5000);
}

function initHeroSlider() {
    var bgEl = document.getElementById('heroBg');
    if (!bgEl) return;

    bgEl.style.backgroundImage = "url('" + HERO_SLIDES[0].bg + "')";
    renderHeroThumbs(0);

    document.querySelectorAll('.hero-dot').forEach(function (dot) {
        dot.addEventListener('click', function () {
            var idx = parseInt(this.dataset.idx);
            clearInterval(heroAutoTimer);
            goToSlide(idx);
            startHeroAuto();
        });
    });

    startHeroAuto();
}

/* ==========================================
   SALE SLIDER
========================================== */
function initSaleSlider() {
    var wrap  = document.querySelector('.sale-track-wrap');
    var track = document.getElementById('saleTrack');
    var prev  = document.getElementById('salePrev');
    var next  = document.getElementById('saleNext');
    if (!wrap || !track) return;

    var VISIBLE = 3;
    var GAP     = 12;
    var current = 0;
    var cards   = track.querySelectorAll('.sale-card');
    var total   = cards.length;
    var maxSlide = total - VISIBLE;

    function setCardWidths() {
        var wrapW = wrap.offsetWidth;
        var cardW = (wrapW - GAP * (VISIBLE - 1)) / VISIBLE;
        cards.forEach(function (c) {
            c.style.width    = cardW + 'px';
            c.style.minWidth = cardW + 'px';
        });
        return cardW;
    }

    var cardW = setCardWidths();
    window.addEventListener('resize', function () { cardW = setCardWidths(); slide(); });

    function slide() {
        track.style.transform = 'translateX(-' + (current * (cardW + GAP)) + 'px)';
    }

    next && next.addEventListener('click', function () {
        if (current < maxSlide) { current++; slide(); }
    });
    prev && prev.addEventListener('click', function () {
        if (current > 0) { current--; slide(); }
    });
}

/* ==========================================
   COUNTDOWN TIMER
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

/* ==========================================
   INIT
========================================== */
document.addEventListener('DOMContentLoaded', function () {
    initTogglePassword();
    initHeroSlider();
    initSaleSlider();
    initCountdown();
});
