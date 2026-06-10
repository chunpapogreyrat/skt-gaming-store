{{-- JS dùng chung: CDN (jQuery, Bootstrap, Owl, AOS, tsParticles) + script.js dự án + các fix --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@tsparticles/slim@3/tsparticles.slim.bundle.min.js"></script>

{{-- JS dự án --}}
<script src="{{ asset('assets/js/script.js') }}?v={{ filemtime(public_path('assets/js/script.js')) }}"></script>

{{-- AOS do script.js khởi tạo (once, IntersectionObserver). Đây chỉ là lưới an toàn:
     nếu sau khi tải xong còn phần tử [data-aos] chưa hiện thì ép hiện (KHÔNG init lại AOS để tránh xung đột). --}}
<script>
(function () {
    function inView(el) {
        var r = el.getBoundingClientRect();
        return r.top < (window.innerHeight || 0) && r.bottom > 0;
    }
    // Lưới an toàn: phần tử ĐANG trong khung nhìn mà vẫn ẩn (opacity ~0) sau khi tải
    // -> ép hiện tức thì (vô hiệu transition) để nội dung không bao giờ bị mất.
    function rescue() {
        document.querySelectorAll('[data-aos]').forEach(function (el) {
            el.classList.add('aos-animate');
            if (inView(el) && parseFloat(getComputedStyle(el).opacity || '1') < 0.05) {
                el.style.transition = 'none';
                el.style.opacity = '1';
                el.style.transform = 'none';
            }
        });
    }
    window.addEventListener('load', function () { setTimeout(rescue, 1500); });
    document.addEventListener('visibilitychange', function () { if (!document.hidden) setTimeout(rescue, 200); });
})();
</script>

{{-- User menu (.user-menu) toggle: bấm avatar mở/đóng, click ngoài hoặc Esc để đóng --}}
<script>
(function () {
    var menu = document.getElementById('userMenu');
    if (!menu) return;
    var trigger = menu.querySelector('.user-menu__trigger');
    if (trigger) {
        trigger.addEventListener('click', function (e) { e.stopPropagation(); menu.classList.toggle('is-open'); });
    }
    document.addEventListener('click', function (e) { if (!menu.contains(e.target)) menu.classList.remove('is-open'); });
    document.addEventListener('keydown', function (e) { if (e.key === 'Escape') menu.classList.remove('is-open'); });
})();
</script>

@stack('scripts')
