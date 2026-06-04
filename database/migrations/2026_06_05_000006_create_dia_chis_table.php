<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('dia_chis')) {
            return;
        }

        Schema::create('dia_chis', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('tai_khoan_id')->index();
            $table->string('ten_nguoi_nhan', 100);
            $table->string('so_dien_thoai', 15);
            $table->string('tinh_thanh', 100);
            $table->string('quan_huyen', 100);
            $table->string('phuong_xa', 100)->nullable();
            $table->string('dia_chi_cu_the', 255);
            $table->enum('loai_dia_chi', ['nha', 'cong_ty', 'khac'])->default('nha');
            $table->boolean('is_mac_dinh')->default(false)->index();
            $table->timestamp('ngay_tao')->useCurrent();
            $table->timestamp('ngay_cap_nhat')->nullable()->useCurrentOnUpdate();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('dia_chis');
    }
};
