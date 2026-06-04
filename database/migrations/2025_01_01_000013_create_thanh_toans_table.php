<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('thanh_toans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('don_hang_id')->constrained('don_hangs')->onDelete('cascade');
            $table->string('ma_giao_dich')->nullable();
            $table->enum('cong_thanh_toan', ['cod', 'momo', 'vnpay']);
            $table->decimal('so_tien', 15, 0);
            $table->enum('trang_thai', ['pending', 'success', 'failed'])->default('pending');
            $table->json('du_lieu_callback')->nullable();
            $table->timestamp('thoi_gian_thanh_toan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('thanh_toans');
    }
};
