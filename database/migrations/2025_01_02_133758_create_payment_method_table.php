<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    public function up(): void
    {
        Schema::create('payment_method', function (Blueprint $table) {
            $table->id();
            $table->string('payment_type');  // credit_card, bank_account, e-wallet
            $table->string('account_name');
            $table->string('account_number');
            $table->string('bank_name')->nullable();
            $table->string('card_type')->nullable();  // visa, mastercard, etc
            $table->string('expiry_date')->nullable();
            $table->timestamps();
            
            // Memastikan nomor akun unik untuk setiap user
            $table->unique(['account_number']);
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('payment_method');
    }
};
