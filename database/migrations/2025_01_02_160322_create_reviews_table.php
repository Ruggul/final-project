<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    public function up(): void
    {
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained('produk')->onDelete('cascade');
            $table->integer('rating')->comment('1-5 stars');
            $table->text('review_text');
            $table->json('review_images')->nullable();
            $table->timestamp('purchase_date');
            $table->timestamps();

            // Memastikan user hanya bisa memberikan satu ulasan per produk per order
            $table->unique(['product_id', 'order_id']);
        });
    }

    
    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};
