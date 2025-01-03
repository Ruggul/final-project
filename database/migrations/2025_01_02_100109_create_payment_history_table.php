<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payment_history', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_number')->unique();
            $table->enum('payment_status', ['pending', 'paid', 'failed', 'refunded']);
            $table->enum('payment_method', ['credit_card', 'bank_transfer', 'e-wallet', 'other']);
            $table->date('payment_date');
            $table->date('due_date');
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payment_history');
    }
};