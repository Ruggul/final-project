<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('payment_methods', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('payment_type');  // credit_card, bank_account, e-wallet
            $table->string('account_name');
            $table->string('account_number');
            $table->string('bank_name')->nullable();
            $table->string('card_type')->nullable();  // visa, mastercard, etc
            $table->string('expiry_date')->nullable();
            $table->timestamps();
            
            // Memastikan nomor akun unik untuk setiap user
            $table->unique(['user_id', 'account_number']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('payment_methods');
    }
};