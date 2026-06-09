{{-- Modal xác nhận xóa (dùng chung cho cart drawer + trang giỏ hàng) --}}
<div class="confirm-modal" id="confirmModal">
    <div class="confirm-modal__backdrop" id="confirmBackdrop"></div>
    <div class="confirm-modal__box">
        <div class="confirm-modal__icon"><i class="fa-solid fa-trash-can"></i></div>
        <h6 class="confirm-modal__title">Xóa sản phẩm?</h6>
        <p class="confirm-modal__text" id="confirmText">Bạn có chắc chắn muốn xóa sản phẩm này khỏi giỏ hàng không?</p>
        <div class="confirm-modal__actions">
            <button class="confirm-modal__btn confirm-modal__btn--cancel" id="confirmCancel">Hủy bỏ</button>
            <button class="confirm-modal__btn confirm-modal__btn--confirm" id="confirmOk">Xóa luôn</button>
        </div>
    </div>
</div>
