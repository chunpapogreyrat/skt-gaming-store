<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('bai_viet', function (Blueprint $table) {
            $table->id();
            $table->string('danh_muc', 40)->default('tin-tuc'); // setup | review | huong-dan | tin-tuc | esports
            $table->string('tieu_de', 220);
            $table->string('slug', 240)->unique();
            $table->string('mo_ta_ngan', 500)->nullable();
            $table->longText('noi_dung')->nullable();
            $table->string('anh_bia')->nullable();
            $table->string('tac_gia', 100)->default('YUKI Team');
            $table->integer('thoi_gian_doc')->default(5); // phút
            $table->integer('luot_xem')->default(0);
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_active')->default(true);
            $table->timestamp('ngay_dang')->useCurrent();
            $table->timestamps();

            $table->index(['danh_muc', 'is_active']);
            $table->index('slug');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bai_viet');
    }
};
