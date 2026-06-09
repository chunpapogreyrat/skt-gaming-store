<?php

namespace App\Mail;

use App\Models\DonHang;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class DonHangXacNhanMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public DonHang $donHang)
    {
    }

    public function build(): self
    {
        return $this
            ->subject('Xác nhận đơn hàng ' . $this->donHang->ma_don_hang . ' • YUKI Gaming Store')
            ->view('emails.don-hang-xac-nhan', [
                'donHang' => $this->donHang->loadMissing('chiTiet'),
            ]);
    }
}
