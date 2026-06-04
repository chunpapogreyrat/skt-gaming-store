<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('setups', function (Blueprint $table) {
            $table->id();
            $table->string('ten_setup');
            $table->string('ten_game_thu')->nullable();
            $table->string('anh_chinh');
            $table->text('mo_ta')->nullable();
            $table->json('san_phams_trong_setup')->nullable();
            $table->boolean('noi_bat')->default(false);
            $table->integer('thu_tu')->default(0);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('setups');
    }
};
