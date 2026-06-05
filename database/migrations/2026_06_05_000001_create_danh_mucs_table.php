<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('danh_mucs', function (Blueprint $table) {
            $table->id();
            $table->string('ten', 100);
            $table->string('slug', 120)->unique();
            $table->string('hinh_anh')->nullable();
            $table->integer('thu_tu')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamp('ngay_tao')->useCurrent();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('danh_mucs');
    }
};
