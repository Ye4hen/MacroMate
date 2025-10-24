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
            $table->text('mf_image_url')->nullable()->change();

            if (! Schema::hasColumn('mm_foods', 'mf_image_disk')) {
                $table->string('mf_image_disk')->default('public')->after('mf_image_url');
            }

            if (! Schema::hasColumn('mm_foods', 'mf_image_variants')) {
                $table->json('mf_image_variants')->nullable()->after('mf_image_disk');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('mm_foods', function (Blueprint $table) {
            $table->string('mf_image_url', 255)->nullable()->change();

            if (Schema::hasColumn('mm_foods', 'mf_image_disk')) {
                $table->dropColumn('mf_image_disk');
            }

            if (Schema::hasColumn('mm_foods', 'mf_image_variants')) {
                $table->dropColumn('mf_image_variants');
            }
        });
    }
};
