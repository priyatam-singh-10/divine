<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   public function up()
{
    Schema::create('orders', function (Blueprint $table) {
        $table->bigIncrements('id');
        $table->unsignedBigInteger('user_id');
        $table->unsignedBigInteger('book_id');
        $table->integer('quantity')->default(1);
        $table->decimal('total_price', 10, 2);
        
        $table->enum('status', ['pending', 'completed', 'cancelled'])->default('pending');
        $table->enum('payment_status', ['unpaid', 'paid'])->default('unpaid');
        $table->enum('payment_type', ['cod', 'online'])->default('cod');
        
        $table->string('gateway_order_id')->nullable();
        $table->string('gateway_payment_id')->nullable();
        
        $table->text('shipping_address');
        $table->enum('shipping_status', ['pending', 'shipped', 'delivered', 'cancelled'])->default('pending');

        $table->timestamps();

        // Foreign keys
        $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        $table->foreign('book_id')->references('id')->on('books')->onDelete('cascade');
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
