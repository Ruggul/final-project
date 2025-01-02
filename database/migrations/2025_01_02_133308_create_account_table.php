<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    public function up(): void
    {
        Schema::create('account', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100)->nullable();
            $table->string('username', 50)->unique();
            $table->string('email', 100)->unique();
            $table->string('phone');
            $table->text('address')->nullable();
            $table->string('password');
            $table->timestamps();
        });
    }

    
    public function down(): void
    {
        Schema::dropIfExists('account');
    }
};