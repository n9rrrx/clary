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
        Schema::create('agency_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete(); // Link to admin@clary

            $table->string('company_name')->nullable();
            $table->string('company_email')->nullable();
            $table->string('phone')->nullable();
            $table->text('address')->nullable();

            // For Invoices
            $table->string('tax_id')->nullable(); // VAT / GST
            $table->text('bank_details')->nullable(); // "Bank of America, IBAN: ..."

            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('agency_profiles');
    }
};
