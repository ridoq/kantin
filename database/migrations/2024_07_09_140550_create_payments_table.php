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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('transaction_id')->constrained()->restrictOnDelete()->cascadeOnUpdate();
            $table->foreignId('paymentMethod_id')->constrained('payment_methods')->restrictOnDelete()->cascadeOnUpdate();
            $table->integer('totalPayment');
            $table->integer('change');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
        Schema::table('payments', function(Blueprint $table){
            $table->dropSoftDeletes();
        });
    }
};
