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
            $table->string('order_code')->unique();
            $table->string('customer_name');
            $table->string('customer_email');
            $table->string('customer_phone');
            $table->enum('status', ['quotation', 'waiting_payment', 'in_production', 'completed', 'cancelled'])->default('quotation');
            $table->decimal('total_amount', 15, 2)->nullable();
            $table->enum('payment_status', ['unpaid', 'paid', 'down_payment'])->default('unpaid');
            $table->text('notes')->nullable(); // Catatan tambahan dari pelanggan
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
