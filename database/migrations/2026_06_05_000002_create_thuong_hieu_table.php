<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('thuong_hieu', function (Blueprint $table) {
            $table->id();
            $table->string('ten', 100);
            $table->string('slug', 120)->unique();
            $table->string('logo')->nullable();
            $table->boolean('is_active')->default(true);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('thuong_hieu');
    }
};
