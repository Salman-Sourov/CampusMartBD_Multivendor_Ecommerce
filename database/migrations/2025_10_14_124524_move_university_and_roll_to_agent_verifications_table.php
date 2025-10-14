<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Add columns if not exist
        Schema::table('agent_verifications', function (Blueprint $table) {
            if (!Schema::hasColumn('agent_verifications', 'institution')) {
                $table->string('institution')->nullable();
            }
            if (!Schema::hasColumn('agent_verifications', 'roll')) {
                $table->string('roll')->nullable();
            }
        });

        // Remove columns from users if exist
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
        // Add columns back to users
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'university')) {
                $table->string('university')->nullable();
            }
            if (!Schema::hasColumn('users', 'roll')) {
                $table->string('roll')->nullable();
            }
        });

        // Remove columns from agent_verifications if exist
        Schema::table('agent_verifications', function (Blueprint $table) {
            if (Schema::hasColumn('agent_verifications', 'institution')) {
                $table->dropColumn('institution');
            }
            if (Schema::hasColumn('agent_verifications', 'roll')) {
                $table->dropColumn('roll');
            }
        });
    }
};
