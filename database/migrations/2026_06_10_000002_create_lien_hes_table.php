<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('lien_hes', function (Blueprint $table) {
            $table->id();
            $table->string('ho_ten', 120);
            $table->string('email', 150);
            $table->string('so_dien_thoai', 30)->nullable();
            $table->string('chu_de', 30)->default('tu-van');
            $table->text('noi_dung');
            $table->boolean('da_xu_ly')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('lien_hes');
    }
};
