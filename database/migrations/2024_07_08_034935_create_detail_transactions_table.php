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
        Schema::create('detail_transactions', function (Blueprint $table) {
            $table->id();
            $table->string('kode_detail')->unique();
            $table->foreignId('transaction_id')->constrained()->restrictOnDelete()->cascadeOnUpdate();
            $table->foreignId('stock_menu_id')->constrained()->restrictOnDelete()->cascadeOnUpdate();
            $table->integer('totalAmount');
            $table->integer('totalPrice');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_transactions');
    }
};
