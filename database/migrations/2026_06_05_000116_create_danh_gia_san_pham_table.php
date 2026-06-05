<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('danh_gia_san_pham', function (Blueprint $table) {
            $table->id();
            $table->foreignId('san_pham_id')->constrained('san_phams')->onDelete('cascade');
            $table->foreignId('tai_khoan_id')->constrained('tai_khoans')->onDelete('cascade');
            $table->foreignId('don_hang_id')->nullable()->constrained('don_hangs')->onDelete('set null');
            $table->tinyInteger('so_sao')->default(5);
            $table->text('noi_dung')->nullable();
            $table->string('hinh_anh')->nullable();
            $table->boolean('is_verified_purchase')->default(false);
            $table->boolean('is_active')->default(true);
            $table->timestamp('ngay_tao')->useCurrent();
            $table->index(['san_pham_id', 'is_active']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('danh_gia_san_pham');
    }
};
