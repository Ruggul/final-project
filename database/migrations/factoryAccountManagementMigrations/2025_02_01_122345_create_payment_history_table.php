<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('payment_histories', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_number')->unique();
            $table->decimal('amount', 12, 2);
            $table->enum('payment_status', ['pending', 'paid', 'failed', 'refunded']);
            $table->enum('payment_method', ['credit_card', 'bank_transfer', 'e-wallet', 'other']);
            $table->date('payment_date');
            $table->date('due_date');
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('payment_histories');
    }
};