<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained('orders')->cascadeOnDelete();
            $table->enum('method', ['bank_transfer', 'qris', 'midtrans']);
            $table->string('bank_name', 50)->nullable();
            $table->string('account_number', 50)->nullable();
            $table->string('proof_image', 255)->nullable();
            $table->decimal('amount', 12, 2);
            $table->string('midtrans_transaction_id', 100)->nullable();
            $table->string('midtrans_status', 50)->nullable();
            $table->enum('status', ['pending', 'confirmed', 'rejected'])->default('pending');
            $table->text('rejection_reason')->nullable();
            $table->timestamp('confirmed_at')->nullable();
            $table->foreignId('confirmed_by')->nullable()->constrained('users');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
