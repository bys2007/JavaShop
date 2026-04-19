<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // First, add the payment_method column.
        Schema::table('orders', function (Blueprint $table) {
            $table->string('payment_method', 20)->default('midtrans')->after('status');
        });

        // We can't modify enum directly using change() cleanly in sqlite/older mysql without doctrine/dbal. 
        // A common trick for MySQL ENUMs without doctrine/dbal is using raw DB statements.
        // Assuming MySQL since DB_CONNECTION=mysql in .env.
        DB::statement("ALTER TABLE orders MODIFY COLUMN status ENUM('pending_admin', 'pending_payment', 'processing', 'shipped', 'delivered', 'cancelled') DEFAULT 'pending_admin'");
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE orders MODIFY COLUMN status ENUM('pending_payment', 'processing', 'shipped', 'delivered', 'cancelled') DEFAULT 'pending_payment'");
        
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('payment_method');
        });
    }
};
