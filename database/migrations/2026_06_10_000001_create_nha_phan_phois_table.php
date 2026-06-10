<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('nha_phan_phois', function (Blueprint $table) {
            $table->id();
            $table->string('ten', 150);
            $table->string('mo_ta', 255)->nullable();
            $table->string('email', 150)->nullable();
            $table->string('sdt', 30)->nullable();
            $table->string('quoc_gia', 80)->nullable();
            $table->string('icon', 60)->default('fa-truck-ramp-box');
            $table->unsignedInteger('so_sku')->default(0);
            $table->date('hop_dong_den')->nullable();
            $table->enum('trang_thai', ['active', 'paused', 'ended'])->default('active');
            $table->text('ghi_chu')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('nha_phan_phois');
    }
};
