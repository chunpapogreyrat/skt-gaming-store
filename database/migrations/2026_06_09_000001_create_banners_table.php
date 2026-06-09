<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('banners', function (Blueprint $table) {
            $table->id();
            $table->string('tieu_de');                 // tiêu đề hiển thị trên slide
            $table->string('mo_ta')->nullable();       // mô tả ngắn
            $table->string('hinh_anh');                // đường dẫn ảnh nền
            $table->string('link')->nullable();        // link khi bấm "Khám phá"
            $table->unsignedInteger('thu_tu')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('banners');
    }
};
