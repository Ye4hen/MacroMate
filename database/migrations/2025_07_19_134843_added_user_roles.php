<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('mm_user_roles', function (Blueprint $table) {
            $table->increments('mur_id');
            $table->string('mur_code')->unique();
            $table->string('mur_name')->unique();
            $table->timestamp('mur_created_at')->useCurrent();
            $table->timestamp('mur_updated_at')->useCurrent()->useCurrentOnUpdate();
            $table->softDeletes('mur_deleted_at');
        });

        DB::table('mm_user_roles')->insert([
            'mur_id' => 1,
            'mur_code' => 'user',
            'mur_name' => 'User',
            'mur_created_at' => now(),
            'mur_updated_at' => now(),
            'mur_deleted_at' => null,
        ]);

        Schema::table('mm_users', function (Blueprint $table) {
            $table->string('mu_role')->default('user')->after('remember_token');
            $table->foreign('mu_role')->references('mur_code')->on('mm_user_roles');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('mm_users', function (Blueprint $table) {
            $table->dropForeign(['mu_role']);
            $table->dropColumn('mu_role');
        });

        Schema::dropIfExists('mm_user_roles');
    }
};
