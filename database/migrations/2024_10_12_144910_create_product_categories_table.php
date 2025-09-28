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
        Schema::create('product_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name', 191);
            $table->string('slug');
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->mediumText('description')->nullable();
            $table->string('status', 60)->nullable();
            $table->integer('order')->nullable();
            $table->string('image', 255)->nullable();
            $table->tinyInteger('is_featured')->default(0)->nullable();
            $table->tinyInteger('enableSubcat')->default(1)->nullable();
            $table->integer('level')->nullable();
            $table->timestamps();

            $table->foreign('parent_id')->references('id')->on('product_categories')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_categories');
    }
};
