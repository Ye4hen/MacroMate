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
        Schema::table('mm_meals_foods_relations', function (Blueprint $table) {
            $table->softDeletes('mmfr_deleted_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('mm_meals_foods_relations', function (Blueprint $table) {
            if (Schema::hasColumn('mm_meals_foods_relations', 'mmfr_deleted_at')) {
                $table->dropColumn('mmfr_deleted_at');
            }
        });
    }
};
