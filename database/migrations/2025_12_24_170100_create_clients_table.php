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
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained(); // Tenancy (Agency Owner)
            $table->string('name');
            $table->string('email');
            $table->string('status')->default('active'); // active, inactive
            $table->string('type')->default('customer'); // customer, lead
            $table->json('tags')->nullable(); // Store tags like ["Developer", "Partner"]
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clients');
    }
};
