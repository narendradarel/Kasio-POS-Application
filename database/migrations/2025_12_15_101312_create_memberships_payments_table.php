<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('membership_payments', function (Blueprint $table) {
            $table->id();

            // user yang bayar
            $table->foreignId('user_id')
                ->constrained()
                ->cascadeOnDelete();

            // paket membership
            $table->foreignId('membership_id')
                ->constrained()
                ->restrictOnDelete();

            // midtrans
            $table->string('order_id')->unique();
            $table->integer('amount');

            $table->string('gateway')->default('midtrans');
            $table->string('payment_type')->nullable(); // qris
            $table->string('transaction_status'); // pending, settlement, expired, cancel

            $table->json('payload')->nullable(); // raw response midtrans

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('membership_payments');
    }
};
