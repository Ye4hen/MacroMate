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
        //
        // 1️⃣ Create the activities table first, since plans reference it
        //
        Schema::create('mm_activities', function (Blueprint $table) {
            $table->increments('ma_id');
            $table->string('ma_code')->nullable()->unique();
            $table->string('ma_name');
            $table->integer('ma_cals');
            $table->timestamp('ma_created_at')->useCurrent();
            $table->timestamp('ma_updated_at')->useCurrent()->useCurrentOnUpdate();
            $table->softDeletes('ma_deleted_at');
        });

        //
        // 2️⃣ Create the plans table next (references activities)
        //
        Schema::create('mm_plans', function (Blueprint $table) {
            $table->increments('mp_id');
            $table->string('mp_code', 191)->nullable()->unique();
            $table->string('mp_name');
            $table->json('mp_pfc');                     // Protein, Fats, Carbs
            $table->timestamp('mp_created_at')->useCurrent();
            $table->timestamp('mp_updated_at')->useCurrent()->useCurrentOnUpdate();
            $table->softDeletes('mp_deleted_at');
        });

        //
        // 3️⃣ Finally the users table (references plans)
        //
        Schema::create('mm_users', function (Blueprint $table) {
            $table->increments('mu_id');
            $table->string('mu_code')->nullable()->unique();
            $table->string('mu_name');
            $table->string('mu_email')->unique();
            $table->string('mu_password');
            $table->integer('mu_age')->unsigned()->nullable();
            $table->integer('mu_height')->unsigned()->nullable();
            $table->integer('mu_weight')->unsigned()->nullable();
            $table->enum('mu_gender', ['male', 'female'])->nullable();
            $table->string('mu_plan_code', 191)->nullable()->index();
            $table->json('mu_settings')->nullable();
            $table->timestamp('mu_created_at')->useCurrent();
            $table->timestamp('mu_updated_at')->useCurrent()->useCurrentOnUpdate();
            $table->softDeletes('mu_deleted_at');

            $table->foreign('mu_plan_code')
                ->references('mp_code')
                ->on('mm_plans')
                ->onDelete('set null')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('mm_users', function (Blueprint $table) {
            $table->dropForeign(['mu_plan_code']);
        });
        Schema::dropIfExists('mm_users');

        Schema::dropIfExists('mm_plans');

        Schema::dropIfExists('mm_activities');
    }
};
