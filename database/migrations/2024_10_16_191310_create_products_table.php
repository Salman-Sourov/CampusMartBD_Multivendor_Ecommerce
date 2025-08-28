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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name', 191);
            $table->text('description')->nullable();
            $table->longText('content')->nullable();
            $table->string('status', 60)->nullable();
            $table->text('thumbnail')->nullable();
            $table->string('sku', 191)->nullable();
            $table->integer('order')->nullable();
            $table->integer('quantity')->nullable();
            $table->tinyInteger('allow_checkout_when_out_of_stock')->nullable();
            $table->tinyInteger('with_storehouse_management')->nullable();
            $table->tinyInteger('is_featured')->nullable();
            $table->unsignedBigInteger('brand_id')->nullable();
            $table->tinyInteger('is_variation')->nullable();
            $table->double('price')->nullable();
            $table->double('sale_price')->nullable();
            $table->timestamp('start_date')->nullable();
            $table->timestamp('end_date')->nullable();
            $table->double('length', 8, 2)->nullable();
            $table->double('wide', 8, 2)->nullable();
            $table->double('height', 8, 2)->nullable();
            $table->double('weight', 8, 2)->nullable();
            $table->bigInteger('views')->nullable();
            $table->string('stock_status', 191)->nullable();
            $table->integer('created_by_id')->nullable();
            $table->timestamps();

            // Define foreign key constraint
            $table->foreign('brand_id')->references('id')->on('brands')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
