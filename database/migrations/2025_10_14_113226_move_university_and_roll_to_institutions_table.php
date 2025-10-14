<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('institutions', function (Blueprint $table) {
            if (!Schema::hasColumn('institutions', 'university')) {
                $table->string('university')->nullable()->after('is_featured');
            }
            if (!Schema::hasColumn('institutions', 'roll')) {
                $table->string('roll')->nullable()->after('university');
            }
        });

        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'university')) {
                $table->dropColumn('university');
            }
            if (Schema::hasColumn('users', 'roll')) {
                $table->dropColumn('roll');
            }
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'university')) {
                $table->string('university')->nullable()->after('status');
            }
            if (!Schema::hasColumn('users', 'roll')) {
                $table->string('roll')->nullable()->after('university');
            }
        });

        Schema::table('institutions', function (Blueprint $table) {
            if (Schema::hasColumn('institutions', 'university')) {
                $table->dropColumn('university');
            }
            if (Schema::hasColumn('institutions', 'roll')) {
                $table->dropColumn('roll');
            }
        });
    }
};
