<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('san_phams', function (Blueprint $table) {
            $table->id();
            $table->foreignId('danh_muc_id')->constrained('danh_mucs')->onDelete('cascade');
            $table->foreignId('thuong_hieu_id')->nullable()->constrained('thuong_hieu')->onDelete('set null');
            $table->string('ten', 200);
            $table->string('slug', 220)->unique();
            $table->string('mo_ta_ngan', 500)->nullable();
            $table->text('mo_ta_day_du')->nullable();
            $table->decimal('gia_ban', 15, 0);
            $table->decimal('gia_goc', 15, 0)->nullable();
            $table->integer('so_luong_ton')->default(0);
            $table->integer('luot_xem')->default(0);
            $table->integer('luot_ban')->default(0);
            $table->decimal('diem_danh_gia', 3, 2)->default(0);
            $table->integer('so_luong_danh_gia')->default(0);
            $table->boolean('is_hot')->default(false);
            $table->boolean('is_sale')->default(false);
            $table->boolean('is_active')->default(true);
            $table->timestamp('ngay_tao')->useCurrent();
            $table->timestamp('ngay_cap_nhat')->useCurrent()->useCurrentOnUpdate();
            $table->softDeletes();
            $table->index(['danh_muc_id', 'is_active']);
            $table->index('slug');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('san_phams');
    }
};
