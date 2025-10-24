<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::table('mm_meals', function (Blueprint $table) {
            $table->dropForeign(['mm_type']);
        });

        Schema::dropIfExists('mm_meal_types');

        Schema::table('mm_meals', function (Blueprint $table) {
            $table->enum('mm_type', ['Breakfast', 'Mid-Morning Snack', 'Lunch', 'Afternoon Snack', 'Dinner', 'Late Dinner'])
                ->nullable()
                ->change();
        });
    }

    public function down(): void
    {
        Schema::table('mm_meals', function (Blueprint $table) {
            $table->string('mm_type')->nullable()->change();
        });

        if (!Schema::hasTable('mm_meal_types')) {
            Schema::create('mm_meal_types', function (Blueprint $table) {
                $table->increments('mmt_id');
                $table->string('mmt_code')->unique()->nullable();
                $table->string('mmt_name')->unique();
                $table->unsignedInteger('mmt_order');
                $table->timestamp('mmt_created_at')->useCurrent();
                $table->timestamp('mmt_updated_at')->useCurrent()->useCurrentOnUpdate();
                $table->softDeletes('mmt_deleted_at');
            });
        }

        Schema::table('mm_meals', function (Blueprint $table) {
            $table->foreign('mm_type')
                ->references('mmt_code')
                ->on('mm_meal_types')
                ->onDelete('set null')
                ->onUpdate('cascade');
        });
    }
};
