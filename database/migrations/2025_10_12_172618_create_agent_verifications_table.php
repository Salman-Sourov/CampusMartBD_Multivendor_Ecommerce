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
        Schema::create('agent_verifications', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('agent_id'); // link to users table
            $table->string('nid')->nullable();
            $table->string('student_id')->nullable();
            $table->date('verification_date')->nullable();
            $table->timestamps();

            // Foreign key relation with users table
            $table->foreign('agent_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('agent_verifications');
    }
};
