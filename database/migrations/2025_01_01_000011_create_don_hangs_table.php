<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('don_hangs', function (Blueprint $table) {
            $table->id();
            $table->string('ma_don_hang', 20)->unique();
            $table->foreignId('tai_khoan_id')->nullable()->constrained('tai_khoans')->onDelete('set null');
            $table->foreignId('ma_giam_gia_id')->nullable()->constrained('ma_giam_gias')->onDelete('set null');
            $table->string('ten_nguoi_nhan');
            $table->string('sdt_nguoi_nhan', 15);
            $table->string('dia_chi_giao_hang');
            $table->string('tinh_thanh')->nullable();
            $table->string('quan_huyen')->nullable();
            $table->string('phuong_xa')->nullable();
            $table->decimal('tam_tinh', 15, 0);
            $table->decimal('phi_ship', 15, 0)->default(0);
            $table->decimal('giam_gia', 15, 0)->default(0);
            $table->decimal('tong_tien', 15, 0);
            $table->enum('phuong_thuc_thanh_toan', ['cod', 'momo', 'vnpay'])->default('cod');
            $table->enum('trang_thai_thanh_toan', ['chua_thanh_toan', 'da_thanh_toan', 'that_bai'])->default('chua_thanh_toan');
            $table->enum('trang_thai_don_hang', ['cho_xac_nhan', 'dang_chuan_bi', 'dang_giao', 'da_giao', 'da_huy'])->default('cho_xac_nhan');
            $table->text('ghi_chu')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('don_hangs');
    }
};
