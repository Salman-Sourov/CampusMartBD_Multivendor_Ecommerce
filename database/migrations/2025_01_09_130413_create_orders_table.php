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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('name', 191);
            $table->string('phone')->nullable();
            $table->longText('address')->nullable();
            $table->longText('area')->nullable();
            $table->longText('payment-option')->nullable();
            $table->longText('bkash')->nullable();
            $table->integer('product_id');
            $table->string('attributes');
            $table->string('status', 60)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
