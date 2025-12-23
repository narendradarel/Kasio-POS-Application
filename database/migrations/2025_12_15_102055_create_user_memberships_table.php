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
        Schema::create('user_memberships', function (Blueprint $table) {
            $table->id();
            
            // Relasi (Wajib)
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('membership_id')->constrained()->onDelete('cascade');
            
            // Status & Tanggal (Ini yang bikin error sebelumnya)
            $table->string('status')->default('active'); 
            $table->timestamp('started_at')->nullable(); // <--- INI WAJIB ADA
            $table->timestamp('ends_at')->nullable();    // <--- INI WAJIB ADA
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_memberships');
    }
};