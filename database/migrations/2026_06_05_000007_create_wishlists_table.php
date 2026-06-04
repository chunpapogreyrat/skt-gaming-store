<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('wishlists')) {
            return;
        }

        Schema::create('wishlists', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('tai_khoan_id')->index();
            $table->unsignedInteger('san_pham_id')->index();
            $table->timestamp('ngay_tao')->useCurrent();

            $table->unique(['tai_khoan_id', 'san_pham_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('wishlists');
    }
};
