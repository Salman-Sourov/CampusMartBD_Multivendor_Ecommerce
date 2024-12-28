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
        Schema::create('product_with_attributes', function (Blueprint $table) {
            $table->id();
            $table->string('attribute_ids')->nullable();
            $table->unsignedBigInteger('product_id')->nullable();
            $table->timestamps();

            // Define foreign key constraints
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_with_attributes');
    }
};
