<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('tai_khoans')) {
            return;
        }

        Schema::create('tai_khoans', function (Blueprint $table) {
            $table->id();
            $table->string('ho_ten', 100);
            $table->string('email')->unique();
            $table->string('mat_khau');
            $table->string('so_dien_thoai', 15)->nullable();
            $table->date('ngay_sinh')->nullable();
            $table->enum('gioi_tinh', ['nam', 'nu', 'khac'])->nullable();
            $table->string('avatar')->nullable();
            $table->enum('hang_thanh_vien', ['bronze', 'silver', 'gold', 'diamond'])->default('bronze');
            $table->unsignedInteger('diem_tich_luy')->default(0);
            $table->enum('role', ['customer', 'admin'])->default('customer');
            $table->boolean('is_active')->default(true);
            $table->timestamp('email_verified_at')->nullable();
            $table->timestamp('lan_dang_nhap_cuoi')->nullable();
            $table->rememberToken();
            $table->timestamp('ngay_tao')->nullable();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tai_khoans');
    }
};
