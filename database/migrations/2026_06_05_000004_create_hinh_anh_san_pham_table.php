<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('hinh_anh_san_pham', function (Blueprint $table) {
            $table->id();
            $table->foreignId('san_pham_id')->constrained('san_phams')->onDelete('cascade');
            $table->string('duong_dan');
            $table->integer('thu_tu')->default(0);
            $table->boolean('is_main')->default(false);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('hinh_anh_san_pham');
    }
};
