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
        Schema::table('mm_foods', function (Blueprint $table) {
            $table->enum('mf_type', ['food', 'drink'])->default('food')->after('mf_name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('mm_foods', function (Blueprint $table) {
            $table->dropColumn('mf_type');
        });
    }
};
