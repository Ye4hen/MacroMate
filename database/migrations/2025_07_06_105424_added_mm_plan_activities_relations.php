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
        Schema::create('mm_plans_activities_relations', function (Blueprint $table) {
            $table->unsignedInteger('mpar_mp');
            $table->unsignedInteger('mpar_ma');

            // Composite Primary Key
            $table->primary(['mpar_mp', 'mpar_ma'], 'mpar_primary');

            // Index on mpar_mp
            $table->index('mpar_mp', 'mm_plans_activities_relations_idx_1');

            // Add FKs (if you want referential integrity)
            $table->foreign('mpar_mp')->references('mp_id')->on('mm_plans')->onDelete('cascade');
            $table->foreign('mpar_ma')->references('ma_id')->on('mm_activities')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mm_plans_activities_relations');
    }
};
