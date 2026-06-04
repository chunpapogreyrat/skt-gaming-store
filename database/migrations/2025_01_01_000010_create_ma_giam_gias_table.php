<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('ma_giam_gias', function (Blueprint $table) {
            $table->id();
            $table->string('ma_code', 50)->unique();
            $table->enum('loai', ['phan_tram', 'so_tien'])->default('phan_tram');
            $table->decimal('gia_tri', 10, 2);
            $table->decimal('gia_tri_don_toi_thieu', 15, 0)->default(0);
            $table->integer('so_lan_su_dung_toi_da')->nullable();
            $table->integer('so_lan_da_dung')->default(0);
            $table->date('ngay_bat_dau')->nullable();
            $table->date('ngay_het_han')->nullable();
            $table->boolean('trang_thai')->default(true);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ma_giam_gias');
    }
};
