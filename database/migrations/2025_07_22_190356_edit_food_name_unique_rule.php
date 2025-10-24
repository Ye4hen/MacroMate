<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::table('mm_foods', function (Blueprint $table) {
            $table->dropUnique('mm_foods_mf_name_unique');
            $table->unique(['mf_name', 'mf_deleted_at'], 'mm_foods_name_not_deleted_unique');
        });
    }

    public function down(): void
    {
        Schema::table('mm_foods', function (Blueprint $table) {
            $table->unique('mf_name');
        });
    }
};
