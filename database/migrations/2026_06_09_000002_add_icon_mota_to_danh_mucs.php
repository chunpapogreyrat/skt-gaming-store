<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('danh_mucs', function (Blueprint $table) {
            if (! Schema::hasColumn('danh_mucs', 'icon')) {
                $table->string('icon', 60)->nullable()->after('slug');
            }
            if (! Schema::hasColumn('danh_mucs', 'mo_ta')) {
                $table->string('mo_ta', 255)->nullable()->after('icon');
            }
        });
    }

    public function down(): void
    {
        Schema::table('danh_mucs', function (Blueprint $table) {
            $table->dropColumn(['icon', 'mo_ta']);
        });
    }
};
