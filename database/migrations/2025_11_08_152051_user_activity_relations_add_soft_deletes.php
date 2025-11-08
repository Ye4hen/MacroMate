<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('mm_user_activities', function (Blueprint $table) {
            $table->softDeletes('mua_deleted_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('mm_user_activities', function (Blueprint $table) {
            if (Schema::hasColumn('mm_user_activities', 'mua_deleted_at')) {
                $table->dropColumn('mua_deleted_at');
            }
        });
    }
};
