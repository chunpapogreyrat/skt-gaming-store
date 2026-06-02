/* =========================================
   1. AUTH MODULE (Đăng Nhập / Đăng Ký)
========================================= */
function initTogglePassword() {
    const togglePasswordBtns = document.querySelectorAll('.toggle-password');

    togglePasswordBtns.forEach(function (btn) {
        btn.addEventListener('click', function () {
            // Tìm thẻ cha .input-group gần nhất
            const container = this.closest('.input-group');
            if (!container) return;

            const inputField = container.querySelector('input');
            const icon = this.querySelector('i');

            if (inputField && icon) {
                if (inputField.type === 'password') {
                    inputField.type = 'text'; // Hiện mật khẩu
                    icon.classList.remove('fa-eye');
                    icon.classList.add('fa-eye-slash');
                } else {
                    inputField.type = 'password'; // Ẩn mật khẩu
                    icon.classList.remove('fa-eye-slash');
                    icon.classList.add('fa-eye');
                }
            }
        });
    });
}

/* =========================================
   HERO SLIDER MODULE (Carousel Zoom-in)
========================================= */
function initHeroSlider() {
    const nextBtn = document.getElementById("nextBtn");
    const prevBtn = document.getElementById("prevBtn");
    const track = document.getElementById("heroTrack");
    const heroTitle = document.getElementById("heroTitle");
    const heroDesc = document.getElementById("heroDesc");

    if (!track || !nextBtn || !prevBtn) return;

    function updateHeroContent() {
        const items = track.querySelectorAll(".hero-card");
        if (items.length < 2) return;

        const activeCard = items[1]; // Thẻ số 2 làm màn hình chính
        const title = activeCard.getAttribute("data-title");
        const desc = activeCard.getAttribute("data-desc");

        if (heroTitle && heroDesc) {
            heroTitle.style.opacity = '0';
            heroDesc.style.opacity = '0';
            setTimeout(() => {
                heroTitle.innerText = title;
                heroDesc.innerText = desc;
                heroTitle.style.opacity = '1';
                heroDesc.style.opacity = '1';
            }, 300);
        }

        const bgImg = activeCard.style.backgroundImage;
        const heroBg = document.getElementById("heroBg");
        if (heroBg) {
            heroBg.style.backgroundImage = bgImg;
            heroBg.style.backgroundSize = "cover";
            heroBg.style.backgroundPosition = "center";
            heroBg.style.filter = "blur(30px) brightness(0.3)";
        }
    }

    nextBtn.addEventListener("click", () => {
        const items = track.querySelectorAll(".hero-card");
        track.appendChild(items[0]);
        updateHeroContent();
    });

    prevBtn.addEventListener("click", () => {
        const items = track.querySelectorAll(".hero-card");
        track.prepend(items[items.length - 1]);
        updateHeroContent();
    });

    updateHeroContent();
}

document.addEventListener('DOMContentLoaded', function () {
    initHeroSlider();
});