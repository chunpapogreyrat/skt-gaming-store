<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('chi_tiet_don_hangs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('don_hang_id')->constrained('don_hangs')->onDelete('cascade');
            $table->foreignId('san_pham_id')->constrained('san_phams')->onDelete('cascade');
            $table->string('ten_san_pham');
            $table->string('anh_san_pham')->nullable();
            $table->string('mau_sac')->nullable();
            $table->integer('so_luong');
            $table->decimal('don_gia', 15, 0);
            $table->decimal('thanh_tien', 15, 0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('chi_tiet_don_hangs');
    }
};
