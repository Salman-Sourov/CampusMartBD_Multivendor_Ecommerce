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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('verification_code', 6)->nullable();
            $table->string('phone')->unique('phone');
            $table->string('password');
            $table->string('role');
            $table->string('status')->nullable();
            $table->string('university')->nullable();
            $table->string('roll')->nullable();
            $table->string('image', 255)->nullable();
            // $table->string('id_image', 255)->nullable();
            $table->integer('verification_attempts')->default(0);
            $table->string('address')->nullable(); // New nullable address field
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
