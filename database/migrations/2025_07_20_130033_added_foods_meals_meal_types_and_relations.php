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
        Schema::create('mm_foods', function (Blueprint $table) {
            $table->increments('mf_id');
            $table->string('mf_code')->unique()->nullable();
            $table->string('mf_name')->unique();
            $table->unsignedSmallInteger('mf_cals');
            $table->json('mf_pfcfw');
            $table->string('mf_plan_code')->nullable();
            $table->string('mf_created_by')->nullable();
            $table->string('mf_updated_by')->nullable();
            $table->timestamp('mf_created_at')->useCurrent();
            $table->timestamp('mf_updated_at')->useCurrent()->useCurrentOnUpdate();
            $table->softDeletes('mf_deleted_at');

            $table->foreign('mf_plan_code')
                ->references('mp_code')
                ->on('mm_plans')
                ->onDelete('set null')
                ->onUpdate('cascade');

            $table->foreign('mf_created_by')
                ->references('mu_code')
                ->on('mm_users')
                ->onDelete('set null')
                ->onUpdate('cascade');

            $table->foreign('mf_updated_by')
                ->references('mu_code')
                ->on('mm_users')
                ->onDelete('set null')
                ->onUpdate('cascade');
        });

        Schema::create('mm_meal_types', function (Blueprint $table) {
            $table->increments('mmt_id');
            $table->string('mmt_code')->unique()->nullable();
            $table->string('mmt_name')->unique();
            $table->unsignedInteger('mmt_order');
            $table->timestamp('mmt_created_at')->useCurrent();
            $table->timestamp('mmt_updated_at')->useCurrent()->useCurrentOnUpdate();
            $table->softDeletes('mmt_deleted_at');
        });

        Schema::create('mm_meals', function (Blueprint $table) {
            $table->increments('mm_id');
            $table->string('mm_code')->unique()->nullable();
            $table->string('mm_type')->nullable();
            $table->string('mm_user');
            $table->unsignedInteger('mm_order');
            $table->timestamp('mm_created_at')->useCurrent();
            $table->timestamp('mm_updated_at')->useCurrent()->useCurrentOnUpdate();
            $table->softDeletes('mm_deleted_at');

            $table->foreign('mm_type')
                ->references('mmt_code')
                ->on('mm_meal_types')
                ->onDelete('set null')
                ->onUpdate('cascade');

            $table->foreign('mm_user')
                ->references('mu_code')
                ->on('mm_users')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });

        Schema::create('mm_meals_foods_relations', function (Blueprint $table) {
            $table->unsignedInteger('mmfr_mm');
            $table->unsignedInteger('mmfr_mf');
            $table->unsignedSmallInteger('mmfr_quantity');
            $table->string('mmfr_unit');

            $table->primary(['mmfr_mm', 'mmfr_mf'], 'mmfr_primary');

            $table->index('mmfr_mm', 'mm_meals_foods_relations_idx_1');

            $table->foreign('mmfr_mm')->references('mm_id')->on('mm_meals')->onDelete('cascade');
            $table->foreign('mmfr_mf')->references('mf_id')->on('mm_foods')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mm_meals_foods_relations');

        Schema::dropIfExists('mm_meals');

        Schema::dropIfExists('mm_meal_types');

        Schema::dropIfExists('mm_foods');
    }
};
