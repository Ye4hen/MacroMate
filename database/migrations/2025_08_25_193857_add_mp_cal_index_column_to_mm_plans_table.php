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
        Schema::table('mm_plans', function (Blueprint $table) {
            $table->decimal('mp_cal_index', 3)->default(1.00)->after('mp_name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('mm_plans', function (Blueprint $table) {
            if (Schema::hasColumn('mm_plans', 'mp_cal_index')) {
                $table->dropColumn('mp_cal_index');
            }
        });
    }
};
