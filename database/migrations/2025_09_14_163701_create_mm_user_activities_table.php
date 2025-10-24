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
        Schema::create('mm_user_activities', function (Blueprint $table) {
            $table->id('mua_id');
            $table->unsignedInteger('mu_id');
            $table->foreign('mu_id')->references('mu_id')->on('mm_users')->onDelete('cascade');
            $table->unsignedInteger('ma_id');
            $table->foreign('ma_id')->references('ma_id')->on('mm_activities')->onDelete('cascade');
            $table->smallInteger('mua_time');
            $table->smallInteger('mua_calories_burned');
            $table->date('mua_date');
            $table->timestamp('mua_created_at')->useCurrent();
            $table->timestamp('mua_updated_at')->useCurrent()->useCurrentOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mm_user_activities');
    }
};
