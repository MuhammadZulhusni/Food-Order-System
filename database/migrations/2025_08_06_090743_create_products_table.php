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
            $table->string('name');
            $table->string('slug')->nullable(); // Stores a URL-friendly version of the product name.
            $table->integer('category_id'); // Foreign key for the product's category.
            $table->integer('city_id'); // Foreign key for the product's city.
            $table->integer('menu_id'); // Foreign key for the menu the product belongs to.
            $table->string('code')->nullable();
            $table->string('qty')->nullable(); 
            $table->string('size')->nullable(); // The size of the product.
            $table->string('price')->nullable();
            $table->string('discount_price')->nullable();
            $table->string('image')->nullable(); 
            $table->string('client_id')->nullable(); // Foreign key for the client who owns the product.
            $table->string('most_populer')->nullable();
            $table->string('best_seller')->nullable(); 
            $table->string('status')->nullable();
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