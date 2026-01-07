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
        Schema::create('memberships', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // free, basic, premium
            $table->decimal('price', 10, 2); 
            $table->integer('product_limit')->nullable();
            $table->integer('user_limit')->nullable();
            $table->integer('customer_limit')->nullable();
            $table->integer('daily_pos_limit')->nullable();
            $table->boolean('can_export_report')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('memberships');
    }
};
