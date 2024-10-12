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
        Schema::create('product_category_transletions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('categories_id');
            $table->string('lang_code', 191);
            $table->string('name', 191);
            $table->timestamps();
    
            $table->foreign('categories_id')->references('id')->on('product_categories')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_category_transletions');
    }
};
