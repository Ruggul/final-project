<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    public function up(): void
    {
        Schema::create('topups', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users');
            $table->string('transaction_number');
            $table->decimal('amount', 10, 2);
            $table->enum('payment_method', ['bank_transfer', 'e-wallet']);
            $table->enum('status', ['pending', 'success', 'failed']);
            $table->timestamp('payment_date')->nullable();
            $table->timestamps();
        });
    }

    
    public function down(): void
    {
        Schema::dropIfExists('topups');
    }
};