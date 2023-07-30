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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->integer('customer_id');
            $table->integer('order_total');
            $table->integer('tax_amount');
            $table->integer('shipping_amount');
            $table->integer('discount_amount')->default(0);
            $table->string('cupon_name')->nullable();
            $table->string('order_status')->default('Pending');
            $table->string('order_date');
            $table->string('order_timestamp');
            $table->string('payment_type');
            $table->string('payment_status')->default('Pending');
            $table->text('delivery_address');
            $table->string('delivery_status')->default('Pending');
            $table->string('currency')->default('BDT');
            $table->string('transaction_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
