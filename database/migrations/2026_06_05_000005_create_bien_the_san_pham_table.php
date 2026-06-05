<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('bien_the_san_pham', function (Blueprint $table) {
            $table->id();
            $table->foreignId('san_pham_id')->constrained('san_phams')->onDelete('cascade');
            $table->string('ten_bien_the', 100);
            $table->string('ma_hex', 10)->nullable();
            $table->decimal('gia_chenh_lech', 15, 0)->default(0);
            $table->integer('so_luong_ton')->default(0);
            $table->boolean('is_active')->default(true);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bien_the_san_pham');
    }
};
