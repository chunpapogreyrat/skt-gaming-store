{{-- JS xử lý giỏ hàng AJAX: xóa/đổi số lượng trong drawer, quick-add bay vào giỏ --}}
<script>
(function () {
    const csrf = document.querySelector('meta[name="csrf-token"]')?.content;
    if (!csrf) return;

    function cartApi(url, method, body) {
        return fetch(url, {
            method: method,
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrf,
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
            },
            credentials: 'same-origin',
            body: body ? JSON.stringify(body) : null,
        }).then(r => r.json());
    }

    function updateBadgeAndTotal(count, total) {
        document.querySelectorAll('#cartBadge, #cartCount').forEach(b => {
            b.style.display = count > 0 ? '' : 'none';
            if (b.textContent !== String(count)) {
                b.classList.remove('badge-pop');
                void b.offsetWidth;
                b.classList.add('badge-pop');
            }
            b.textContent = count;
        });
        const totalEl = document.getElementById('cartTotal');
        if (totalEl) totalEl.innerHTML = Number(total).toLocaleString('vi-VN') + '<sup>đ</sup>';
    }

    // Confirm modal with promise — dùng cho cả drawer + cart page
    window.skSktConfirm = function (productName) {
        const modal = document.getElementById('confirmModal');
        const ok = document.getElementById('confirmOk');
        const cancel = document.getElementById('confirmCancel');
        const backdrop = document.getElementById('confirmBackdrop');
        const text = document.getElementById('confirmText');
        if (!modal) return Promise.resolve(confirm('Xóa ' + (productName || 'sản phẩm') + '?'));
        if (productName) text.textContent = 'Xóa "' + productName + '" khỏi giỏ hàng?';
        modal.classList.add('is-open');
        return new Promise(resolve => {
            function close(r) {
                modal.classList.remove('is-open');
                ok.removeEventListener('click', onOk);
                cancel.removeEventListener('click', onCancel);
                backdrop.removeEventListener('click', onCancel);
                resolve(r);
            }
            function onOk() { close(true); }
            function onCancel() { close(false); }
            ok.addEventListener('click', onOk);
            cancel.addEventListener('click', onCancel);
            backdrop.addEventListener('click', onCancel);
        });
    };

    // Drawer: delete with confirm
    document.addEventListener('click', async function (e) {
        const btn = e.target.closest('[data-drawer-remove]');
        if (!btn) return;
        const item = btn.closest('.cart-item');
        const id = item?.dataset.itemId;
        if (!id) return;
        const name = item.querySelector('.cart-item__name')?.textContent.trim();
        if (!await window.skSktConfirm(name)) return;

        const res = await cartApi('/gio-hang/' + id, 'DELETE');
        if (res.success) {
            item.remove();
            updateBadgeAndTotal(res.data.cart_count, res.data.tong.tong_tien);
            if (res.data.cart_count === 0) {
                const list = document.getElementById('cartList');
                if (list && !list.querySelector('#cartDrawerEmpty')) {
                    list.innerHTML = '<div class="text-center text-secondary py-5" id="cartDrawerEmpty"><i class="fa-solid fa-cart-shopping" style="font-size:2.5rem;opacity:.3"></i><p class="mt-3">Giỏ hàng đang trống</p></div>';
                }
            }
        } else {
            alert(res.message || 'Không xóa được sản phẩm');
        }
    });

    // Drawer: qty +/-
    document.addEventListener('click', async function (e) {
        const plus = e.target.closest('[data-drawer-plus]');
        const minus = e.target.closest('[data-drawer-minus]');
        if (!plus && !minus) return;
        const item = (plus || minus).closest('.cart-item');
        const id = item?.dataset.itemId;
        const input = item.querySelector('.qty-input input');
        if (!id || !input) return;
        const newQty = parseInt(input.value) + (plus ? 1 : -1);
        if (newQty < 1) return;

        const res = await cartApi('/gio-hang/' + id, 'PATCH', { so_luong: newQty });
        if (res.success) {
            input.value = newQty;
            updateBadgeAndTotal(res.data.cart_count, res.data.tong.tong_tien);
        }
    });

    // Build cart-item HTML khớp với server-render (same markup)
    function buildCartItemHTML(item) {
        const sp = item.san_pham || {};
        const img = (sp.hinh_anh && sp.hinh_anh[0]) ? sp.hinh_anh[0].duong_dan : 'assets/images/library/logo.png';
        const price = Number(item.gia_tai_thoi_diem).toLocaleString('vi-VN') + 'đ';
        const variant = item.mau_sac || 'Mặc định';
        return `
            <div class="cart-item" data-item-id="${item.id}">
                <div class="cart-item__img"><img src="/${img}" alt=""></div>
                <div class="cart-item__info">
                    <h6 class="cart-item__name">${sp.ten || 'Sản phẩm'}</h6>
                    <span class="cart-item__price">${price}</span>
                    <p class="cart-item__variant">Phân loại: ${variant}</p>
                </div>
                <div class="cart-item__actions">
                    <div class="qty-input">
                        <button type="button" class="qty-input__btn" data-drawer-minus>−</button>
                        <input type="text" value="${item.so_luong}" readonly>
                        <button type="button" class="qty-input__btn" data-drawer-plus>+</button>
                    </div>
                    <button type="button" class="cart-item__remove" data-drawer-remove aria-label="Xóa"><i class="fa-solid fa-trash-can"></i></button>
                </div>
            </div>`;
    }

    // Quick add: animation + POST + DOM update (no reload)
    document.addEventListener('click', async function (e) {
        const btn = e.target.closest('.p-card__quick[data-product-id]');
        if (!btn) return;
        e.preventDefault();
        e.stopPropagation();
        const id = parseInt(btn.dataset.productId);
        if (!id) return;
        e.stopImmediatePropagation(); // chặn initFlyToCart (script.js) thêm giỏ client-side lần 2

        if (typeof window.skSktFlyPaperPlane === 'function') {
            window.skSktFlyPaperPlane(btn);
        }

        const res = await cartApi('/gio-hang', 'POST', { san_pham_id: id, so_luong: 1 });
        if (!res.success) {
            alert(res.message || 'Không thêm được sản phẩm');
            return;
        }

        const list = document.getElementById('cartList');
        const empty = document.getElementById('cartDrawerEmpty');
        if (empty) empty.remove();

        const existing = list?.querySelector(`.cart-item[data-item-id="${res.data.item.id}"]`);
        if (existing) {
            const input = existing.querySelector('.qty-input input');
            if (input) input.value = res.data.item.so_luong;
        } else {
            list.insertAdjacentHTML('beforeend', buildCartItemHTML(res.data.item));
        }
        updateBadgeAndTotal(res.data.cart_count, res.data.tong.tong_tien);
    }, true);
})();
</script>
