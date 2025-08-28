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
        Schema::create('product_attributes', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('attribute_set_id')->unsigned();
            $table->string('title', 120);
            $table->string('slug', 120);
            $table->string('color', 50)->nullable();
            $table->string('image', 191)->nullable();
            $table->tinyInteger('order')->default(0);
            $table->string('status', 60)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_attributes');
    }
};
