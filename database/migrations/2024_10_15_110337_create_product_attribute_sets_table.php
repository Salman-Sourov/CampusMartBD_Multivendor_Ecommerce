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
        Schema::create('product_attribute_sets', function (Blueprint $table) {
            $table->id();
            $table->string('title', 120)->nullable();
            $table->string('slug', 120)->nullable();
            $table->string('status', 60)->nullable();
            $table->tinyInteger('order')->default(0)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_attribute_sets');
    }
};
