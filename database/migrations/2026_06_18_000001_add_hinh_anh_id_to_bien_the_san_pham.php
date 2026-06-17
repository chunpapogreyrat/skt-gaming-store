<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('bien_the_san_pham', function (Blueprint $table) {
            // Liên kết biến thể màu với 1 ảnh sản phẩm → chọn màu sẽ đổi ảnh tương ứng
            $table->foreignId('hinh_anh_id')
                ->nullable()
                ->after('ma_hex')
                ->constrained('hinh_anh_san_pham')
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('bien_the_san_pham', function (Blueprint $table) {
            $table->dropForeign(['hinh_anh_id']);
            $table->dropColumn('hinh_anh_id');
        });
    }
};
