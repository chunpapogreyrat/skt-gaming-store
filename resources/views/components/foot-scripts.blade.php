{{-- JS dùng chung: CDN (jQuery, Bootstrap, Owl, AOS, tsParticles) + script.js dự án + các fix --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@tsparticles/slim@3/tsparticles.slim.bundle.min.js"></script>

{{-- JS dự án --}}
<script src="{{ asset('assets/js/script.js') }}"></script>

{{-- AOS fix: ép hiện [data-aos] sau khi load (script.js để once:false/mirror:true gây ẩn tới khi cuộn) --}}
<script>
(function () {
    function fixAos() {
        if (window.AOS) AOS.init({ once: true, duration: 700, offset: 0, mirror: false });
        document.querySelectorAll('[data-aos]').forEach(function (el) { el.classList.add('aos-animate'); });
    }
    window.addEventListener('load', function () { setTimeout(fixAos, 80); });
    setTimeout(fixAos, 1200);
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
