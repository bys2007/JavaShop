<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('address_id')->constrained('user_addresses');
            $table->foreignId('voucher_id')->nullable()->constrained('vouchers')->nullOnDelete();
            $table->string('order_number', 30)->unique();
            $table->enum('status', ['pending_payment', 'processing', 'shipped', 'delivered', 'cancelled'])->default('pending_payment');
            $table->decimal('subtotal', 12, 2);
            $table->decimal('shipping_cost', 12, 2)->default(0);
            $table->decimal('discount', 12, 2)->default(0);
            $table->decimal('total', 12, 2);
            $table->string('courier', 50)->nullable();
            $table->string('courier_service', 50)->nullable();
            $table->string('tracking_number', 100)->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
