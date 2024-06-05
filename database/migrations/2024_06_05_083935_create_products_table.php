<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('product_name', 255);
            $table->string('product_slug', 255)->unique();
            $table->string('SKU', 255)->unique();
            $table->float('regular_price');
            $table->float('discount_price')->nullable();
            $table->integer('quantity');
            $table->text('description');
            $table->float('product_weight')->nullable();
            $table->string('product_note')->nullable();
            $table->boolean('published')->default(false);

            $table->timestamps();
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
