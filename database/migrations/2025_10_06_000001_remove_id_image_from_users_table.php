<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (Schema::hasColumn('users', 'id_image')) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn('id_image');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (! Schema::hasColumn('users', 'id_image')) {
            Schema::table('users', function (Blueprint $table) {
                $table->string('id_image', 255)->nullable();
            });
        }
    }
};
