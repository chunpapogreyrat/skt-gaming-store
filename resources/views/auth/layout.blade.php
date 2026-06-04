<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - YUKI</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@500;700;900&family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
</head>
<body class="dark-theme auth-page">

    <div class="auth-bg"></div>
    <a href="{{ route('home') }}" class="auth-brand">YUKI</a>

    {{-- Wrapper chứa toàn bộ nội dung thay đổi giữa các trang auth --}}
    <div id="auth-dynamic">
        @yield('back-link')
        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('assets/js/script.js') }}"></script>
    <script>
    /* ============================================================
       AUTH AJAX TRANSITION
       – Intercept [data-transition] clicks TRƯỚC script.js
       – Fetch trang mới trong lúc exit animation chạy
       – Swap #auth-dynamic, chạy enter animation → zero reload lag
    ============================================================ */
    (function () {
        var SLIDE_MS = 480;
        var SPIN_MS  = 420;

        /* ---------- exit + fetch + swap + enter ---------- */
        function ajaxGoTo(url, exitType) {
            var panel = document.getElementById('authPanel');
            if (!panel) return;

            /* 1. Tính exit/enter params */
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

            /* 2. Chạy exit animation */
            panel.style.transition =
                'transform ' + dur + 'ms cubic-bezier(.55,.055,.675,.19),' +
                'opacity '   + (dur * 0.45) + 'ms ease ' + (dur * 0.3) + 'ms';
            panel.style.transform = exitCSS;
            panel.style.opacity   = '0';

            /* 3. Fetch trang mới SONG SONG với animation */
            var fetchHtml = fetch(url, {
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            }).then(function (r) { return r.text(); });

            var animDone = new Promise(function (resolve) {
                setTimeout(resolve, dur + 20);
            });

            /* 4. Khi cả 2 xong → swap DOM */
            Promise.all([animDone, fetchHtml]).then(function (results) {
                var html   = results[1];
                var parser = new DOMParser();
                var newDoc = parser.parseFromString(html, 'text/html');

                /* Swap #auth-dynamic */
                var oldDyn = document.getElementById('auth-dynamic');
                var newDyn = newDoc.getElementById('auth-dynamic');
                if (oldDyn && newDyn) {
                    oldDyn.innerHTML = newDyn.innerHTML;
                }

                /* Cập nhật title + URL */
                document.title = newDoc.title;
                history.pushState({}, newDoc.title, url);

                /* 5. Enter animation cho panel mới */
                var np = document.getElementById('authPanel');
                if (!np) return;

                var startCSS = '';
                if (enterNext === 'slide-left')  startCSS = 'translateX(-110%)';
                if (enterNext === 'slide-right') startCSS = 'translateX(110%)';
                if (enterNext === 'spin')        startCSS = 'perspective(900px) rotateY(-90deg) scale(0.85)';

                np.style.transform  = startCSS;
                np.style.opacity    = '0';
                np.style.transition = 'none';

                requestAnimationFrame(function () {
                    requestAnimationFrame(function () {
                        var eDur = (enterNext === 'spin') ? SPIN_MS : SLIDE_MS;
                        np.style.transition =
                            'transform ' + eDur + 'ms cubic-bezier(.25,.46,.45,.94),' +
                            'opacity '   + (eDur * 0.55) + 'ms ease';
                        np.style.transform = (enterNext === 'spin')
                            ? 'perspective(900px) rotateY(0deg) scale(1)'
                            : 'translateX(0)';
                        np.style.opacity = '1';
                    });
                });
            }).catch(function () {
                /* Fallback: navigate thường nếu fetch lỗi */
                window.location.href = url;
            });
        }

        /* ---------- Intercept clicks (capture phase → chạy trước script.js) ---------- */
        document.addEventListener('click', function (e) {
            var link = e.target.closest('[data-transition]');
            if (!link) return;
            e.preventDefault();
            e.stopPropagation();   /* chặn script.js xử lý lại */
            ajaxGoTo(
                link.dataset.slideTo || link.getAttribute('href'),
                link.dataset.transition
            );
        }, true);

        /* ---------- Re-init password toggles sau mỗi swap ---------- */
        document.addEventListener('click', function (e) {
            var btn = e.target.closest('.toggle-password');
            if (!btn) return;
            var field = btn.closest('.auth-field');
            if (!field) return;
            var input = field.querySelector('input[type="password"], input[type="text"]');
            if (!input) return;
            var icon = btn.querySelector('i');
            if (input.type === 'password') {
                input.type = 'text';
                if (icon) { icon.classList.remove('fa-eye'); icon.classList.add('fa-eye-slash'); }
            } else {
                input.type = 'password';
                if (icon) { icon.classList.remove('fa-eye-slash'); icon.classList.add('fa-eye'); }
            }
        });

        /* ---------- Browser back/forward ---------- */
        window.addEventListener('popstate', function () {
            window.location.reload();
        });
    })();
    </script>
</body>
</html>
